<?php

namespace App\Repositories\Traits;

trait GetTrait
{
    public function findById($id)
    {
        return $this->model->find($id);
    }
}
