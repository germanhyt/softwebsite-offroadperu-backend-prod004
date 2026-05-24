<?php

namespace App\Repositories;

use App\Interfaces\ClientRepositoryInterface;
use App\Models\Client;

class ClientRepository implements ClientRepositoryInterface
{

    public function save(array $data): bool
    {
        return Client::create($data) ? true : false;
    }

    public function findByEmail(string $email): ?Client
    {
        return Client::where('email', $email)->first();
    }
}
