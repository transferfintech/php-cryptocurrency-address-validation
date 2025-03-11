<?php

namespace Merkeleon\PhpCryptocurrencyAddressValidation\Validation;

use Merkeleon\PhpCryptocurrencyAddressValidation\Validation;

class EOS extends Validation
{
    public function isAddress($address)
    {
        return preg_match('/(^[a-z1-5.]{1,11}[a-z1-5]$)|(^[a-z1-5.]{12}[a-j1-5]$)/', $address) === 1;
    }

    public function validate($address)
    {
        return $this->isAddress($address);
    }
}
