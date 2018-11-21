<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Log;
use App\GroupList;
use App\CustomResponses;
use App\Http\Services\GroupListService;

use Response;
use Validator;

class GroupListController extends Controller
{

    private $groupListService;

    function __construct(GroupListService $groupListService)
    {

        Log::info("Constructor of GroupListController is called");
        $this->groupListService = $groupListService;

    }


    function index(){
        return $this->groupListService->getAllGroups();
        //return GroupListService::getAllGroups();
    }

    //show all todos from group Id;
    function show($id){
        return $this->groupListService->showGroup($id);
    }

    //delete one group
    function destroy($id){
       return $this->groupListService->deleteGroup($id);
    }


    //Add one group
    function store(Request $request){


        $validator = Validator::make($request->all(), [
            'title' => 'required',
        ]);

        if ($validator->fails()) {
            return  CustomResponses::getBadRequest("title is mandatory");
        }

        return $this->groupListService->createGroup($request);
    }


}
