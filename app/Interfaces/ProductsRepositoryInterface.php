<?php

namespace App\Interfaces;

interface ProductsRepositoryInterface
{
    //
    public function getAll();
    public function getById($id);
    public function getByName(array $filters);
    public function getByDescription(array $filters);

    public function getByTrend($id);
    public function getByMostRequested($id);

    public function filters(array $filters, $perPage);
    public function getPaginated($perPage);
}
