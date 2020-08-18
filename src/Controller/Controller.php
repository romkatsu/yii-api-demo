<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\User;
use Psr\Http\Message\ServerRequestInterface as Request;
use Yiisoft\Auth\Middleware\Auth;

abstract class Controller
{
    protected function getUserFromRequest(Request $request): User
    {
        /**
         * @var User $identity
         */
        $identity = $request->getAttribute(Auth::REQUEST_NAME);

        return $identity;
    }
}
