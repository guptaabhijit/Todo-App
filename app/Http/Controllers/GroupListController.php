<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Log;
use App\GroupList;
use App\CustomResponses;

use Response;
use Validator;

class GroupListController extends Controller
{

    function index(){
        return \App\Http\Services\GroupListService::getAllGroups();
    }

    //show all todos from group Id;
    function show($id){
        return \App\Http\Services\GroupListService::showGroup($id);
    }

    //delete one group
    function destroy($id){
       return \App\Http\Services\GroupListService::deleteGroup($id);
    }


    //Add one group
    function store(Request $request){

        $validator = Validator::make($request->all(), [
            'title' => 'required',
        ]);

        if ($validator->fails()) {
            return  CustomResponses::getBadRequest("title is mandatory");
        }

        return \App\Http\Services\GroupListService::createGroup($request);
    }


}
