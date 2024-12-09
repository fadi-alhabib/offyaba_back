<?php

namespace App\Interfaces;

interface QrCodeScanInterface
{
    public function check(array $array): array;
}
