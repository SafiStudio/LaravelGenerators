<?php

namespace GeneratorNameSpace\Http\Requests\Admin;

use GeneratorNameSpace\Http\Requests\Request;

class GeneratorNameRequest extends Request
{
    public function rules(){
        return '{rules}';
    }

    public function attributes(){
        return '{attributes}';
    }

    public function authorize(){
        return true;
    }
}
