<?php

namespace Merkeleon\PhpCryptocurrencyAddressValidation\Validation;

use CBOR\ByteStringObject;
use CBOR\Tag\GenericTag;
use Merkeleon\PhpCryptocurrencyAddressValidation\Base58Validation;
use Merkeleon\PhpCryptocurrencyAddressValidation\Utils\Bech32Decoder;
use Merkeleon\PhpCryptocurrencyAddressValidation\Utils\Bech32Exception;
use CBOR\Decoder;
use CBOR\OtherObject;
use CBOR\Tag;
use CBOR\StringStream;

class ADA extends Base58Validation
{
    protected $validLengths = [
        33, // A
        66, // D
    ];
    protected $validBechPrefix = 'addr';

    public function isValidV1($address) {
        try {
            $addressHex = self::base58ToHex($address);

            $otherObjectManager = new OtherObject\OtherObjectManager();
            $otherObjectManager->add(OtherObject\SimpleObject::class);

            $tagManager = new Tag\TagManager();
            $tagManager->add(Tag\UnsignedBigIntegerTag::class);

            $decoder = new Decoder($tagManager, $otherObjectManager);
            $data = hex2bin($addressHex);
            $stream = new StringStream($data);
            $object = $decoder->decode($stream);
            $normalizedData = $object->normalize();
            if ($object->getMajorType() != 4) {
                return false;
            }
            if (count($normalizedData) != 2) {
                return false;
            }
            if (!is_numeric($normalizedData[1])) {
                return false;
            }
            if (!$normalizedData[0] instanceof GenericTag) {
                return false;
            }
            $bs = $normalizedData[0]->getValue();
            if (!$bs instanceof ByteStringObject) {
                return false;
            }
            if (!in_array($bs->getLength(), $this->validLengths)) {
                return false;
            }
            $crcCalculated = crc32($bs->getValue());
            $validCrc = $normalizedData[1];

            return $crcCalculated == (int)$validCrc;
        } catch (\Exception $e) {
            return false;
        }
    }

    public function validate($address) {
        $valid = $this->isValidV1($address);
        if (!$valid) {
            // maybe it's a bech32 address
            try {
                $valid = is_array($decoded = Bech32Decoder::decodeRaw($address)) && $this->validBechPrefix === $decoded[0];
            } catch (Bech32Exception $exception) {}
        }

        return $valid;
    }
}
