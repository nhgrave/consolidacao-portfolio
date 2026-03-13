<?php

namespace App\DTO;

class AssetDTO
{
    public function __construct(
        public string $asset,
        public string $type,
        public string $broker,
        public float $tax,
        public float $value
    ) {}
}
