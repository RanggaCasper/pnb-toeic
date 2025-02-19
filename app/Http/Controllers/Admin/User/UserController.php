<?php

namespace App\Http\Controllers\Admin\User;

use Carbon\Carbon;
use App\Models\Role;
use App\Models\User;
use App\Models\ProgramStudy;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Http\JsonResponse;
use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use Illuminate\Routing\Controllers\HasMiddleware;

class UserController extends Controller implements HasMiddleware
{
    public static function middleware()
    {
        return [
            (new \Illuminate\Routing\Controllers\Middleware('checkAjax'))->except(['index']),
        ];
    }

    public function index()
    {
        $programStudy = ProgramStudy::all();
        $gender = ['male' => 'Male', 'female' => 'Female'];
        return view('admin.user.index', [
            'programStudy' => $programStudy->pluck('name', 'id')->toArray(),
            'gender' => $gender
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
}
