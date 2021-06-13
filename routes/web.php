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

Route::get('/', function () {
    return view('welcome');
});


Route::group(['prefix' => 'rest', 'middleware' => ['web']], function () {
    Route::get('/example', 'Rest\ExampleCtrl@listExample');
    Route::post('/example', 'Rest\ExampleCtrl@createExample');
    Route::put('/example/{id}', 'Rest\ExampleCtrl@editExample');
    Route::delete('/example/{id}', 'Rest\ExampleCtrl@deleteExample');

    Route::get('getTodolist', 'Rest\TodolistCtrl@getTodolist');
    Route::post('createTodoList', 'Rest\TodolistCtrl@createTodoList');
    Route::put('updateTodoList/{id}', 'Rest\TodolistCtrl@updateTodoList');
    Route::put('doneTodoList/{id}', 'Rest\TodolistCtrl@doneTodoList');
    Route::delete('deleteTodolist', 'Rest\TodolistCtrl@deleteTodolist');
});