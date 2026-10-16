<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class loginAlunoRequest extends Request {
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
            'RA' => 'required|min:8|max:8',
            'password' => 'required|min:8|max:8',
        ];
    }

    public function messages() {
        return [
            'RA.required' => 'O Campo "RA" é Obrigatório',
            'RA.min' => 'O Campo "RA" deve conter 8 Caracteres',
            'RA.max' => 'O Campo "RA" deve conter 8 Caracteres',
            'password.required' => 'A Senha é Obrigatória',
            'password.min' => 'Senha deve conter 8 Digítos',
            'password.max' => 'Senha deve conter 8 Digítos',
        ];
    }
}
