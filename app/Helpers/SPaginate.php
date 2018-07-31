<?php

namespace App\Helpers;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;

class SPaginate
{

    /**
     * Gera a paginação dos itens de um array ou collection.
     *
     * @param array|Collection      $items
     * @param int   $perPage
     * @param int  $page
     * @param array $options
     * @param bool  $sort
     *
     * @return LengthAwarePaginator
     */
    public function paginate($items, $perPage = 20, $page = null, $options = [], $sort = true)
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);

        $items = $items instanceof Collection ? $items : Collection::make($items);

        $value = $items->forPage($page, $perPage)->toArray();

        if($sort) {
            sort($value);
        }


        return new LengthAwarePaginator($value, $items->count(), $perPage, $page, $options);
    }

}