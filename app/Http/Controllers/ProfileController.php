<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\ProgramStudy;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Helpers\ResponseFormatter;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function index()
    {
        $programStudy = ProgramStudy::all();
        $gender = ['male' => 'Male', 'female' => 'Female'];
        return view('profile.profile',['programStudy' => $programStudy->pluck('name', 'id')->toArray(),'gender' => $gender,]);
    }

    public function update(Request $request,$id): JsonResponse
    {
        $request->validate([
            'email' => 'nullable|email:dns|unique:users,email,' . $id,
            'birthday' => 'required|max:255|date',
            'gender' => 'required|in:male,female',
            'program_study' => 'required|exists:program_studies,id',
        ]);
            
        try {
            $data = User::findOrFail($id);
            $updateData = [
                'email' => $request->email,
                'birthday' => $request->birthday,
                'gender' => $request->gender,
                'program_study_id' => $request->program_study,
            ];
            $data->update($updateData);

            return ResponseFormatter::success('Data successfully updated.');
        } catch (\Exception $e) {
            return ResponseFormatter::handleError($e);
        } 
    }

    public function store(Request $request) {
        $request->validate([
            'old_password' => 'required',
            'password' => 'required|same:confirm_password',
        ]);
        
        try {
            $user = User::find(Auth::user()->id);

            if (!Hash::check($request->old_password, $user->password)) {
                return response()->json([
                    'status' => false,
                    'message' => 'Old password is incorrect.'
                ], Response::HTTP_UNAUTHORIZED);
            }
    
            $user->update(['password' => Hash::make($request->password)]);
    
            return response()->json([
                'status' => true,
                'message' => 'Password successfully updated.'
            ]);
        } catch (\Exception $e) {
            return ResponseFormatter::handleError($e);    
        }
    }
}