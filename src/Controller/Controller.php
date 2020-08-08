<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\User;
use App\Exception\BadRequestException;
use Psr\Http\Message\ServerRequestInterface as Request;
use Yiisoft\Auth\Middleware\Auth;
use Yiisoft\Json\Json;
use JsonException;

abstract class Controller
{
    /**
     * @param Request $request
     * @return array
     * @throws BadRequestException
     */
    protected function getDataFromJsonRequest(Request $request): array
    {
        try {
            return Json::decode($request->getBody()->getContents());
        } catch (JsonException $e) {
            throw new BadRequestException();
        }
    }

    protected function getUserFromRequest(Request $request): User
    {
        /**
         * @var User $identity
         */
        $identity = $request->getAttribute(Auth::REQUEST_NAME);

        return $identity;
    }
}
