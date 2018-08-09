<?php

namespace App\Traits\Generic;


trait Paginate
{
    public function mountPaginate($data)
    {
        if (gettype($data) != 'array') {
            $data = $data->toArray();
        }

        $listData = $data['data'];
        unset($data['data']);

        return [
            'data' => $listData,
            'meta' => [
                'pagination' => $data
            ]
        ];
    }
}