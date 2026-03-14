<?php

namespace App\DTO;

class PortfolioDTO
{
    public function __construct(
        public int $client_id,
        public array $portfolio,
        public array $resume,
        public array $warnings,
    ) {}
}
