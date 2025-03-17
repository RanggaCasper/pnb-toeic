<?php

namespace App\Http\Controllers\Admin\Section;

use App\Models\QuestionBank;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\Section\Section;
use Illuminate\Validation\Rule;
use Yajra\DataTables\DataTables;
use Illuminate\Http\JsonResponse;
use App\Helpers\ResponseFormatter;
use App\Models\Section\SectionName;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use RahulHaque\Filepond\Facades\Filepond;
use Illuminate\Routing\Controllers\HasMiddleware;

class SectionController extends Controller implements HasMiddleware
{
    public static function middleware()
    {
        return [
            (new \Illuminate\Routing\Controllers\Middleware('checkAjax'))->except(['index']),
        ];
    }

    public function index()
    {
        $names = SectionName::all();
        $banks = QuestionBank::all();

        return view('admin.section.section.index',[
            'names' => $names->pluck('name', 'id')->toArray(),
            'banks' => $banks->pluck('name', 'id')->toArray()
        ]);
    }

    public function get(Request $request): JsonResponse
    {
        try {
            $data = Section::with('sectionName')->where('bank_id', $request->uuid)->get();
            return DataTables::of($data)
            ->addColumn('no', function ($row) {
                static $counter = 0;
                return ++$counter;
            })
            ->addColumn('action', function ($row) {
                return '
                <button type="button" class="btn btn-info btn-sm preview-btn" data-id="'. $row->id .'" data-bs-toggle="modal" data-bs-target="#previewModal">Preview</button>
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

    public function preview($id)
    {
        try {
            return ResponseFormatter::success('Data successfully retrieved.', view('admin.section.section.preview',[
                'data' => Section::with('sectionName')->findOrFail($id)
            ])->render());
        } catch (\Exception $e) {
            return ResponseFormatter::handleError($e);
        }
    }

    public function getById($id): JsonResponse
    {
        try {
            $data = Section::with('sectionName','questionBank')->findOrFail($id);
            return ResponseFormatter::success('Data successfully retrieved.', $data);
        } catch (\Exception $e) {
            return ResponseFormatter::handleError($e);
        }
    }

    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'image' => Rule::filepond([
                'required',
                'image',
                'max:2000'
            ]),
            'audio' => Rule::filepond([
                'nullable',
                'mimes:mp3',
                'max:5000'
            ]),
            'bank_id' => 'required|exists:question_banks,id',
            'section_name_id' => 'required|exists:section_names,id',
        ]);

        try {
            $existingSection = Section::where('bank_id', $request->bank_id)
                ->where('section_name_id', $request->section_name_id)
                ->exists();

            if ($existingSection) {
                return ResponseFormatter::error('Section already exists.');
            }

            if ($request->has('image')) {
                $path = Filepond::field($request->image)->moveTo('images/' . Str::uuid());
                $request->merge(['image' => $path['location']]);
            }

            if ($request->has('audio')) {
                $path = Filepond::field($request->audio)->moveTo('audio/' . Str::uuid());
                $request->merge(['audio' => $path['location']]);
            }

            Section::create([
                'image' => $request->image,
                'audio' => $request->audio,
                'bank_id' => $request->bank_id,
                'section_name_id' => $request->section_name_id
            ]);

            return ResponseFormatter::created();
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
            'bank_id' => 'required|exists:question_banks,id',
            'section_name_id' => 'required|exists:section_names,id',
        ]);

        try {
            $existingSection = Section::where('bank_id', $request->bank_id)
                ->where('section_name_id', $request->section_name_id)
                ->where('id', '!=', $id)
                ->exists();

            if ($existingSection) {
                return ResponseFormatter::error('Section already exists.');
            }
            
            $section = Section::findOrFail($id);
            
            if ($request->has('image')) {
                if ($section->image && Storage::disk('public')->exists($section->image)) {
                    Storage::disk('public')->delete($section->image);
                }

                $imagePath = Filepond::field($request->image)->moveTo('images/' . Str::uuid());
                $request->merge(['image' => $imagePath['location']]);
            } else {
                $request->merge(['image' => $section->image]);
            }

            if ($request->has('audio')) {
                if ($section->audio && Storage::disk('public')->exists($section->audio)) {
                    Storage::disk('public')->delete($section->audio);
                }

                $audioPath = Filepond::field($request->audio)->moveTo('audio/' . Str::uuid());
                $request->merge(['audio' => $audioPath['location']]);
            } else {
                $request->merge(['audio' => $section->audio]);
            }

            $section->update([
                'image' => $request->image,
                'audio' => $request->audio,
                'bank_id' => $request->bank_id,
                'section_name_id' => $request->section_name_id,
            ]);

            return ResponseFormatter::success('Data successfully updated.');
        } catch (\Exception $e) {
            return ResponseFormatter::handleError($e);
        }
    }

    public function destroy($id): JsonResponse
    {
        try {
            $data = Section::findOrFail($id);
            
            if ($data->image && Storage::disk('public')->exists($data->image)) {
                Storage::disk('public')->delete($data->image);
            }

            if ($data->audio && Storage::disk('public')->exists($data->audio)) {
                Storage::disk('public')->delete($data->audio);
            }

            $data->delete();
            return ResponseFormatter::success('Data successfully deleted.');
        } catch (\Exception $e) {
            return ResponseFormatter::handleError($e);
        }
    }
}
