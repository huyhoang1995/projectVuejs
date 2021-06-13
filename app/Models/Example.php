<?php

namespace App\Models;

use App\Models\MyModel;

class Example extends MyModel
{
    protected $table = 'example';

    public function filterId($id){
        $this->setFunctionCond('where', ['id', $id]);
        return $this;
    }

    public function filterName($name){
        if(!empty($name)){
            $this->setFunctionCond('where', ['name', 'like', "%$name%"]);
        }
        
        return $this;
    }

}
