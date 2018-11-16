<?php

namespace App\Http\Controllers;

//use Illuminate\Support\Facades;
use App\CustomResponses;
use App\TodoList;
use Illuminate\Http\Request;

use Response;
use Validator;
use Log;
class TodoListController extends Controller
{


    //show all items
    function index(){

        //return "From TodoListController inside index method";
        //return \Illuminate\Support\Facades\DB::select('show tables;');

        $todo_lists = TodoList::all();
        if(sizeof($todo_lists) > 0)
            return Response::json($todo_lists);
        else
            return CustomResponses::getNotFoundError();

    }

    //Show one item
    function show($id){
        //return "From TodoListController inside show method ".$id;
        $list = TodoList::find($id);
        //return $list;


        if(isset($list->name)){
            return response()->json([
                'name' => $list->name,
                'id' => $list->id
            ]);
        }
        else{
          return  CustomResponses::getNotFoundError();
        }

    }

    //update one item
    //Should give old Id and new Name
    function update(Request $request){


        Log::info('This is some useful information.');
        Log::info  ($request->getMethod());
        Log::info($request->getRequestUri());

        //$request->



        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'id' => 'required',
        ]);

        if ($validator->fails()) {
            return CustomResponses::getBadRequest();
        }


        $list = TodoList::find($request->input("id"));
        if(isset($list->name)){
            $list->name = $request->input("name");
            $list->id = $request->input("id");
            $list->save();
            return "$list";
        }
        else{
            return  CustomResponses::getNotFoundError();
        }




    }
    //delete one item
    function destroy($id){
        $list = TodoList::find($id);
        if(isset($list->name)){
            $list->delete();
            return CustomResponses::getFoundSuccess();
        }
        else{
            return CustomResponses::getNotFoundError();
        }



    }


    //Add one item
    function store(Request $request){

        $validator = Validator::make($request->all(), [
            'name' => 'required',
        ]);

        if ($validator->fails()) {
            return  CustomResponses::getBadRequest();
        }


        $list = new TodoList;
        $list->name = $request->input("name");
        $list->save();
        return "$list";



    }



    function create(){
/*
        $list = new TodoList;
        $list->name = "Abhijit";
       // $list->id = 1;
        //var_dump($list);
        $list->save();
        //return $list;*/

        /*$list->name = "Another Cool Dude";
        $list->save();
        return "done";*/
    }


}
