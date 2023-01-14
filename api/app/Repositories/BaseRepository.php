<?php

namespace App\Repositories;

abstract class BaseRepository
{
    protected $model;

    public function all()
    {
        return $this->model->all('*');
    }

    public function find($id, $with = null, $columns = ['*'])
    {
        if($with) {
            return $this->model->with($with)->find($id, $columns);
        }
        return $this->model->find($id, $columns);
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function update(array $data)
    {
        return $this->model->update($data);
    }
}
