<?php

namespace Merkeleon\PhpCryptocurrencyAddressValidation\Validation;

class USDT extends ETH
{
    public function validate($address)
    {
        if ($this->isAddress($address)) {
            return true;
        }

        $validator = new TRX();
        return $validator->validate($address);
    }
}
