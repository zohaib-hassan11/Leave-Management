<?php

namespace App\Repositories\Traits;

trait PaginateTrait
{
    public function getAll($search = null, $perPage = 5)
    {
        $query = $this->model::query();

        if ($search) {
            $query->where('name', 'like', '%' . $search . '%')
                  ->orWhere('email', 'like', '%' . $search . '%');
        }

        return $query->paginate($perPage);
    }
}
