<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class MemberRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $member = $this->route('member');

        if ($member){
            return [
                'name' => [
                    'required',
                    'string',
                    'max:255',
                    Rule::unique('members', 'name')->ignore($this->route('member')),
                ],
                'role' => [
                    'required',
                    Rule::in(['normal', 'manager']),
                ],
                'email' => [
                    'nullable',
                    'email',
                    Rule::unique('members', 'email')->ignore($this->route('member')),
                ],
                'password' => [
                    'nullable',
                    'string',
                    'min:6',
                ],
            ];
        }
        else{

              return [
                  'name' => [
                      'required',
                      'string',
                      'max:255',
                      Rule::unique('members', 'name'),
                  ],
                  'role' => [
                      'required',
                      Rule::in(['normal', 'manager']),
                  ],
                  'email' => [
                      'nullable',
                      'email',
                      'unique:members,email',
                  ],
                  'password' => [
                      'required',
                      'string',
                      'min:6',
                  ],
                  'image' => 'required|image|mimes:jpeg,png,jpg,gif,webp,svg',
              ];

        }



    }


    public function messages()
    {
        return [
            'name.required' => 'يرجى إدخال الاسم .',
            'image.required' => 'يرجى إدخال الصوره.',
            'role.required' => 'The role field is required.',
            'role.in' => 'The role must be "normal" or "manager".',
        ];
    }
}
