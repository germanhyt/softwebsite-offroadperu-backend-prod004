<?php

namespace App\Interfaces;

interface SubcategoryRepositoryInterface
{
    //
    public function getAll();

    public function getByIdcategory($id);
}
