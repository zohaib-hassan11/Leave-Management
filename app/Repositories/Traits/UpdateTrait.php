<?php

namespace App\Repositories\Traits;

trait UpdateTrait
{
    public function update($id, array $data)
    {
        $record = $this->model->findOrFail($id);
        $record->update($data);
        return $record;
    }
}
