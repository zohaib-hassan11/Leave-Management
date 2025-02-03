<?php

namespace App\Repositories\Traits;

trait RelatedTrait
{
    public function loadRelations($relations = [])
    {
        return $this->model->with($relations)->get();
    }
}
