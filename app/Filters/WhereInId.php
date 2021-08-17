<?php

namespace App\Filters;

class WhereInId extends Filter{
    public $noParam = false;
    protected function applyFilter($builder){
        $ids = json_decode(request('where_in_id'));
        return $builder->whereIn('id', $ids);
    }
}
