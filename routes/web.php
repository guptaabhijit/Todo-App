<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


/*

Route::get('/', function () {

    //return view('welcome');
    //return "Hello World!";
    //return View::make('hello',array('name' => 'Here I am giving you the value you should catch bro!!'));
    // return view('hello')->with('name','abhijit');
    //$data = ['name'=>'abhi','email'=>'abhi@razorpay.com'];
    //return view('hello')->with($data);
    //return view('hello')->withData($data);

    //return view('layouts/app');

    //return view('cool');

    $data = [
        'name' => 'abhi',
        'email' => 'abhi31@gmail.com',
        'location' => 'AnyPlace',
        'last_name' => 'last name has been set',
    ];

    return view('cool')->withData($data);


});

Route::get('/hello/{name?}', function ($name = "world") {

    //return view('welcome');
     //return "Hello World!";
     //return View::make('hello',array('name' => 'Here I am giving you the value you should catch bro!!'));
     return view('hello')->with('name',$name);

 });


*/


Route::get('/',function(){

    return View::make('todos.index');

});

Route::get('/todos',function(){

    return view('todos.index');
});

Route::get('/todos/{id}',function($id){

    return view('todos.show')->withId($id);
});
