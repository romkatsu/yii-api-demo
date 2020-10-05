<?php

declare(strict_types=1);

namespace App\Controller;

use App\Exception\BadRequestException;
use App\Form\AuthForm;
use App\Service\UserService;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Yiisoft\DataResponse\DataResponseFactoryInterface as ResponseFactory;

final class AuthController extends Controller
{
    private ResponseFactory $responseFactory;
    private UserService $userService;

    public function __construct(
        ResponseFactory $responseFactory,
        UserService $userService
    ) {
        $this->responseFactory = $responseFactory;
        $this->userService = $userService;
    }

    public function login(ServerRequestInterface $request, AuthForm $form): ResponseInterface
    {
        $form->load($request->getParsedBody());

        if (!$form->validate()) {
            throw new BadRequestException($form->getFirstError());
        }

        return $this->responseFactory->createResponse(
            [
                'token' => $this->userService->login(
                    $form->getLogin(),
                    $form->getPassword()
                )->getToken()
            ]
        );
    }

    public function logout(): ResponseInterface
    {
        $this->userService->logout();
        return $this->responseFactory->createResponse();
    }
}
