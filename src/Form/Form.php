<?php

declare(strict_types=1);

namespace App\Form;

use Yiisoft\Form\FormModel;

abstract class Form extends FormModel
{
    public function getFirstError(): string
    {
        $errors = $this->firstErrors();

        return reset($errors);
    }
}
