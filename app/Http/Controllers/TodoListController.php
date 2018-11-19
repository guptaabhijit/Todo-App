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

        $todo_lists = TodoList::all();
        if(sizeof($todo_lists) > 0)
            return Response::json($todo_lists);
        else
            return CustomResponses::getNotFoundError();

    }

    //Show one task based on ID.
    function show($id){

        $list = TodoList::find($id);

        if(isset($list->tasks)){
            return response()->json([
                'tasks' => $list->tasks,
                'id' => $list->id,
                'status' => $list->status,
            ]);
        }
        else{
          return  CustomResponses::getNotFoundError();
        }

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


        $list = TodoList::find($request->input("id"));

        if(isset($list->tasks)){

            if($list->status != \App\Constants::StateTransition[4] ){
                $list->tasks = $request->input("tasks");
                $list->id = $request->input("id");
                $list->status = \App\Constants::StateTransition[1];
                $list->save();
                return "$list";
            }else{
                return  CustomResponses::getForbiddenError();
            }
        }

        else{
            return  CustomResponses::getNotFoundError();
        }

    }

    //delete one item
    function destroy($id){
        $list = TodoList::find($id);
        if(isset($list->tasks)){
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
            'tasks' => 'required',
            'group_list_id' => 'required',
        ]);

        if ($validator->fails()) {
            return  CustomResponses::getBadRequest();
        }

        $todos_list = GroupList::find($request->input("group_list_id"));

        if(!isset($todos_list)){
            return CustomResponses::getBadRequest();
        }

        $list = new TodoList;
        $list->tasks = $request->input("tasks");
        $list->status = \App\Constants::StateTransition[1];
        $list->group_list_id = $request->input("group_list_id");
        $list->save();
        return "$list";

    }


    function updateStatus(Request $request){

        $validator = Validator::make($request->all(), [
            'status' => 'required',
            'id' => 'required',
        ]);

        if ($validator->fails()) {
            return CustomResponses::getBadRequest();
        }
        $list = TodoList::find($request->input("id"));


        if(isset($list->tasks)){

            $old_status = $list->status; $new_status = $request->status;
            $new_status = strtoupper($new_status);
            $flag = false;
            switch ($new_status){
                case Constants::StateTransition[2]:
                    if($old_status == Constants::StateTransition[1] || $old_status == Constants::StateTransition[3]){
                        $flag = true;
                    }
                    break;
                case Constants::StateTransition[3]:
                    if($old_status == Constants::StateTransition[1] || $old_status == Constants::StateTransition[2]){
                        $flag = true;
                    }
                    break;
                case Constants::StateTransition[4]:
                    if($old_status == Constants::StateTransition[2]){
                        $flag = true;
                    }
                    break;
                default:
                    return CustomResponses::getBadRequest();

            }
            if($flag){
                $list->status = $new_status;
                $list->save();
                return "$list";
            }

            return CustomResponses::getForbiddenError();


        }else{
            return  CustomResponses::getNotFoundError();
        }
    }

    function getTasksStatus(Request $request){

        Log::info("Inside getTasksStatus");
        Log::info("getTasksStatus Method is called().  Method => ". $request->getMethod()." & URI => ".$request->getRequestUri());
        parse_str($request->getQueryString(), $output);
        if(array_key_exists("status",$output)){
            Log::info("Output ".$output["status"]);
            $status = $output["status"];
            $lists = DB::table('todo_lists')
                        ->where('status', '=', $status)
                        ->get();

            return $lists;
        }





    }

}
