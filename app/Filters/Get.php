<?php

namespace App\Filters;

use Closure;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cache;

class Get extends Filter{
    public $noParam = true;
    protected function applyFilter($builder){
        return $this->paginateOrGet($builder);
    }

    private static function getTagAndName($userId = null){
        $uri = request()->getRequestUri();
        $uriBoom = explode('?', $uri);
        $tag = [];
        if(!empty($userId)){
            $tag[] = 'user-' . $userId;
        }
        if(count($uriBoom) > 1){
            $queryStr = explode('&', $uriBoom[1]);
            sort($queryStr);
            $pathBoom = array_slice(explode('/', $uriBoom[0]), 1);
            $tag[] = $pathBoom[0];
            $key = implode('.', $pathBoom) . '.' . (empty($userId) ? implode('.', $queryStr) : implode('.', $queryStr) . '.' . 'user-' . $userId);
        }else{
            $pathBoom = array_slice(explode('/', $uri), 1);
            $tag[] = $pathBoom[0];
            $key = implode('.', $pathBoom) . (empty($userId) ? '' : '.' . 'user-' . $userId);
        }

        return ['key' => $key, 'tag' => $tag];
    }

    private static function uncachedPaginateOrGet($query){
        if(request()->has('paginate')){
            $q = $query->paginate(request('paginate'))->withQueryString();
        }else{
            $q = $query->get();
        }
        // return $query;
        return $q;
    }

    private static function paginateOrGet($query, $userId = null){
      $namingObj = self::getTagAndName($userId);

      if(env('USE_CACHE', false)){
          if(request()->has('paginate')){
              $q = Cache::tags($namingObj['tag'])->remember($namingObj['key'], 24 * 60 * 60, function() use ($query){
                  return $query->paginate(request('paginate'))->withQueryString();
              });
          }else{
              $q = Cache::tags($namingObj['tag'])->remember($namingObj['key'], 24 * 60 * 60, function() use ($query){
                  return $query->get();
              });
          }
      }else{
          if(request()->has('paginate')){
            if(request()->has('complete_paginate')){
                $q = $query->paginate(request('paginate'))->withQueryString();
            }else{
                $q = $query->simplePaginate(request('paginate'))->withQueryString();
            }
          }else{
              $q = $query->get();
          }
      }
      // return $query;
      return $q;
    }
}
