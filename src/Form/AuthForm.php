<?php

declare(strict_types=1);

namespace App\Form;

use Yiisoft\Validator\Rule\Required;

final class AuthForm extends Form
{
    private ?string $login = null;
    private ?string $password = null;

    public function getLogin(): string
    {
        return $this->login;
    }

    public function formName(): string
    {
        return '';
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    protected function rules(): array
    {
        return [
            'login' => [
                new Required(),
            ],
            'password' => [
                new Required(),
            ]
        ];
    }
}
