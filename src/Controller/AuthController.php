<?php

declare(strict_types=1);

namespace App\Controller;

use App\Exception\BadRequestException;
use App\Form\AuthForm;
use App\Service\UserService;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Yiisoft\DataResponse\DataResponseFactoryInterface as ResponseFactory;
use Throwable;
use JsonException;

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

    /**
     * @param ServerRequestInterface $request
     * @param AuthForm $form
     * @return ResponseInterface
     * @throws BadRequestException
     * @throws JsonException
     */
    public function login(ServerRequestInterface $request, AuthForm $form): ResponseInterface
    {
        $form->setAttributes($this->getDataFromJsonRequest($request));
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

    /**
     * @return ResponseInterface
     * @throws BadRequestException
     * @throws Throwable
     */
    public function logout(): ResponseInterface
    {
        $this->userService->logout();
        return $this->responseFactory->createResponse();
    }
}
