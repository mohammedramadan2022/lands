<?php

namespace App\Http\Requests\Admin;

use App\Models\Owner;
use App\Rules\UniqueTwoColumnsRule;
use Illuminate\Foundation\Http\FormRequest;

class OwnerRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $owner = $this->route('owner');
        if ($owner) {
            return [
                'name' => ['required', 'string'],
                'phone' => ['required'],
//                'phone' => ['required', 'unique:owners,phone,'.$owner->id],
//                'modammer_name' => ['required'],
                'nationality' => ['required', 'in:قطري,كويتي,سعودي,اماراتي,عماني,بحريني'],
                'national_id' => ['nullable', 'unique:owners,national_id,'.$owner->id],
                'is_member' => ['required'],
                'type' => ['nullable', 'in:normal,special'],
                'register_number' => ['required' , new UniqueTwoColumnsRule('owners', 'register_number', 'register_symbol',request('register_symbol'), $owner->id)],
                'register_symbol' => ['required' , new UniqueTwoColumnsRule('owners', 'register_number', 'register_symbol', request('register_number'), $owner->id)],
            ];
        } else {

            return [
                'name' => ['required', 'string'],
                'phone' => ['required'],
//                'phone' => ['required', 'unique:owners,phone'],
//                'modammer_name' => ['required'],
                'nationality' => ['required', 'in:قطري,كويتي,سعودي,اماراتي,عماني,بحريني'],
                'national_id' => ['nullable', 'unique:owners,national_id'],
                'is_member' => ['required'],
                'type' => ['nullable', 'in:normal,special'],
                'register_number' => ['required' , new UniqueTwoColumnsRule('owners', 'register_number', 'register_symbol',request('register_symbol'))],
                'register_symbol' => ['required' , new UniqueTwoColumnsRule('owners', 'register_number', 'register_symbol', request('register_number'))],
            ];

        }
    }


    public function messages()
    {
        return [
            'name.required' => 'حقل الاسم مطلوب.',
            'name.string' => 'يجب أن يكون الاسم نصًا.',
            'phone.required' => 'حقل الهاتف مطلوب.',
            'phone.unique' => 'رقم الهاتف مستخدم بالفعل.',
            'nationality.required' => 'حقل الجنسية مطلوب.',
            'nationality.in' => 'الجنسية المحددة غير صالحة.',
            'national_id.required' => 'حقل الهوية الوطنية مطلوب.',
            'national_id.unique' => 'رقم الهوية الوطنية مستخدم بالفعل.',
            'is_member.required' => 'حقل العضوية مطلوب.',
            'register_number.required' => 'حقل رقم السجل مطلوب.',
            'register_symbol.required' => 'حقل رمز السجل مطلوب.',
            'register_number.unique_two_columns' => 'رقم السجل ورمز السجل مستخدمان بالفعل.',
            'register_symbol.unique_two_columns' => 'رقم السجل ورمز السجل مستخدمان بالفعل.',
            'type.in' => 'نوع المالك يجب أن يكون normal أو special.',
        ];
    }

}
