<?php

declare(strict_types=1);

namespace App\Provider;

use App\Auth\AuthRequestErrorHandler;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseFactoryInterface;
use Yiisoft\Auth\AuthInterface;
use Yiisoft\Auth\Method\HttpHeader;
use Yiisoft\Auth\Middleware\Auth;
use Yiisoft\Di\Container;
use Yiisoft\Di\Support\ServiceProvider;

final class AuthProvider extends ServiceProvider
{
    public function register(Container $container): void
    {
        $container->set(AuthInterface::class, HttpHeader::class);
        $container->set(
            Auth::class,
            static function (ContainerInterface $container) {
                return new Auth(
                    $container->get(AuthInterface::class),
                    $container->get(ResponseFactoryInterface::class),
                    $container->get(AuthRequestErrorHandler::class)
                );
            }
        );
    }
}
