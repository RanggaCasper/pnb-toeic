<?php

namespace App\Http\Controllers\Admin\User;

use Carbon\Carbon;
use App\Models\Role;
use App\Models\User;
use Barryvdh\DomPDF\PDF;
use App\Exports\UsersExport;
use App\Imports\UsersImport;
use App\Models\ProgramStudy;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Excel;
use Yajra\DataTables\DataTables;
use Illuminate\Http\JsonResponse;
use App\Helpers\ResponseFormatter;
use App\Exports\UsersTemplateExport;
use App\Http\Controllers\Controller;
use Illuminate\Routing\Controllers\HasMiddleware;

class UserController extends Controller implements HasMiddleware
{
    public static function middleware()
    {
        return [
            (new \Illuminate\Routing\Controllers\Middleware('checkAjax'))->except(['index','export']),
        ];
    }

    public function index()
    {
        $programStudy = ProgramStudy::all();
        $gender = ['male' => 'Male', 'female' => 'Female'];
        $typeExport = ['excel' => 'Excel', 'pdf' => 'PDF'];
        return view('admin.user.index', [
            'programStudy' => $programStudy->pluck('name', 'id')->toArray(),
            'gender' => $gender,
            'typeExport' => $typeExport
        ]);
    }

    public function get(): JsonResponse
    {
        try {
            $data = User::whereHas('role', function ($query) {
                        $query->where('name', 'user');
                    })->with('programStudy')->get();
            return DataTables::of($data)  
                ->addColumn('no', function ($row) {  
                    static $counter = 0;  
                    return ++$counter;
                })
                ->addColumn('gender', function ($row) {  
                    return ucfirst($row->gender);
                })
                ->addColumn('birthday', function ($row) {  
                    return Carbon::parse($row->birthday)->format('d F Y');
                })
                ->addColumn('action', function ($row) {  
                    return '
                        <button type="button" class="btn btn-primary btn-sm edit-btn" data-id="'. $row->id .'" data-bs-toggle="modal" data-bs-target="#updateModal">Update</button>  
                        <button type="button" class="btn btn-danger btn-sm delete-btn" data-id="'. $row->id .'">Delete</button>
                    ';  
                })  
                ->rawColumns(['action'])
                ->make(true);
        } catch (\Exception $e) {
            return ResponseFormatter::handleError($e);
        }
    }

    public function getById($id): JsonResponse
    {
        try {
            $data = User::with('programStudy')->findOrFail($id);
            return ResponseFormatter::success('Data successfully retrieved.', $data);
        } catch (\Exception $e) {
            return ResponseFormatter::handleError($e);
        }
    }

    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'identity' => 'required|string|max:255|unique:users,identity',
            'name' => 'required|string|max:255',
            'email' => 'nullable|email:dns|unique:users,email',
            'birthday' => 'required|max:255|date',
            'gender' => 'required|in:male,female',
            'program_study' => 'required|exists:program_studies,id',
        ]);

        try {
            User::create([
                'identity' => $request->identity,
                'name' => $request->name,
                'email' => $request->email,
                'birthday' => $request->birthday,
                'password' => bcrypt($request->identity), // default password adalah identitas
                'gender' => $request->gender,
                'program_study_id' => $request->program_study,
                'role_id' => Role::where('name', 'user')->first()->id
            ]);

            return ResponseFormatter::created();
        } catch (\Exception $e) {
            return ResponseFormatter::handleError($e);
        }
    }

    public function update(Request $request, $id): JsonResponse
    {
        $request->validate([
            'identity' => 'required|string|max:255|unique:users,identity,' . $id,
            'name' => 'required|string|max:255',
            'email' => 'nullable|email:dns|unique:users,email,' . $id,
            'birthday' => 'required|max:255|date',
            'gender' => 'required|in:male,female',
            'program_study' => 'required|exists:program_studies,id',
        ]);
            
        try {
            $data = User::findOrFail($id);

            $data->update([
                'identity' => $request->identity,
                'name' => $request->name,
                'email' => $request->email,
                'birthday' => $request->birthday,
                'gender' => $request->gender,
                'program_study_id' => $request->program_study
            ]);

            return ResponseFormatter::success('Data successfully updated.');
        } catch (\Exception $e) {
            return ResponseFormatter::handleError($e);
        } 
    }

    public function destroy($id): JsonResponse
    {
        try {
            $data = User::findOrFail($id);
            $data->delete();
            return ResponseFormatter::success('Data successfully deleted.');   
        } catch (\Exception $e) {
            return ResponseFormatter::handleError($e);
        }
    }

    public function import(Request $request, Excel $excel)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx',
        ]);

        $import = new UsersImport();  

        try {
            $excel->import($import, $request->file('file'));

            $failures = $import->getFailures(); 
            if (count($failures) > 0) {  
                $failureDetails = [];  
                foreach ($failures as $failure) {  
                    $failureDetails[] = [  
                        'row' => $failure->row(),
                        'attribute' => $failure->attribute(),
                        'errors' => $failure->errors(),
                        'values' => $failure->values(),
                    ];  
                }  

                return ResponseFormatter::success('Some rows failed to import.', $failureDetails);  
            }  

            return ResponseFormatter::success('Data successfully imported.');
        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {  
            $failures = $e->failures();  
            return ResponseFormatter::success('Data successfully imported.', $failures);  
        } catch (\Exception $e) {
            return ResponseFormatter::handleError($e);
        }
    }

    public function export(Request $request, Excel $excel, PDF $pdf)
    {
        $type = $request->query('q');
        $filter = $request->query('f');

        if ($type == 'template') {
            return $excel->download(new UsersTemplateExport, 'users_template.xlsx');
        } else if ($type == 'excel') {
            if ($filter) {
                return $excel->download(new UsersExport($filter), 'users.xlsx');
            }
            return $excel->download(new UsersExport, 'users.xlsx');
        } else if ($type == 'pdf') {
            $query = User::with('programStudy');
            if ($filter) {
                $query->where('program_study_id', $filter);
            }

            $data = $query->get();

            $pdf = $pdf->loadView('exports.user', [
                'data' => $data,
                'title' => 'List of Users',
            ]);

            $fileName = "users.pdf";
            return $pdf->download($fileName);
        }

        return ResponseFormatter::error('Invalid type of export.');
    }
}
