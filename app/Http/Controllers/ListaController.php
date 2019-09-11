<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use App\Task;

class ListaController extends Controller
{
    public function list(){
        return response()->json(Task::all());
    }

    public function get($id){
    
        return response()->json(Task::find($id));
    }

    public function create(Request $request){
        if(Gate::denies('tryUser', Auth::user())){
            return "Auth error";
        }
        $task = Task::create($request->all());
        return "AlgumIdFoiCriado";
    }

    public function delete($id){
        if(Gate::denies('tryUser', Auth::user())){
            return "Auth error";
        }
        $deltask = Task::find($id);
        $deltask->delete();
        return "AlgumIdFoiApagado";
    }

    public function edit($id, Request $request){
        if(Gate::denies('tryUser', Auth::user())){
            return "Auth error";
        }
        $uptask = Task::find($id);
        $uptask->update($request->all());
        return "AlgumIdFoiEditado";
    }

    //
}