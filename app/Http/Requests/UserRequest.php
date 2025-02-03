<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
        $rules = [
            'name' => 'required|string|max:255',
            'role' => 'required|in:admin,employee,manager',
        ];

        if ($this->isMethod('post')) {
            $rules['password'] = 'required|min:6|confirmed';
            $rules['email'] = 'required|email|unique:users|max:255';
        } elseif ($this->isMethod('put')) {
            $rules['password'] = 'nullable|min:6|confirmed';
            $rules['email'] = [
                'required',
                'email',
                'max:255',
                'unique:users,email,' . $this->route('user')
            ];
        }

        return $rules;
    }

}
