<?php

namespace Merkeleon\PhpCryptocurrencyAddressValidation\Validation;

use CBOR\Decoder;
use CBOR\OtherObject;
use CBOR\Tag;
use CBOR\StringStream;

class TADA extends ADA
{
    protected $validLengths = [
        40, // 2
        73, // 3
    ];
    protected $validBechPrefix = 'addr_test';
}
