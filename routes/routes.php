<?php
/**
 * Created by PhpStorm.
 * User: abhijitgupta
 * Date: 15/11/18
 * Time: 6:18 PM
 */

use App\CustomResponses;
/*

/         =   home
/todos    =   all lists
/todos/1  =   show
/todos/1/edit = edit and update
/todos/create = create new list

*/


/*Route::get('/',function(){

    return "Inside routes.php";
});*/


//Route::get('/','TodoListController@index');
//Route::get('/todos','TodoListController@index');
//Route::get('/todos/{id}','TodoListController@show');
//Current database connected to!!!



Route::get('/db',function(){

   // return DB::select('select database();');
    //return DB::select('show tables;');
    //return DB::table('todo_lists')->get();

    $result = DB::table('todo_lists')->where('name','jeet')->first();
    return $result->id;


});

Route::get('/add',function(){

    /*DB::table('todo_lists')->insert(
        array(['name' => 'Your list'])
    );

    return DB::table('todo_lists')->get();*/

});


Route::resource('todos','TodoListController');

Route::fallback(function () {
    //
    return CustomResponses::getNotFoundError();
});