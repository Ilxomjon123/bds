<?php

namespace App\Http\Controllers;

use App\Models\Election;
use App\Models\ElectionFaculty;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Throwable;

class ElectionController extends Controller
{
    public function getAll()
    {
        $query = Election::select('id', 'candidate', 'title', 'image', 'date', 'description', 'election_type_id');
        if (auth()->user()->role->name != 'admin') {
            $query->where('status', true)->whereHas('election_faculty', function ($query) {
                $query->where('faculty_id', auth()->user()->faculty->id);
            });
        }
        return response()->json($query->get());
    }

    public function getOne(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'id' => 'required|integer'
        ]);
        if ($validate->fails()) {
            return response()->json(['message' => $validate->errors()], 403);
        }
        try {
            $query = Election::select('id', 'candidate', 'image', 'title', 'date', 'description', 'election_type_id')
                ->where('id', $request->id);
            if (auth()->user()->role->name != 'admin') {
                $query->where('status', true)->whereHas('election_faculty', function ($query) {
                    $query->where('faculty_id', auth()->user()->faculty->id);
                });
            }
            return response()->json($query->first());
        } catch (Throwable $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function store(Request $request)
    {
        if (auth()->user()->role->name != 'admin') {
            return response()->json(['message' => 'You don\'t have permiision for this ation'], 403);
        }
        $validate = Validator::make($request->all(), [
            'candidate' => 'required',
            'date' => 'required|date',
            'description' => 'required',
            'election_type_id' => 'required',
            'title' => 'required',
            'faculty_ids' => 'required',
        ]);
        if ($validate->fails()) {
            return response()->json(['message' => $validate->errors()], 403);
        }
        try {
            $model = Election::create($request->all());
            if ($request->has('faculty_ids')) {
                $data = [];
                foreach ($request->faculty_ids as $faculty_id) {
                    $data[] = [
                        'election_id' => $model->id,
                        'faculty_id' => $faculty_id
                    ];
                }
                ElectionFaculty::insert($data);
            }
            return response()->json(['messagae' => 'ok']);
        } catch (Throwable $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function update(Request $request)
    {
        if (auth()->user()->role->name != 'admin') {
            return response()->json(['message' => 'You don\'t have permiision for this ation'], 403);
        }
        $validate = Validator::make($request->all(), [
            'name' => 'required'
        ]);
        $validate = Validator::make($request->all(), [
            'id' => 'required|integer',
            'candidate' => 'required',
            'date' => 'required|date',
            'description' => 'required',
            'election_type_id' => 'required',
            'title' => 'required'
        ]);
        if ($validate->fails()) {
            return response()->json(['message' => $validate->errors()], 403);
        }
        try {
            Election::where('id', $request->id)
                ->update([
                    'candidate' => $request->candidate,
                    'date' => $request->date,
                    'description' => $request->description,
                    'election_type_id' => $request->election_type_id,
                    'image' => $request->image,
                    'title' => $request->title,
                    'status' => $request->status,
                ]);

            ElectionFaculty::where('election_id', $request->id)->delete();
            if ($request->has('faculty_ids')) {
                $data = [];
                foreach ($request->faculty_ids as $faculty_id) {
                    $data[] = [
                        'election_id' => $request->id,
                        'faculty_id' => $faculty_id
                    ];
                }
                ElectionFaculty::insert($data);
            }
            return response()->json(['messagae' => 'ok']);
        } catch (Throwable $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function delete(Request $request)
    {
        if (auth()->user()->role->name != 'admin') {
            return response()->json(['message' => 'You don\'t have permiision for this ation'], 403);
        }

        $validate = Validator::make($request->all(), [
            'id' => 'required'
        ]);
        if ($validate->fails()) {
            return response()->json(['message' => $validate->errors()], 403);
        }
        try {
            Election::where('id', $request->id)->delete();
            return response()->json(['messagae' => 'ok']);
        } catch (Throwable $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
