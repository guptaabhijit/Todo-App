<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Log;
use App\GroupList;
use App\CustomResponses;

use function PHPSTORM_META\type;
use Response;
use Validator;

class GroupListController extends Controller
{

    function index(){

        //return GroupList::all()->toArray();
        $group_list = GroupList::all();

        if(sizeof($group_list) > 0)
            return Response::json($group_list);
        else
            return CustomResponses::getNotFoundError("No record exists");

    }

    //show all todos from group Id;
    function show($id){

        $todos = GroupList::find($id);
        if(!isset($todos)){
            return CustomResponses::getBadRequest();
        }

        $todos = GroupList::find($id)->todo;

        /* foreach ($todos as $todo) {
            Log::info($todo);
        }*/

        if($todos->count() > 0){
            return $todos;
        }
        else
            return CustomResponses::getNotFoundError();

    }

    //delete one group
    function destroy($id){

        $groupList = GroupList::find($id);

        if(isset($groupList->title)){
            $groupList->delete();
            return CustomResponses::getFoundSuccess();
        }
        else{
            return CustomResponses::getNotFoundError();
        }

    }





    //Add one group
    function store(Request $request){

        $validator = Validator::make($request->all(), [
            'title' => 'required',
        ]);

        if ($validator->fails()) {
            return  CustomResponses::getBadRequest("title is mandatory");
        }

        $groupList = new GroupList;

        $groupList->title = $request->input("title");

        $groupList->save();

        return $groupList;

    }


}
