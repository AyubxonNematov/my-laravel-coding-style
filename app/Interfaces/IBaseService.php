<?php

namespace App\Interfaces;

interface IBaseService
{
    public function pagination($data = []);

    public function collection($data = []);

    public function searchModel(string|array $column, string $value);

    public function createModel($data);

    public function updateModel($data, $id);

    public function deleteModel($id);

    public function getModelById($id);
}
