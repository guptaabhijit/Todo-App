<?php
/**
 * Created by PhpStorm.
 * User: abhijitgupta
 * Date: 16/11/18
 * Time: 11:43 AM
 */

namespace App;


use Response;


class CustomResponses
{

    static public function getNotFoundError(){

       /* response()->setStatusCode(404);
        return response()->json([
             'code' => 404,
             'Message' => "NOT_FOUND"
         ]);*/

        return Response::json([
            'message' => "NOT_FOUND",
            'code' => 404
        ], 404); // Status code here
    }

    static public function getFoundSuccess(){

        return Response::json([
            'message' => "SUCCESS",
            'code' => 200
        ], 200); // Status code here

    }

    static public function getCreatedSuccess(){

        return Response::json([
            'message' => "CREATED",
            'code' => 201
        ], 201); // Status code here

    }

    static public function getBadRequest(){

        return Response::json([
            'message' => "BAD_REQUEST",
            'code' => 400
        ], 400); // Status code here

    }


}