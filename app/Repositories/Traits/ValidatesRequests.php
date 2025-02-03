<?php

namespace App\Repositories\Traits;

trait ValidatesRequests
{
    public function validateRequest(array $data, array $rules)
    {
        return validator($data, $rules)->validate();
    }
}
