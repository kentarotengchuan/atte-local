<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
            "name" => "required|string|max:191|unique:users",
            "email" => "required|email|max:191|unique:users",
            "password" => "required|min:8|max:191|confirmed"
        ];
    }

    public function messages()
    {
        return [
            'name.required' => '名前を入力してください',
            'name.unique' => 'この名前は既に使用されています',
            'name.string' => '文字列型で入力して下さい',
            'name.max' => '名前は191文字以内で入力してください', 
            'email.required' => 'メールアドレスを入力してください',
            'email.email' => 'メールアドレスは「ユーザー名@ドメイン」形式で入力してください',
            'email.unique' => 'このアドレスは既に使用されています',
            'email.max' => 'メールアドレスは191文字以内で入力してください',
            'password.required' => 'パスワードを入力してください',
            'password.confirmed' => 'パスワードが一致しません',
            'password.min' => 'パスワードは8文字以内で入力してください',
            'password.max' => 'パスワードは191文字以内で入力してください'
        ];
    }
}
