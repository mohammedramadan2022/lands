<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePasswordRequest extends FormRequest
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
        return [
            //
            'password' => 'required|min:6|confirmed',
            'password_confirmation' => 'required|min:6',
        ];
    }

    public function messages(): array
    {
        return [
            'password.required' => 'يجب إدخال كلمة المرور.',
            'password.min' => 'يجب أن تكون كلمة المرور مكونة من 6 أحرف على الأقل.',
            'password.confirmed' => 'كلمة المرور وتأكيد كلمة المرور غير متطابقتين.',
            'password_confirmation.required' => 'يجب إدخال تأكيد كلمة المرور.',
            'password_confirmation.min' => 'يجب أن يكون تأكيد كلمة المرور مكون من 6 أحرف على الأقل.',
        ];
    }

}
