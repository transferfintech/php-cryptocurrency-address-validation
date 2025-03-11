<?php

namespace Tests\Validation;

use Merkeleon\PhpCryptocurrencyAddressValidation\Validation;

class EOSTest extends BaseValidationTestCase
{
    public function getValidationInstance(): Validation
    {
        return Validation::make('EOS');
    }

    public function addressProvider()
    {
        return [
            ['taggartdagny', true],
            ['eosx.game', true],
            ['big1.mlt', true],
            ['*(#)!@*)#*!@)(#*', false],
        ];
    }
}
