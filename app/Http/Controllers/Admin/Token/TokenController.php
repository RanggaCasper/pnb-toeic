<?php

namespace App\Http\Controllers\Admin\Token;

use App\Models\Token;
use App\Models\BankSoal;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Str; 
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\Controller;
use App\Helpers\ResponseFormatter;
use Yajra\DataTables\DataTables;
class TokenController extends Controller
{

    public function index()
    {
        $id = Auth::user()->role_id;
        if($id == 2){
            $bank = BankSoal::all();
            return view('admin.token.index',['bank' => $bank->pluck('name', 'id')->toArray()]);
        }else{
            return view('user.token.index');
        }
    }

    public function get(): JsonResponse
    {
        try {
            $data = Token::with(['bank_soal'])->get();
            return DataTables::of($data)  
            ->addColumn('no', function ($row) {  
                static $counter = 0;  
                return ++$counter;
            })
            ->addColumn('bank', function ($row) {  
                return $row->bank_soal->name;
            })
            ->addColumn('token', function ($row) {  
                return $row->token;
            })
            ->addColumn('start', function ($row) { 
                return Carbon::parse($row->mulai)->format('d F Y H:m:s');
            })
            ->addColumn('end', function ($row) {  
                return Carbon::parse($row->selesai)->format('d F Y H:m:s');
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
    public function getByToken($token): JsonResponse
    {
        try {
            $data = Token::where('token',$token)->firstOrFail();
            return ResponseFormatter::success('Data successfully retrieved.', $data);
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
            'mulai' => 'required|date',
            'selesai' => 'required|date',
            'bank_id' => 'required|exists:bank_soals,id',
        ]);
        try {
            Token::create([
                'token' => $password = Str::random(7),
                'mulai' => $request->mulai,
                'selesai' => $request->selesai,
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
            'mulai' => 'required|date',
            'selesai' => 'required|date',
            'bank_id' => 'required|exists:bank_soals,id',
        ]);

        try {
            $data = Token::findOrFail($id);
            $updateData = [
                'mulai' => $request->mulai,
                'selesai' => $request->selesai,
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
