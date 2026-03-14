<?php

namespace App\DTO;

class WarningDTO
{
    public function __construct(
        public string $code,
        public ?string $broker = null
    ) {}
}
