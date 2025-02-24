<?php

namespace App\Interfaces;

interface IBaseRepository
{
    public function pagination($data = []);

    public function collection($data = []);

    public function search(string|array $column, string $value);

    public function create($data);

    public function update($data, $id);

    public function delete($id);

    public function findById($id);
}
