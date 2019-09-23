<?php

namespace App\Http\Controllers;
Use App\Todo;
use Illuminate\Http\Request;

class TodosController extends Controller
{
    public function all()
    {
        $todos = Todo::all();
        return response()->json([
            "todos"=>$todos
        ],200);
    }
    public function store(Request $request)
    {
        
        $todo = Todo::create($request->only(['title']));
        return response()->json([
            "todo" =>$todo
        ],200);
    }
    public function update(Request $request)
    {
        $todo = Todo::findOrFail($request->id);
        $todo->title = $request->title;
        $todo->save();
    }

    public function destroy($id)
    {
        $todo = Todo::findOrFail($id);
        if($todo->delete()){
            return response()->json([
                "todo" =>$todo
            ],200);
        }
       
    }

    public function mark_complete($id)
    {
        $todo = Todo::findOrFail($id);
        if($todo->is_completed==0){
            $todo->is_completed = 1;
        }else{
            $todo->is_completed = 0;
        }
        $todo->save();

    }
}
