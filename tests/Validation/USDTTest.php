<?php

namespace Tests\Validation;

use Merkeleon\PhpCryptocurrencyAddressValidation\Validation;

class USDTTest extends BaseValidationTestCase
{
    public function getValidationInstance(): Validation
    {
        return Validation::make('USDT');
    }

    public function addressProvider()
    {
        return [
            ['0x05a56e2d52c817161883f50c441c3228cfe54d9f', true],
            ['TF5Bn4cJCT6GVeUgyCN4rBhDg42KBrpAjg', true],
            ['TR7NHqjeKQxGTCi8q8ZY4pL8otSzgjLj6t', true],
            ['05a56e2d52c817161883f50c441c3228cfe54d9f', false],
            ['3QJmV3qfvL9SuYo34YihAf3sRCW3qSinyC', false],
        ];
    }
}
