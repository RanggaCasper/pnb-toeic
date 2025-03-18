<?php

namespace App\Http\Controllers\admin\Question;

use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use App\Models\Question;
use Illuminate\Validation\Rule;
use RahulHaque\Filepond\Facades\Filepond;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Helpers\ResponseFormatter;
use Illuminate\Support\Facades\Storage;
use App\Models\Section\Section;

class QuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public static function middleware()
    {
        return [
            (new \Illuminate\Routing\Controllers\Middleware('checkAjax'))->except(['index']),
        ];
    }
    public function index()
    {

        $sections = Section::all();

        return view('admin.question.index', compact('sections'));
    }

    public function get(): JsonResponse
    {
        try {
            $data = Question::with('section')->get();
            return DataTables::of($data)
                ->addColumn('section_name', function ($row) {
                    return $row->section ? $row->section->section_name_id : '-';
                })
                ->addColumn('question_text', function ($row) {
                    return $row->questions;
                })
                ->addColumn('options', function ($row) {
                    return "A: $row->a <br> B: $row->b <br> C: $row->c <br> D: $row->d";
                })
                ->addColumn('answer', function ($row) {
                    return "Jawaban: <strong>$row->answer</strong>";
                })
                ->addColumn('action', function ($row) {
                    return '
                <button type="button" class="btn btn-info btn-sm preview-btn" data-id="' . $row->id . '" data-bs-toggle="modal" data-bs-target="#previewModal">Preview</button>
                <button type="button" class="btn btn-primary btn-sm edit-btn" data-id="' . $row->id . '" data-bs-toggle="modal" data-bs-target="#updateModal">Update</button>
                <button type="button" class="btn btn-danger btn-sm delete-btn" data-id="' . $row->id . '">Delete</button>
                ';
                })
                ->rawColumns(['answer', 'action'])
                ->make(true);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }


    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'image' => Rule::filepond([
                'nullable',
                'image',
                'max:2000' // Maksimal 2MB
            ]),
            'id_section' => 'required|exists:sections,id',
            'questions' => 'required|string',
            'a' => 'required|string',
            'b' => 'required|string',
            'c' => 'required|string',
            'd' => 'required|string',
            'answer' => 'required|in:A,B,C,D',
        ]);

        try {
            // Upload gambar jika ada
            $imagePath = null;
            if ($request->has('image')) {
                $path = Filepond::field($request->image)->moveTo('questions/images/' . Str::uuid());
                $imagePath = $path['location'];
            }

            Question::create([
                'id_section' => $request->id_section,
                'questions' => $request->questions,
                'image' => $imagePath,
                'a' => $request->a,
                'b' => $request->b,
                'c' => $request->c,
                'd' => $request->d,
                'answer' => $request->answer,
            ]);

            return ResponseFormatter::created();
        } catch (\Exception $e) {
            return ResponseFormatter::handleError($e);
        }
    }

    public function getById($id): JsonResponse
    {
        try {
            $data = Question::with('section')->findOrFail($id);
            return ResponseFormatter::success('Data successfully retrieved.', $data);
        } catch (\Exception $e) {
            return ResponseFormatter::handleError($e);
        }
    }
    public function update(Request $request, $id): JsonResponse
    {
        $request->validate([
            'image' => Rule::filepond([
                'nullable',
                'image',
                'max:2000'
            ]),
            'audio' => Rule::filepond([
                'nullable',
                'mimes:mp3',
                'max:5000'
            ]),
            'id_section' => 'required|exists:sections,id',
            'questions' => 'required|string',
            'a' => 'required|string',
            'b' => 'required|string',
            'c' => 'required|string',
            'd' => 'required|string',
            'answer' => 'required|in:A,B,C,D',
        ]);

        try {
            $question = Question::findOrFail($id);

            // Handle image update
            if ($request->has('image')) {
                if ($question->image && Storage::disk('public')->exists($question->image)) {
                    Storage::disk('public')->delete($question->image);
                }
                $imagePath = Filepond::field($request->image)->moveTo('images/' . Str::uuid());
                $request->merge(['image' => $imagePath['location']]);
            } else {
                $request->merge(['image' => $question->image]);
            }

            
           
            $question->update([
                'image' => $request->image,
                'audio' => $request->audio,
                'id_section' => $request->id_section,
                'questions' => $request->questions,
                'a' => $request->a,
                'b' => $request->b,
                'c' => $request->c,
                'd' => $request->d,
                'answer' => $request->answer,
            ]);

            return ResponseFormatter::success('Question updated successfully.');
        } catch (\Exception $e) {
            return ResponseFormatter::handleError($e);
        }
    }
    public function destroy($id): JsonResponse
    {
        try {
            $data = Question::findOrFail($id);
            
            if ($data->image && Storage::disk('public')->exists($data->image)) {
                Storage::disk('public')->delete($data->image);
            }

            $data->delete();
            return ResponseFormatter::success('Data successfully deleted.');
        } catch (\Exception $e) {
            return ResponseFormatter::handleError($e);
        }
    }
}
