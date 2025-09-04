<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class AdminRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        if ($this->id){
            return [
                'email' => "required|unique:admins,email,".$this->id,
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp,svg',
                'name' => 'required',
                'password' => 'nullable|min:6',
                'is_active'=>'nullable|in:0,1',

            ];
        }
        else{
            return [
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp,svg',
                'name' => 'required',
                'email' => "required|email|unique:admins",
                'password' => 'required|min:6',
                'is_active'=>'nullable|in:0,1',
            ];
        }
    }


    public function messages()
    {
        return [
            'name.required' => 'يرجى إدخال اسم المدير.',
            'email.required' => 'يرجى إدخال عنوان البريد الإلكتروني.',
            'email.unique' => 'عنوان البريد الإلكتروني تم استخدامه من قبل.',
            'password.required' => 'يرجى إدخال كلمة المرور.',
            'password.min' => 'يجب أن تكون كلمة المرور على الأقل :min أحرف.',
            'image.image' => 'الملف المرفق يجب أن يكون صورة.',
            'image.mimes' => 'الصور المدعومة هي: jpeg, png, jpg, gif, webp.',
            'is_active.in' => 'الحالة يجب أن تكون إما مفعل أو غير مفعل.',
        ];
    }
}
