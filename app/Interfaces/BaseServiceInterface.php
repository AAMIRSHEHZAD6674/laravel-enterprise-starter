<?php

namespace App\Interfaces;

interface BaseServiceInterface
{
    public function all();

    public function paginate(int $perPage = 10);

    public function find(int $id);

    public function create(array $data);

    public function update($model, array $data);

    public function delete($model);
}