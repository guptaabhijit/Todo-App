<?php

namespace App\Http\Controllers;

use App\Constants;
use App\CustomResponses;
use App\TodoList;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\GroupList;

use App\Http\Services\TodoListService;
use Response;
use Validator;
use Log;


class TodoListController extends Controller
{


    private $todoListService;

    function __construct(TodoListService $todoListService)
    {

        Log::info("Constructor of TodoListController is called");
        $this->todoListService = $todoListService;

    }
    //show all tasks
    function index(){

        return $this->todoListService->getAllTodoTasks();
    }

   //Show one task based on ID.
    function show($id){
        return $this->todoListService->getTodoTask($id);
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

       return $this->todoListService->editTodoTask($request);

    }

    //delete one item
    function destroy($id){
        return $this->todoListService->deleteTodoTask($id);
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

        return $this->todoListService->addTodoTask($request);

    }


    function updateStatus(Request $request){

        $validator = Validator::make($request->all(), [
            'status' => 'required',
            'id' => 'required',
        ]);

        if ($validator->fails()) {
            return CustomResponses::getBadRequest();
        }
        return $this->todoListService->updateTodoTaskStatus($request);

    }

    function getTasksStatus(Request $request){
        Log::info("getTasksStatus Method is called().  Method => ". $request->getMethod()." & URI => ".$request->getRequestUri());
        return $this->todoListService->getTodoTaskStatus($request);

    }

}
