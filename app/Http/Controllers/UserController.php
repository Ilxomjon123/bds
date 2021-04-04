<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Throwable;

class UserController extends Controller
{
    public function getAll()
    {
        return response()->json(DB::table('users')
            ->select('id', 'name', 'email', 'level', 'role_id', 'faculty_id')->get());
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
                DB::table('users')
                    ->select('id', 'name', 'email', 'level', 'role_id', 'faculty_id')
                    ->where('id', $request->id)->first()
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
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'role_id' => 'required',
            'faculty_id' => 'required'
        ]);
        if ($validate->fails()) {
            return response()->json(['message' => $validate->errors()], 403);
        }
        User::create($request->all());
        return response()->json(['messagae' => 'ok']);
    }

    public function update(Request $request)
    {
        if (auth()->user()->role->name != 'admin') {
            return response()->json(['message' => 'You don\'t have permiision for this ation'], 403);
        }
        $validate = Validator::make($request->all(), [
            'id' => 'required|integer',
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'role_id' => 'required',
            'faculty_id' => 'required'
        ]);
        if ($validate->fails()) {
            return response()->json(['message' => $validate->errors()], 403);
        }
        try {
            User::where('id', $request->id)
                ->update([
                    'name' => $request->name,
                    'email' => $request->email,
                    'level' => $request->level,
                    'role_id' => $request->role_id,
                    'faculty_id' => $request->faculty_id,

                ]);
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
            User::where('id', $request->id)->delete();
            return response()->json(['messagae' => 'ok']);
        } catch (Throwable $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
