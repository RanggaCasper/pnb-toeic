<?php

namespace App\Http\Controllers\Admin\Section;

use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Http\JsonResponse;
use App\Helpers\ResponseFormatter;
use App\Models\Section\SectionName;
use App\Http\Controllers\Controller;
use Illuminate\Routing\Controllers\HasMiddleware;

class SectionNameController extends Controller implements HasMiddleware
{
    public static function middleware()
    {
        return [
            (new \Illuminate\Routing\Controllers\Middleware('checkAjax'))->except(['index']),
        ];
    }

    public function index()
    {
        $type = [
            'listening' => 'Listening',
            'reading' => 'Reading',
        ];

        return view('admin.section.sectionName.index',[
            'type' => $type
        ]);
    }

    public function get(): JsonResponse
    {
        try {
            $data = SectionName::get();
            return DataTables::of($data)  
            ->addColumn('no', function ($row) {  
                static $counter = 0;  
                return ++$counter;
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
            $data = SectionName::findOrFail($id);
            return ResponseFormatter::success('Data successfully retrieved.', $data);
        } catch (\Exception $e) {
            return ResponseFormatter::handleError($e);
        }
    }

    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:listening,reading',
        ]);
        try {
            SectionName::create([
                'name' => $request->name,
                'type' => $request->type
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
            'type' => 'required|in:listening,reading',
        ]);

        try {
            $data = SectionName::findOrFail($id);
            $updateData = [
                'name' => $request->name,
                'type' => $request->type
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
            $data = SectionName::findOrFail($id);
            $data->delete();
            return ResponseFormatter::success('Data successfully deleted.');   
        } catch (\Exception $e) {
            return ResponseFormatter::handleError($e);
        }
    }
}
