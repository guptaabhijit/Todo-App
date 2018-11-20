<?php
/**
 * Created by PhpStorm.
 * User: abhijitgupta
 * Date: 20/11/18
 * Time: 2:33 PM
 */

namespace App\Http\Services;

use App\Constants;
use App\CustomResponses;
use App\TodoList;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\GroupList;

use Response;
use Validator;
use Log;


class TodoListService
{

   static function getAllTodoTasks(){

        $todo_lists = TodoList::all();
        if(sizeof($todo_lists) > 0)
            return Response::json($todo_lists);
        else
            return CustomResponses::getNotFoundError("No record exists");

    }

    static function getTodoTask($id){
        $list = TodoList::find($id);

        if(isset($list->tasks)){
            return $list;
        }
        else{
            return  CustomResponses::getNotFoundError("No record exists");
        }

    }

    static function editTodoTask(Request $request){
        $list = TodoList::find($request->input("id"));

        if(isset($list->tasks)){

            if($list->status != \App\Constants::StateTransition[4] ){
                $list->tasks = $request->input("tasks");
                $list->id = $request->input("id");
                $list->status = \App\Constants::StateTransition[1];
                $list->save();
                return $list;
            }else{
                return  CustomResponses::getForbiddenError();
            }
        }
        else{
            return  CustomResponses::getNotFoundError();
        }
    }


    static function deleteTodoTask($id){

       $list = TodoList::find($id);
        if(isset($list->tasks)){
            $list->delete();
            return CustomResponses::getFoundSuccess();
        }
        else{
            return CustomResponses::getNotFoundError();
        }

    }

    static function addTodoTask(Request $request){
        $group_list = GroupList::find($request->input("group_list_id"));

        if(!isset($group_list)){
            return CustomResponses::getBadRequest("group_list_id is not valid");
        }

        $list = new TodoList;
        $list->tasks = $request->input("tasks");
        $list->status = \App\Constants::StateTransition[1];
        $list->group_list_id = $request->input("group_list_id");
        $list->save();
        return $list;
    }

    static function updateTodoTaskStatus(Request $request){
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
                    return CustomResponses::getBadRequest("Give valid status in Query Params");

            }
            if($flag){
                $list->status = $new_status;
                $list->save();
                return $list;
            }

            return CustomResponses::getForbiddenError("Transition Not possible");


        }else{
            return  CustomResponses::getNotFoundError("No task found");
        }
    }

    static function getTodoTaskStatus(Request $request){

        parse_str($request->getQueryString(), $output);


        if(array_key_exists("status",$output)){
            Log::info("Output ".$output["status"]);
            $status = $output["status"];

            if(array_key_exists("group_list_id",$output)){

                $group_list_id = $output["group_list_id"];

                $lists = DB::table('todo_lists')
                    ->where('status', '=', $status)
                    ->where('group_list_id','=',$group_list_id)
                    ->get();

            }else{
                $lists = DB::table('todo_lists')
                    ->where('status', '=', $status)
                    ->get();
            }


        }
        elseif(array_key_exists("group_list_id",$output)){
            $group_list_id = $output["group_list_id"];
            $lists = DB::table('todo_lists')
                ->where('group_list_id','=',$group_list_id)
                ->get();
        }
        else{
            return CustomResponses::getNotFoundError("No status in Query Params");
        }



        if($lists->count() > 0){
            return $lists;
        }
        else{
            return CustomResponses::getNotFoundError("No result");
        }
    }



}