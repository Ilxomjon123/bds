<?php

namespace App\Http\Controllers;

use App\Models\Vote;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Throwable;

class VoteController extends Controller
{
    public function getAll()
    {
        return response()->json(DB::table('votes')
            ->select('id', 'election_id', 'user_id', 'result')->get());
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
                DB::table('votes')->select('id', 'election_id', 'user_id', 'result')
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
        $validate = Validator::make($request->all(), [
            'election_id' => 'required|integer',
            'result' => 'required'
        ]);
        if ($validate->fails()) {
            return response()->json(['message' => $validate->errors()], 403);
        }
        try {
            $data = [
                'election_id' => $request->election_id,
                'user_id' => auth()->user()->id,
                'result' => $request->result,
            ];
            Vote::create($data);
            return response()->json(['messagae' => 'ok']);
        } catch (Throwable $e) {
            return response()->json($e->getMessage(), 500);
        }
    }

    public function update(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'id' => 'required|integer',
            'election_id' => 'required|integer',
            'result' => 'required'
        ]);
        if ($validate->fails()) {
            return response()->json(['message' => $validate->errors()], 403);
        }
        try {
            Vote::where('id', $request->id)->where('user_id', auth()->user()->id)
                ->where('election_id', $request->election_id)->update(['result' => $request->result]);
            return response()->json(['messagae' => 'ok']);
        } catch (Throwable $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
