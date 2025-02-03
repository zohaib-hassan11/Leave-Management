<?php

namespace App\Repositories\Traits;

trait DeleteTrait
{
    public function delete($id)
    {
        $record = $this->model->findOrFail($id);
        return $record->delete();
    }
}
