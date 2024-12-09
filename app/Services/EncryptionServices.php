<?php

namespace App\Services;

use Defuse\Crypto\Crypto;
use Defuse\Crypto\Exception\BadFormatException;
use Defuse\Crypto\Exception\EnvironmentIsBrokenException;
use Defuse\Crypto\Exception\WrongKeyOrModifiedCiphertextException;
use Defuse\Crypto\Key;
use Illuminate\Support\Env;

class EncryptionServices
{
    protected static Key $key;

    public static function encrypt(array $data): string
    {
        self::setKey();
        $stringData = json_encode($data);
        return Crypto::encrypt($stringData, self::$key);
    }

    /**
     * @throws WrongKeyOrModifiedCiphertextException
     * @throws EnvironmentIsBrokenException
     */
    public static function decrypt(string $dataEncrypted): array
    {
        self::setKey();
        $stringData = Crypto::decrypt($dataEncrypted, self::$key);
        return json_decode($stringData, true);
    }
    private static function setKey(): void
    {
        self::$key = Key::loadFromAsciiSafeString(config('app.key_defuse.key'));
    }
}
