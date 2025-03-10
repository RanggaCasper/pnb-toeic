<?php

namespace App\Http\Controllers\Admin\BankSoal;

use App\Models\BankSoal;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

use App\Http\Controllers\Controller;
use App\Helpers\ResponseFormatter;
use Yajra\DataTables\DataTables;

class BankSoalController extends Controller
{
    public function index()
    {
        return view('admin.bankSoal.index');
    }
    public function get(): JsonResponse
    {
        try {
            $data = BankSoal::all();
            return DataTables::of($data)  
            ->addColumn('no', function ($row) {  
                static $counter = 0;  
                return ++$counter;
            })
            ->addColumn('name', function ($row) {  
                return ucfirst($row->name);
            })
            ->addColumn('type', function ($row) {  
                return ucfirst($row->type);
            })
            ->addColumn('status', function ($row) {
                $status = $row->is_active == "1" ? " bg-success" : "bg-danger";
                return '<span class="badge rounded-pill '.$status.'">'.( $row->is_active == 1 ? 'active' : 'nonactive').'</span>';  
            })
            ->addColumn('action', function ($row) {  
                return '
                <button type="button" class="btn btn-primary btn-sm edit-btn" data-id="'. $row->id .'" data-bs-toggle="modal" data-bs-target="#updateModal">Update</button>  
                <button type="button" class="btn btn-danger btn-sm delete-btn" data-id="'. $row->id .'">Delete</button>
                ';  
            })  
            ->rawColumns(['action','status'])
            ->make(true);
        } catch (\Exception $e) {
            return ResponseFormatter::handleError($e);
        }
    }

    public function getById($id): JsonResponse
    {
        try {
            $data = BankSoal::findOrFail($id);
            return ResponseFormatter::success('Data successfully retrieved.', $data);
        } catch (\Exception $e) {
            return ResponseFormatter::handleError($e);
        }
    }

    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:tryout,practice',
            'is_active' => 'in:true,null',
        ]);
        try {
            BankSoal::create([
                'name' => $request->name,
                'type' => $request->type,
                'is_active' => $request->is_active != null ? true : false,
            ]);

            return ResponseFormatter::created();
        } catch (\Exception $e) {
            return ResponseFormatter::handleError($e);
        }
    }


    public function update(Request $request, $id): JsonResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:tryout,practice',
            'is_active' => 'in:true,null',
        ]);
            
        try {
            $data = BankSoal::findOrFail($id);
            $updateData = [
                'name' => $request->name,
                'type' => $request->type,
                'is_active' => $request->is_active != null ? true : false,
            ];
            $data->update($updateData);

            return ResponseFormatter::success('Data successfully updated.');
        } catch (\Exception $e) {
            return ResponseFormatter::handleError($e);
        } 
    }

    public function destroy($id): JsonResponse
    {
        try {
            $data = BankSoal::findOrFail($id);
            $data->delete();
            return ResponseFormatter::success('Data successfully deleted.');   
        } catch (\Exception $e) {
            return ResponseFormatter::handleError($e);
        }
    }
}
