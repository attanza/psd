<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreStokist extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'area_id' => 'required|integer',
            'code' => 'required|max:50|unique:stokists,code,'.$this->id,
            'name' => 'required|max:50|unique:stokists,name,'.$this->id,
            'owner' => 'required|max:50',
            'pic' => 'required|max:50',
            'phone1' => 'required|max:30|unique:stokists,phone1,'.$this->id,
            'phone2' => 'nullable|max:30',
            'email' => 'required|email|max:150|unique:stokists,email,'.$this->id,
            'address' => 'nullable',
            'lat' => 'nullable|numeric',
            'lng' => 'nullable|numeric',
        ];
    }
}
