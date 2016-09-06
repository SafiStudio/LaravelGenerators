<?php

namespace GeneratorNameSpace\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class GeneratorNameRequest extends FormRequest
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
