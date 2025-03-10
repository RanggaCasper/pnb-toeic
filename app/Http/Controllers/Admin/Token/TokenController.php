<?php

namespace App\Http\Controllers\Admin\Token;

use App\Models\Token;
use App\Models\BankSoal;
use Illuminate\Http\Request;
use Illuminate\Support\Str; 
use Illuminate\Support\Carbon;
use Yajra\DataTables\DataTables;
use Illuminate\Http\JsonResponse;
use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Routing\Controllers\HasMiddleware;

class TokenController extends Controller implements HasMiddleware
{
    public static function middleware()
    {
        return [
            (new \Illuminate\Routing\Controllers\Middleware('checkAjax'))->except(['index']),
        ];
    }

    public function index()
    {
        $bank = BankSoal::all();
        return view('admin.token.index',['bank' => $bank->pluck('name', 'id')->toArray()]);
    }

    public function get(): JsonResponse
    {
        try {
            $data = Token::with(['bankSoal'])->get();
            return DataTables::of($data)  
            ->addColumn('no', function ($row) {  
                static $counter = 0;  
                return ++$counter;
            })
            ->addColumn('bank', function ($row) {  
                return $row->bankSoal->name;
            })
            ->addColumn('token', function ($row) {  
                return $row->token;
            })
            ->addColumn('start', function ($row) { 
                return Carbon::parse($row->start_at)->format('d F Y H:m:s');
            })
            ->addColumn('end', function ($row) {  
                return Carbon::parse($row->end_at)->format('d F Y H:m:s');
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
            $data = Token::findOrFail($id);
            return ResponseFormatter::success('Data successfully retrieved.', $data);
        } catch (\Exception $e) {
            return ResponseFormatter::handleError($e);
        }
    }

    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'start_at' => 'required|date',
            'end_at' => 'required|date',
            'bank_id' => 'required|exists:bank_soals,id',
        ]);
        try {
            Token::create([
                'token' => Str::random(7),
                'start_at' => $request->start_at,
                'end_at' => $request->end_at,
                'bank_id' => $request->bank_id,
            ]);

            return ResponseFormatter::created();
        } catch (\Exception $e) {
            return ResponseFormatter::handleError($e);
        }
    }    

    public function update(Request $request, $id): JsonResponse
    {
        $request->validate([
            'start_at' => 'required|date',
            'end_at' => 'required|date',
            'bank_id' => 'required|exists:bank_soals,id',
        ]);

        try {
            $data = Token::findOrFail($id);
            $updateData = [
                'start_at' => $request->start_at,
                'end_at' => $request->end_at,
                'bank_id' => $request->bank_id,
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
            $data = Token::findOrFail($id);
            $data->delete();
            return ResponseFormatter::success('Data successfully deleted.');   
        } catch (\Exception $e) {
            return ResponseFormatter::handleError($e);
        }
    }
}
