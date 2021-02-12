<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePasswordRequest extends ApiRequest
{
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
            'mail'                      => ['required'],
            'password'                  => ['required'],
            'new_password'              => ['required', 'min:8','different:password'],
            'new_password_confirmation' => ['required', 'same:new_password'],
        ];
    }

    public function messages()
    {
        return [
            'mail.required'                      => 'メールアドレスは必ず指定してください',
            'password.required'                  => '現在のパスワードは必ず指定してください',
            'new_password.required'              => '新しいパスワードは必ず指定してください',
            'new_password.min'                   => '新しいパスワードは必ず8文字以上にしてください',
            'new_password.different'             => '前回とは異なるパスワードを指定してください',
            'new_password_confirmation.required' => '確認用パスワードは必ず指定してください',
            'new_password_confirmation.same'     => '確認用パスワードが間違っています',
        ];
    }
}
