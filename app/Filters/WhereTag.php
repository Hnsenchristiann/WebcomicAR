<?php

namespace App\Filters;

class WhereTag extends Filter{
    public $noParam = false;
    protected function applyFilter($builder){
        $tag = request('where_tag');
        return $builder->whereJsonContains('tags', $tag);
    }
}
