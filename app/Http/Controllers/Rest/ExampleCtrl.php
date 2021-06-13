<?php

namespace App\Http\Controllers\Rest;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Example;
use Validator;

class ExampleCtrl extends Controller
{
    private $exampleModel;
    
    public function __construct(Example $exampleModel){
        $this->exampleModel = $exampleModel;
    }

    /**
     * Danh sach example
     *
     * @param Request $request
     * @return void
     */
    public function listExample(Request $request){
        //validate
        $validate = Validator::make($request->all(), [
            'page' => 'required|numeric',
            'perPage' => 'required|numeric',
        ], [
            'page.required' => 'page không được bỏ trống',
            'page.numeric' => 'page không đúng định dạng',
            'perPage.required' => 'perPage không được bỏ trống',
            'perPage.numeric' => 'perPage không đúng định dạng',
        ]);

        if($validate->fails()){
            return response()->json($validate->messages(), 422);
        }

        $perPage = $request->input('perPage', 10); 
        $freeText = $request->input('freeText', '');
        $listExample = $this->exampleModel->filterName($freeText)->buildCond()->paginate($perPage);

        return response()->json($listExample);
    }

    /**
     * Thuc hien them moi example
     *
     * @param Request $request
     * @return void
     */
    public function createExample(Request $request){
        //validate
        $validate = Validator::make($request->all(), [
            'name' => 'required',
            'age' => 'required|numeric',
            'address' => 'required|string'
        ], [
            'name.required' => 'name không được bỏ trống',
            'age.required' => 'age không được bỏ trống',
            'address.required' => 'address không được bỏ trống',
            'age.numeric' => 'age không đúng định dạng',
            'address.string' => 'address không đúng định dạng',
        ]);

        if($validate->fails()){
            return response()->json($validate->messages(), 422);
        }

        $newId = $this->exampleModel->insertGetId([
            'name' => $request->name,
            'address' => $request->address,
            'age' => $request->age,
            'created_at' => Date('Y-m-d H:i:s'),
            'updated_at' => Date('Y-m-d H:i:s'),
        ]);
        

        return response()->json(['status' => true]);
    }

    /**
     * Thuc hien update
     *
     * @param Request $request
     * @param [type] $id
     * @return void
     */
    public function editExample(Request $request, $id){
        //validate
        $validate = Validator::make(array_merge(['id' => $id], $request->all()), [
            'id' => 'required|exists:example,id',
            'name' => 'required',
            'age' => 'required|numeric',
            'address' => 'required|string'
        ], [
            'name.required' => 'name không được bỏ trống',
            'age.required' => 'age không được bỏ trống',
            'address.required' => 'address không được bỏ trống',
            'age.numeric' => 'age không đúng định dạng',
            'address.string' => 'address không đúng định dạng',
            'id.required' => 'id không được bỏ trống',
            'id.exists' => 'id không tồn tại'
        ]);

        if($validate->fails()){
            return response()->json($validate->messages(), 422);
        }

        $exampleInfo = $this->exampleModel->find($id);
        $exampleInfo->name = $request->name;
        $exampleInfo->address = $request->address;
        $exampleInfo->age = $request->age;
        $exampleInfo->updated_at = Date('Y-m-d H:i:s');
        $exampleInfo->save();

        return response()->json(['status' => true]);
    }

    /**
     * Thuc hien xoa
     *
     * @param [type] $id
     * @return void
     */
    public function deleteExample($id){
        //validate
        $validate = Validator::make(['$id' => $id], [
            'id' => 'requried|exists:example,id'
        ], [
            'id.required' => 'id không được bỏ trống',
            'id.exists' => 'id không tồn tại'
        ]);

        if($validate->fails()){
            return response()->json($validate->messages(), 422);
        }

        $this->exampleModel->find($id)->delete();
        return response()->json(['status' => true]);
    }
}
