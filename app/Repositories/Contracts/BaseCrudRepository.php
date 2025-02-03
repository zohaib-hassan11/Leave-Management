<?php

namespace App\Repositories\Contracts;

use App\Repositories\Contracts\BaseCrudRepositoryInterface;
use Illuminate\Database\Eloquent\Model;
use App\Repositories\Traits\PaginateTrait;
use App\Repositories\Traits\RelatedTrait;
use App\Repositories\Traits\GetTrait;
use App\Repositories\Traits\CreateTrait;
use App\Repositories\Traits\UpdateTrait;
use App\Repositories\Traits\DeleteTrait;
use App\Repositories\Traits\DeleteMultipleTrait;
use App\Repositories\Traits\ValidatesRequests;

class BaseCrudRepository implements BaseCrudRepositoryInterface
{
    use PaginateTrait ,PaginateTrait, RelatedTrait, GetTrait, CreateTrait, UpdateTrait, DeleteTrait, DeleteMultipleTrait, ValidatesRequests;

    protected $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }
}
