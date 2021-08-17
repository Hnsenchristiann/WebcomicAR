<?php

namespace App\Filters;

use Closure;
use Illuminate\Support\Str;

abstract class Filter{
    public $noParam;

    public function handle($request, Closure $next){
        if(!request()->has($this->filterName()) && !$this->noParam){
            return $next($request);
        }
        $builder = $next($request);
        return $this->applyFilter($builder);
        //return $builder->where('body_part_id', request('body_part'));
    }

    protected abstract function applyFilter($builder);

    protected function filterName(){
        return Str::snake(class_basename($this));
    }
}
