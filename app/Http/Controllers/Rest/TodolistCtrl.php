<?php

namespace App\Http\Controllers\Rest;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator, DB;
use App\Models\TodolistModel;
class TodolistCtrl extends Controller
{
    //

    private $todolistModel;
    
    public function __construct(TodolistModel $todolistModel){
        $this->todolistModel = $todolistModel;
    }

    public function getTodolist(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'perPage' => 'required|numeric',
        ], [
            'perPage.required' => 'perPage không được bỏ trống',
            'perPage.numeric' => 'perPage không đúng định dạng',
        ]);

        if($validate->fails()){
            return response()->json($validate->messages(), 422);
        }

        $perPage = $request->input('perPage', 10); 
        $responseData = $this->todolistModel->paginate($perPage);

        return response()->json($responseData);

    }

    public function createTodoList(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'name' => 'required',
            'description' => 'required',
            'due_date' => 'required',
            'plority' => 'required',
        ], [
            'name.required' => 'tên không được bỏ trống',
            'description.required' => 'mô tả không được bỏ trống',
            'due_date.required' => 'hạn chót không được bỏ trống',
            'plority.required' => 'ưu tiên không được bỏ trống',
        ]);

        if($validate->fails()){
            return response()->json($validate->messages(), 422);
        }

        try {
            $id = $this->todolistModel->insertGetId([
                'name' => $request->name,
                'description' => $request->description,
                'due_date' => $request->due_date,
                'plority' => $request->plority,
                'is_done' => false,
            ]);

            DB::commit();
            return response()->json(['status' => true], 200);
        } catch (\Throwable $th) {
            return response()->json(['errMsg' => 'Xảy ra lỗi hệ thống!'], 422);
        }
     
    }

    public function updateTodoList(Request $request, $id)
    {
        $validate = Validator::make($request->all(), [
            'name' => 'required',
            'description' => 'required',
            'due_date' => 'required',
            'plority' => 'required',
        ], [
            'name.required' => 'tên không được bỏ trống',
            'description.required' => 'mô tả không được bỏ trống',
            'due_date.required' => 'hạn chót không được bỏ trống',
            'plority.required' => 'ưu tiên không được bỏ trống',
        ]);

        if($validate->fails()){
            return response()->json($validate->messages(), 422);
        }
        // try {
            $isDone = 0;
            if ($request->is_done) {
                $isDone = 1;
            }
            DB::beginTransaction();
            $singleTodoList = $this->todolistModel->find($id);
            $singleTodoList->name = $request->name;
            $singleTodoList->description = $request->description;
            $singleTodoList->due_date = $request->due_date;
            $singleTodoList->plority = $request->plority;
            $singleTodoList->is_done = $isDone;
            $singleTodoList->save();
            DB::commit();
            return response()->json(['status' => true], 200);
        // } catch (\Throwable $th) {
        //     DB::rollback();

        //     return response()->json(['errMsg' => 'Xảy ra lỗi hệ thống!'], 422);
        // }
    }


    public function doneTodoList($id)
    {
        try {

            DB::beginTransaction();
            $singleTodoList = $this->todolistModel->find($id);
            $singleTodoList->is_done = true;
            $singleTodoList->save();
            DB::commit();
            return response()->json(['status' => true], 200);
        } catch (\Throwable $th) {
            DB::rollback();

            return response()->json(['errMsg' => 'Xảy ra lỗi hệ thống!'], 422);
        }
    }

    public function deleteTodolist($id)
    {
        try {

            DB::beginTransaction();
            $singleTodoList = $this->todolistModel->find($id);
            $singleTodoList->delete();
            DB::commit();
            return response()->json(['status' => true], 200);
        } catch (\Throwable $th) {
            DB::rollback();

            return response()->json(['errMsg' => 'Xảy ra lỗi hệ thống!'], 422);
        }
    }
}
