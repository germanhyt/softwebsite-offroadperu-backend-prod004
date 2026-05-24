<?php

namespace App\Interfaces;

use App\Models\Client;

interface ClientRepositoryInterface
{
    public function save(array $data): bool;

    public function findByEmail(string $email): Client | null;
    
}
