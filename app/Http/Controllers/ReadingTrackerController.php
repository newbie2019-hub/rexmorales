<?php

namespace App\Http\Controllers;

use App\Models\trackreads;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReadingTrackerController extends Controller
{
    public function __construct()
    {
        $this->middleware('jwt');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'booktitle' => 'required|min:6',
            'genre' => 'required|min:6',
            'author' => 'required',
            'synopsis' => 'required|min:6',
            'rating' => 'required',
            'review' => 'required|min:6',
            'status' => 'required',
        ]);

        trackreads::create([
            'booktitle' => $request->booktitle,
            'genre' => $request->genre,
            'author' => $request->author,
            'synopsis' => $request->synopsis,
            'rating' => $request->rating,
            'review' => $request->review,
            'user_id' => $request->userid,
            'status' => $request->status,
        ]);

        return response()->json(['success' => 'Book saved successfully!'], 200);
    }


    public function get(Request $request)
    {
        $user = Auth::user();
        return trackreads::where(['user_id' => $user->id, 'status'=>'Reads'])->paginate($request->total);
    }

    public function getToRead(Request $request)
    {
        $user = Auth::user();
        return trackreads::where(['user_id' => $user->id, 'status'=>'To Be Read'])->paginate($request->total);
    }

    public function getDidNotFinish(Request $request)
    {
        $user = Auth::user();
        return trackreads::where(['user_id' => $user->id, 'status'=>'Did Not Finish'])->paginate($request->total);
    }
    //HTTP REQUEST POST, PUT, DELETE, GET
    public function put(Request $request)
    {
        $data = [
            'booktitle' => $request->booktitle,
            'genre' => $request->genre,
            'author' => $request->author,
            'synopsis' => $request->synopsis,
            'rating' => $request->rating,
            'review' => $request->review,
            'status' => $request->status,
        ];

        return trackreads::where(['id'=>$request->bookid])->update($data);
    }
    
    public function delete(Request $request)
    {
        trackreads::where(['id' => $request->id])->delete();
        return response()->json(["msg" => "Delete successful"], 200);
    }
}
