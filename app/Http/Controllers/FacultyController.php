<?php

namespace App\Http\Controllers;

use App\Models\Faculty;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Throwable;

class FacultyController extends Controller
{
    public function getAll()
    {
        return response()->json(DB::table('faculties')->select('id', 'name')->get());
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
            return response()->json([
                DB::table('faculties')->select('id', 'name')->where('id', $request->id)->first()
            ]);
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
            'name' => 'required'
        ]);
        if ($validate->fails()) {
            return response()->json(['message' => $validate->errors()], 403);
        }
        Faculty::create($request->all());
        return response()->json(['messagae' => 'ok']);
    }

    public function update(Request $request)
    {
        if (auth()->user()->role->name != 'admin') {
            return response()->json(['message' => 'You don\'t have permiision for this ation'], 403);
        }
        $validate = Validator::make($request->all(), [
            'id' => 'required|integer',
            'name' => 'required'
        ]);
        if ($validate->fails()) {
            return response()->json(['message' => $validate->errors()], 403);
        }
        try {
            Faculty::where('id', $request->id)->update(['name' => $request->name]);
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
            Faculty::where('id', $request->id)->delete();
            return response()->json(['messagae' => 'ok']);
        } catch (Throwable $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
