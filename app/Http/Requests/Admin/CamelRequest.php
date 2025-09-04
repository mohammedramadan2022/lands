<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class CamelRequest extends FormRequest
{

    public function rules()
    {
        return [
            'barcode' => 'required|digits:15',
            'name' => 'nullable|string|max:255',
            // owner_id references owners.id (UUID), keep it nullable
            'owner_id' => 'nullable|exists:owners,id',
            'father_name' => 'nullable|string|max:255',
            'mother_name' => 'nullable|string|max:255',
            'gender' => 'nullable|in:bekraa,kaood',
            'age' => 'nullable|in:mafareed,haqayq,laqaya,gezaa,thanaya,zamool,heeyal',
        ];
    }

    public function messages()
    {
        return [
            'barcode.required' => 'الشريحة مطلوبة',
            'barcode.digits' => 'رقم الشريحة يجب أن يكون 15 رقمًا بالضبط',
            'owner_id.exists' => 'المالك غير موجود',
            'gender.in' => 'النوع غير صالح (bekraa أو kaood)',
            'age.in' => 'العمر غير صالح',
        ];
    }
}
