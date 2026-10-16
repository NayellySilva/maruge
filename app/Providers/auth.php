<?php

return [
    /*
      |--------------------------------------------------------------------------
      | Guardes Para autenticação
      |--------------------------------------------------------------------------
      |
      | Arquivo dedicado para configuração dos guardes para as autneticações
      | Abaixo o guarde padrão.
      |
     */
    'defaults' => [
        'guard' => 'web',
        'passwords' => 'users',
    ],
    /*
      |--------------------------------------------------------------------------
      | Guardes personalizados
      |--------------------------------------------------------------------------
      |
      | Toda novo tipo de autenticação necessita criar um guarde novo abaixo
      | os guardes ja configurados, o guarde web e o que vem por padrão
      | quando o deful e chamado e chamado esse web ambos são o mesmo.
      |
     */
    'guards' => [
        'web' => [
            'driver' => 'session',
            'provider' => 'users',
        ],
        'guardLogin' => [
            'driver' => 'session',
            'provider' => 'tb_usuario',
        ],
        'guardLoginAluno' => [
            'driver' => 'session',
            'provider' => 'tb_matriculas',
        ],
        'api' => [
            'driver' => 'token',
            'provider' => 'users',
        ],
    ],
    /*
      |--------------------------------------------------------------------------
      | Providers do sistema.
      |--------------------------------------------------------------------------
      |
      | Providers são as tabelas que o qual é e necessarias para indentifica
      | informações do devidos usuarios. necessita informa a tabela das
      | onde as informações estão, e tambem informa o diretorio do model
      |
     */
    'providers' => [
        'users' => [
            'driver' => 'eloquent',
            'model' => App\User::class,
        ],
        'tb_usuario' => [
            'driver' => 'eloquent',
            'model' => App\Models\modelLogin\modelLoginPrincipal::class,
        ],
        'tb_matriculas' => [
            'driver' => 'eloquent',
            'model' => App\Models\modelLogin\modelLoginAluno::class,
        ],

    // 'users' => [
    //     'driver' => 'database',
    //     'table' => 'users',
    // ],
    ],
    /*
      |--------------------------------------------------------------------------
      | Resetting Passwords
      |--------------------------------------------------------------------------
      |
      | Here you may set the options for resetting passwords including the view
      | that is your password reset e-mail. You may also set the name of the
      | table that maintains all of the reset tokens for your application.
      |
      | You may specify multiple password reset configurations if you have more
      | than one user table or model in the application and you want to have
      | separate password reset settings based on the specific user types.
      |
      | The expire time is the number of minutes that the reset token should be
      | considered valid. This security feature keeps tokens short-lived so
      | they have less time to be guessed. You may change this as needed.
      |
     */
    'passwords' => [
        'users' => [
            'provider' => 'users',
            'email' => 'auth.emails.password',
            'table' => 'password_resets',
            'expire' => 60,
        ],
    ],
];
