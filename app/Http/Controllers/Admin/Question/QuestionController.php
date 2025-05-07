<?php

namespace App\Http\Controllers\admin\Question;

use App\Models\Question;
use Illuminate\Support\Str;
use App\Models\QuestionBank;
use Illuminate\Http\Request;
use App\Models\Section\Section;
use Illuminate\Validation\Rule;
use Yajra\DataTables\DataTables;
use Illuminate\Http\JsonResponse;
use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Support\Facades\Storage;
use RahulHaque\Filepond\Facades\Filepond;

class QuestionController extends Controller implements HasMiddleware
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

    public function index(Request $request)
    {
        $section = Section::find($request->id);
        
        return view("admin.question.index", compact('section'));
    }

    public function get(Request $request): JsonResponse
    {
        try {
<<<<<<< Updated upstream
            $data = Question::with('section')->where('section_id', $request->id)->get();
=======
            $data = Question::with('section')
                ->when($request->has('section_id'), function($query) use ($request) {
                    return $query->where('section_id', $request->section_id);
                })
                ->get();
>>>>>>> Stashed changes
            return DataTables::of($data)
                ->addColumn('no', function ($row) {
                    static $counter = 0;
                    return ++$counter;
                })
                ->addColumn('action', function ($row) {
                    return '
                        <button type="button" class="btn btn-secondary btn-sm preview-btn" data-id="' . $row->id . '" data-bs-toggle="modal" data-bs-target="#previewModal">Preview</button>
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

    public function preview($id)
    {
        try {
            return ResponseFormatter::success('Data successfully retrieved.', view('admin.question.preview',[
                'data' => Question::findOrFail($id)
            ])->render());
        } catch (\Exception $e) {
            return ResponseFormatter::handleError($e);
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
            'section_id' => 'required|exists:sections,id',
            'questions' => 'nullable|string',
            'a' => 'nullable|string',
            'b' => 'nullable|string', 
            'c' => 'nullable|string',
            'd' => 'nullable|string',
            'answer' => 'required|in:A,B,C,D',
        ]);

        try {
            // Upload gambar jika ada
            if ($request->has('image')) {
                $path = Filepond::field($request->image)->moveTo('questions/images/' . Str::uuid());
                $request->merge(['image' => $path['location']]);
            }

            Question::create([
                'section_id' => $request->section_id,
                'questions' => $request->questions ?? '',
                'image' => $request->image,
                'a' => $request->a ?? 'Option A',
                'b' => $request->b ?? 'Option B',
                'c' => $request->c ?? 'Option C', 
                'd' => $request->d ?? 'Option D',
                'answer' => $request->answer,
            ]);

            // Update question bank
            Section::findOrFail($request->section_id)->questionBank()->update([]);

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
            'section_id' => 'required|exists:sections,id',
            'questions' => 'nullable|string',
            'a' => 'nullable|string',
            'b' => 'nullable|string',
            'c' => 'nullable|string',
            'd' => 'nullable|string',
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
                'section_id' => $request->section_id,
                'questions' => $request->questions ?? '',
                'a' => $request->a ?? 'Option A',
                'b' => $request->b ?? 'Option B',
                'c' => $request->c ?? 'Option C',
                'd' => $request->d ?? 'Option D',
                'answer' => $request->answer,
            ]);

            // Update question bank
            Section::findOrFail($request->section_id)->questionBank()->update([]);

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

    public function checkAnswer(Request $request, $id): JsonResponse
    {
        try {
            $request->validate([
                'answer' => 'required|in:A,B,C,D',
            ]);

            $question = Question::findOrFail($id);

            if ($request->answer == $question->answer) {
                return ResponseFormatter::success('Correct answer!');
            } else {
                return ResponseFormatter::error('Incorrect answer, try again!');
            }
            return ResponseFormatter::success('Data successfully retrieved.');
        } catch (\Exception $e) {
            return ResponseFormatter::handleError($e);
        }

    }
    
}
