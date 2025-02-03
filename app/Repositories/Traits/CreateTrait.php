<?php

namespace App\Repositories\Traits;

trait CreateTrait
{
    public function create(array $data)
    {
        return $this->model->create($data);
    }
}
