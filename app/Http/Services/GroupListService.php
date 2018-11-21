<?php
/**
 * Created by PhpStorm.
 * User: abhijitgupta
 * Date: 20/11/18
 * Time: 2:33 PM
 */

namespace App\Http\Services;



use Illuminate\Http\Request;
use Log;
use App\GroupList;
use App\CustomResponses;

use Response;
use Validator;



class GroupListService
{

    function getAllGroups(){
        $group_list = GroupList::all();

        $output = array();
        foreach ($group_list as $item){
            Log::info($item->getKey('id'));

            //$categories = GroupList::with('TodoList')->where('id',$item->getKey('id'))->get();
            $todos = GroupList::find($item->getKey('id'))->todo;
            Log::info($todos);
            $json_object = [
                "group" => $item,
                "task" => $todos
            ];
            array_push($output,$json_object);
        }

        if(sizeof($group_list) > 0)
            //return Response::json($group_list);
            return Response::json($output);
        else
            return CustomResponses::getNotFoundError("No record exists");
    }

     function showGroup($id){
        $todos = GroupList::find($id);
        if(!isset($todos)){
            return CustomResponses::getBadRequest("Group Does not exist");
        }

        $todos = GroupList::find($id)->todo;


        if($todos->count() > 0){
            return $todos;
        }
        else
            return CustomResponses::getNotFoundError("No tasks in the group. Create one :)");
    }

     function deleteGroup($id){
        $groupList = GroupList::find($id);

        if(isset($groupList->title)){
            $groupList->delete();
            return CustomResponses::getFoundSuccess();
        }
        else{
            return CustomResponses::getNotFoundError("No Group Found");
        }
    }

     function createGroup(Request $request){


        $groupList = new GroupList;

        $groupList->title = $request->input("title");

        $groupList->save();

        return $groupList;


    }
}