<?php

namespace App\Http\Controllers;

use App\Models\grocerylists;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GroceryListController extends Controller
{
    public function __construct()
    {
        $this->middleware('jwt');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|min:6',
            'date' => 'required|min:6',
            'list' => 'required',
        ]);

        $user = Auth::user();    

        grocerylists::create([
            'title' => $request->title,
            'date' => $request->date,
            'list' => $request->list,
            'user_id' => $user->id,
        ]);

        return response()->json(['success' => 'List saved successfully!'], 200);
    }


    public function get(Request $request)
    {
        $user = Auth::user();
        return grocerylists::where(['user_id' => $user->id])->paginate($request->total);
    }

    //HTTP REQUEST POST, PUT, DELETE, GET
    public function put(Request $request)
    {
        $data = [
            'booktitle' => $request->booktitle,
            'genre' => $request->genre,
            'author' => $request->author,
            'synopsis' => $request->synopsis,
        ];

        return grocerylists::where(['id'=>$request->bookid])->update($data);
    }
    
    public function delete(Request $request)
    {
        grocerylists::where(['id' => $request->id])->delete();
        return response()->json(["msg" => "Delete successful"], 200);
    }
}
