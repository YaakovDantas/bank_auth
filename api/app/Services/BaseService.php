<?php

namespace App\Services;

use App\Exceptions\BusinessException;
use Illuminate\Database\QueryException;

abstract class BaseService
{
    protected $repository;
    protected $NotFoundMessage;

    public function all()
    {
        return $this->repository->all(['*']);
    }

    public function find($id)
    {
        $model = $this->repository->find($id);
        if(!$model) {
            throw new BusinessException($this->NotFoundMessage, 404);
        }

        return $model;
    }

    public function create(array $data)
    {
        try {
            return $this->repository->create($data);
        } catch (QueryException $e) {
            throw new BusinessException('Username is already been used, try another one.', 422);
        } catch (\Exception $e) {
            throw new BusinessException('Something went wrong.', 500);
        }
    }
}
