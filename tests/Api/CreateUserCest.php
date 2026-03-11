<?php

declare(strict_types=1);

namespace App\Tests\Api;

use App\Tests\Support\ApiTester;

final class CreateUserCest
{
    public function _before(ApiTester $I): void
    {
        // Code here will be executed before each test function.
    }

    // All `public` methods will be executed as tests.
    public function tryToTest(ApiTester $I): void
    {
        $I->sendPost('/api/users', json_encode([
            'nombre'    => 'Juan',
            'apellido'  => 'Pérez',
            'correo'    => 'dev@test.com',
            'contrasena' => '123456',
        ]));

        $I->seeResponseCodeIs(201);
        $I->seeResponseIsJson();
        $I->seeResponseContains('"correo":"dev@test.com"');
    }
}
