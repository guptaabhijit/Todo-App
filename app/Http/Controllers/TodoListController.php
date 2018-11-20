<?php

namespace App\Http\Controllers;

use App\Constants;
use App\CustomResponses;
use App\TodoList;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\GroupList;

use Response;
use Validator;
use Log;


class TodoListController extends Controller
{


    //show all tasks
    function index(){

        return \App\Http\Services\TodoListService::getAllTodoTasks();
    }

   //Show one task based on ID.
    function show($id){
        return \App\Http\Services\TodoListService::getTodoTask($id);
    }


    //update one item
    //Should give old Id and new Name
    //status will change to Created.
    //check if status is not "DONE"
    function update(Request $request){

        Log::info("Update Method is called().  Method => ". $request->getMethod()." & URI => ".$request->getRequestUri());

        $validator = Validator::make($request->all(), [
            'tasks' => 'required',
            'id' => 'required',
        ]);

        if ($validator->fails()) {
            return CustomResponses::getBadRequest();
        }

       return \App\Http\Services\TodoListService::editTodoTask($request);

    }

    //delete one item
    function destroy($id){
        return \App\Http\Services\TodoListService::deleteTodoTask($id);
    }


    //Add one item
    function store(Request $request){

        $validator = Validator::make($request->all(), [
            'tasks' => 'required',
            'group_list_id' => 'required',
        ]);

        if ($validator->fails()) {
            return  CustomResponses::getBadRequest("tasks and group_list_id is mandatory");
        }

        return \App\Http\Services\TodoListService::addTodoTask($request);

    }


    function updateStatus(Request $request){

        $validator = Validator::make($request->all(), [
            'status' => 'required',
            'id' => 'required',
        ]);

        if ($validator->fails()) {
            return CustomResponses::getBadRequest();
        }
        return \App\Http\Services\TodoListService::updateTodoTaskStatus($request);

    }

    function getTasksStatus(Request $request){
        Log::info("getTasksStatus Method is called().  Method => ". $request->getMethod()." & URI => ".$request->getRequestUri());
        return \App\Http\Services\TodoListService::getTodoTaskStatus($request);

    }

}
