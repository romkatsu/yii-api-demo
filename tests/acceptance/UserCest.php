<?php

namespace App\Tests\Acceptance;

use App\Tests\AcceptanceTester;
use Codeception\Util\HttpCode;

final class UserCest
{
    public function index(AcceptanceTester $I): void
    {
        $I->haveHttpHeader(
            'X-Api-Key',
            'lev1ZsWCzqrMlXRI2sT8h4ApYpSgBMl1xf6D4bCRtiKtDqw6JN36yLznargilQ_rEJz9zTfcUxm53PLODCToF9gGin38Rd4NkhQPOVeH5VvZvBaQlUg64E6icNCubiAv'
        );
        $I->sendGET('/users/');
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(
            [
                'status' => 'success',
                'error_message' => '',
                'error_code' => null,
                'data' => [
                    'users' => [
                        [
                            'login' => 'Athena7928',
                            'created_at' => '26.07.2020 20:18:11',
                        ]
                    ]
                ]
            ]
        );
    }

    public function view(AcceptanceTester $I): void
    {
        $I->haveHttpHeader(
            'X-Api-Key',
            'lev1ZsWCzqrMlXRI2sT8h4ApYpSgBMl1xf6D4bCRtiKtDqw6JN36yLznargilQ_rEJz9zTfcUxm53PLODCToF9gGin38Rd4NkhQPOVeH5VvZvBaQlUg64E6icNCubiAv'
        );
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->sendGET('/users/1');
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(
            [
                'status' => 'success',
                'error_message' => '',
                'error_code' => null,
                'data' => [
                    'user' => [
                        'login' => 'Opal1144',
                        'created_at' => '26.07.2020 20:18:11',
                    ]
                ]
            ]
        );
    }

    public function viewBadId(AcceptanceTester $I): void
    {
        $I->haveHttpHeader(
            'X-Api-Key',
            'lev1ZsWCzqrMlXRI2sT8h4ApYpSgBMl1xf6D4bCRtiKtDqw6JN36yLznargilQ_rEJz9zTfcUxm53PLODCToF9gGin38Rd4NkhQPOVeH5VvZvBaQlUg64E6icNCubiAv'
        );
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->sendGET('/users/1000');
        $I->seeResponseCodeIs(HttpCode::NOT_FOUND);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(
            [
                'status' => 'failed',
                'error_message' => 'Entity not found',
                'error_code' => HttpCode::NOT_FOUND,
                'data' => null
            ]
        );
    }
}
