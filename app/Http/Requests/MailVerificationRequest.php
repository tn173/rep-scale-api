<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MailVerificationRequest extends ApiRequest
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
            'mail'                  => ['required', 'email', 'max:128'],
            'password'              => ['required', 'min:8'],
            'password_confirmation' => ['required', 'same:password'],
        ];
    }

    public function messages()
    {
        return [
            'mail.required'                     => 'メールアドレスは必ず指定してください',
            'password.required'                 => 'パスワードは必ず指定してください',
            'password_confirmation.required'    => '確認用パスワードは必ず指定してください',
            'password_confirmation.same'        => 'パスワードが間違っています',
            'password.min'                      => 'パスワードは必ず8文字以上にしてください',
        ];
    }
}
