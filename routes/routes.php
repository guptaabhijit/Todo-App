<?php
/**
 * Created by PhpStorm.
 * User: abhijitgupta
 * Date: 15/11/18
 * Time: 6:18 PM
 */

use App\CustomResponses;
/*

/todos    =   all tasks
/todos/{id}  =   show task wrt id
/todos = store tasks
/todos/{id} = delete task wrt id
/todos = update task

/todos/status?{status} = Get all task with status
/todos/status = Update status. {Require taskId and new status}



*/



Route::get('/todos/groups','GroupListController@index');
Route::get('/todos/group/{id}','GroupListController@show');
Route::post('/todos/group','GroupListController@store');
Route::delete('/todos/group/{id}','GroupListController@destroy');

Route::get('/todos/status','TodoListController@getTasksStatus');
Route::put('/todos/status','TodoListController@updateStatus');

Route::get('/todos','TodoListController@index');
Route::get('/todos/{id}','TodoListController@show');
Route::post('/todos','TodoListController@store');
Route::delete('/todos/{id}','TodoListController@destroy');
Route::put('/todos','TodoListController@update');





/*Route::get('/db',function(){

    // return DB::select('select database();');
    //return DB::select('show tables;');
    //return DB::table('todo_lists')->get();

    $result = DB::table('todo_lists')->where('name','jeet')->first();
    return $result->id;


});*/

/*
Route::get('/add',function(){

    DB::table('todo_lists')->insert(
        array(['name' => 'Your list'])
    );

    return DB::table('todo_lists')->get();

});*/

//Route::resource('todos','TodoListController');

Route::fallback(function () {
    return CustomResponses::getNotFoundError();
});