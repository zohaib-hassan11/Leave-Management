<?php

namespace App\Repositories\Traits;

trait DeleteMultipleTrait
{
    public function deleteMultiple(array $ids)
    {
        return $this->model->whereIn('id', $ids)->delete();
    }
}
