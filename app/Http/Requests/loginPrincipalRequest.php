<?php

namespace App\Http\Requests;
use App\Http\Requests\Request;
class loginPrincipalRequest extends Request {

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize() {
        return true;
    }
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() {
        return [
            'CPF' => 'required|min:14|max:14',
            'password' => 'required|min:8|max:8',
        ];
    }

    public function messages() {
        return [
            'CPF.required' => 'O Campo "CPF" é Obrigatório',
            'CPF.min' => 'O Campo "CPF" deve conter 11 Caracteres',
            'CPF.max' => 'O Campo "CPF" deve conter 11 Caracteres',
            'password.required' => 'A Senha é Obrigatória',
            'password.min' => 'Senha deve conter 8 Caracteres ',
            'password.max' => 'Senha deve conter 8 Caracteres ',
        ];
    }

}
