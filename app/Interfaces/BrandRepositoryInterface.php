<?php

namespace App\Interfaces;

interface BrandRepositoryInterface
{
    //
    public function getAll();

    public function getByModell($id);
}
