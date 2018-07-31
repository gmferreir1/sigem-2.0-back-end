<?php

namespace App\Contracts\Generic;

interface Crud
{
    /**
     * @param array $data
     * @param boolean $validate
     * @return mixed
     */
    public function create(array $data, $validate = true);

    /**
     * @param array $data
     * @param $id
     * @param boolean $validate
     * @return mixed
     */
    public function update(array $data, $id, $validate = true);

    /**
     * @param $id
     * @param null $presenter
     * @return mixed
     */
    public function find($id, $presenter = null);

    /**
     * @param $paginate
     * @param $limitPaginate
     * @param $setPresenter
     * @param array $fields
     * @return mixed
     */
    public function all($paginate = false, $limitPaginate = 100, $setPresenter = false, array $fields = ['*']);

    /**
     * @param $closure
     * @param $paginate
     * @param $limitPaginate
     * @param $presenter
     * @param array $fields
     * @return mixed
     */
    public function scopeQuery($closure, $paginate = false, $limitPaginate = 100, $presenter = null, array $fields = ['*']);

    /**
     * @param $id
     * @return mixed
     */
    public function delete($id);


    /**
     * @param array $params
     * @param $presenter
     * @return mixed
     */
    public function findWhere(array $params, $presenter = null);

    /**
     * @param array $params
     * @return mixed
     */
    public function findAndDelete(array $params);
}