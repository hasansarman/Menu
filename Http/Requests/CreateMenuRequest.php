<?php

namespace Modules\Menu\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateMenuRequest extends FormRequest
{
    public function rules()
    {
        return [
            'NAME' => 'required',
            'PRIMARY' => 'unique:menus',
        ];
    }

    public function authorize()
    {
        return true;
    }

    public function messages()
    {
        return [
            'name.required' => trans('menu::validation.name is required'),
            'primary.unique' => trans('menu::validation.only one primary menu'),
        ];
    }
}
