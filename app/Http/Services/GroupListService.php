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

    static function getAllGroups(){
        $group_list = GroupList::all();

        if(sizeof($group_list) > 0)
            return Response::json($group_list);
        else
            return CustomResponses::getNotFoundError("No record exists");
    }

    static function showGroup($id){
        $todos = GroupList::find($id);
        if(!isset($todos)){
            return CustomResponses::getBadRequest("Group Does not exist");
        }

        $todos = GroupList::find($id)->todo;

        /* foreach ($todos as $todo) {
            Log::info($todo);
        }*/

        if($todos->count() > 0){
            return $todos;
        }
        else
            return CustomResponses::getNotFoundError("No tasks in the group. Create one :)");
    }

    static function deleteGroup($id){
        $groupList = GroupList::find($id);

        if(isset($groupList->title)){
            $groupList->delete();
            return CustomResponses::getFoundSuccess();
        }
        else{
            return CustomResponses::getNotFoundError("No Group Found");
        }
    }

    static function createGroup(Request $request){


        $groupList = new GroupList;

        $groupList->title = $request->input("title");

        $groupList->save();

        return $groupList;


    }
}