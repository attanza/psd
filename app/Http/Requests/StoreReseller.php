<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreReseller extends FormRequest
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
            'market_id' => 'required|integer',
            'parent_id' => 'required|integer',
            'reseller_type' => 'required|max:20',
            'code' => 'required|max:50|unique:resellers,code,'.$this->id,
            'name' => 'required|max:50|unique:resellers,name,'.$this->id,
            'owner' => 'required|max:50',
            'pic' => 'required|max:50',
            'phone1' => 'required|max:30|unique:resellers,phone1,'.$this->id,
            'phone2' => 'nullable|max:30',
            'email' => 'required|email|max:150|unique:resellers,email,'.$this->id,
            'address' => 'nullable',
            'lat' => 'nullable|numeric',
            'lng' => 'nullable|numeric',
        ];
    }
}
