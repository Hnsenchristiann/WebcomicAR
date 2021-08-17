<?php

namespace App\Filters;

class WhereGenre extends Filter{
    public $noParam = false;
    protected function applyFilter($builder){
        $genre = request('where_genre');
        return $builder->whereJsonContains('genres', $genre);
    }
}
