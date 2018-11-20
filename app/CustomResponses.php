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

    static public function getNotFoundError($mesg = "Not found"){
        return Response::json([
            'code' => 404,
            'data' => $mesg,
            'message' => "NOT_FOUND"
        ], 404);
    }

    static public function getFoundSuccess($mesg = "Success"){

        return Response::json([
            'code' => 200,
            'data' => $mesg,
            'message' => "SUCCESS"
        ], 200);

    }

    static public function getCreatedSuccess($mesg = "Created"){

        return Response::json([
            'code' => 201,
            'data' => $mesg,
            'message' => "CREATED"
        ], 201);

    }

    static public function getBadRequest($mesg = "Bad Request"){

        return Response::json([
            'code' => 400,
            'data' => $mesg,
            'message' => "BAD_REQUEST"
        ], 400);

    }

    static public function getForbiddenError($mesg = "Forbidden"){

        return Response::json([
            'code' => 403,
            'data' => $mesg,
            'message' => "FORBIDDEN"
        ], 403);

    }


}