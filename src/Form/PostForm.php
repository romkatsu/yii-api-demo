<?php

declare(strict_types=1);

namespace App\Form;

use App\Enum\PostStatus;
use Yiisoft\Validator\Result;
use Yiisoft\Validator\Rule\HasLength;
use Yiisoft\Validator\Rule\Required;

final class PostForm extends Form
{
    private ?string $title = null;
    private ?string $text = null;
    private ?int $status = null;

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getText(): string
    {
        return $this->text;
    }

    public function getStatus(): PostStatus
    {
        return new PostStatus($this->status);
    }

    protected function rules(): array
    {
        return [
            'title' => [
                new Required(),
                (new HasLength())
                    ->min(5)
                    ->max(255)
            ],
            'text' => [
                new Required(),
                (new HasLength())
                    ->min(5)
                    ->max(1000)
            ],
            'status' => [
                new Required(),
                static function ($value): Result {
                    $result = new Result();
                    if (!PostStatus::isValid($value)) {
                        $result->addError('Incorrect status');
                    }
                    return $result;
                }
            ]
        ];
    }
}
