<?php

declare(strict_types=1);

namespace App\Controller;

use App\Builder\PostBuilder;
use App\Entity\Post;
use App\Exception\BadRequestException;
use App\Form\PostForm;
use App\Formatter\PaginatorFormatter;
use App\Formatter\PostFormatter;
use App\Repository\PostRepository;
use App\Service\BlogService;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Yiisoft\DataResponse\DataResponseFactoryInterface;

final class BlogController extends Controller
{
    private DataResponseFactoryInterface $responseFactory;
    private PostRepository $postRepository;
    private PostFormatter $postFormatter;
    private PostBuilder $postBuilder;
    private BlogService $blogService;

    public function __construct(
        PostRepository $postRepository,
        DataResponseFactoryInterface $responseFactory,
        PostFormatter $postFormatter,
        PostBuilder $postBuilder,
        BlogService $blogService
    ) {
        $this->postRepository = $postRepository;
        $this->responseFactory = $responseFactory;
        $this->postFormatter = $postFormatter;
        $this->postBuilder = $postBuilder;
        $this->blogService = $blogService;
    }

    public function index(Request $request, PaginatorFormatter $paginatorFormatter): Response
    {
        $paginator = $this->blogService->getPosts(
            $this->getPageQueryParam($request)
        );

        $posts = [];
        foreach ($paginator->read() as $post) {
            $posts[] = $this->postFormatter->format($post);
        }

        return $this->responseFactory->createResponse(
            [
                'paginator' => $paginatorFormatter->format($paginator),
                'posts' => $posts
            ]
        );
    }

    public function view(Request $request): Response
    {
        return $this->responseFactory->createResponse(
            [
                'post' => $this->postFormatter->format(
                    $this->blogService->getPost((int)$request->getAttribute('id'))
                )
            ]
        );
    }

    public function create(Request $request, PostForm $form): Response
    {
        $form->setAttributes($request->getParsedBody());
        if (!$form->validate()) {
            throw new BadRequestException($form->getFirstError());
        }

        $post = $this->postBuilder->build(new Post(), $form);
        $post->setUser($this->getUserFromRequest($request));

        $this->postRepository->save($post);

        return $this->responseFactory->createResponse();
    }

    public function update(Request $request, PostForm $form): Response
    {
        $form->setAttributes($request->getParsedBody());
        if (!$form->validate()) {
            throw new BadRequestException($form->getFirstError());
        }

        $post = $this->postBuilder->build(
            $this->blogService->getPost((int)$request->getAttribute('id')),
            $form
        );

        $this->postRepository->save($post);

        return $this->responseFactory->createResponse();
    }

    private function getPageQueryParam(Request $request): int
    {
        $params = $request->getQueryParams();
        if (isset($params['page'])) {
            return (int)$params['page'];
        }

        return 1;
    }
}
