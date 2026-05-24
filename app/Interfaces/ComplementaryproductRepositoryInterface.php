<?php

namespace App\Interfaces;

interface ComplementaryproductRepositoryInterface
{
    //

    public function getAll();
    public function getComplementariesByproduct($id);
}
