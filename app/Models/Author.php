<?php

namespace App\Models;

use App\Filters\Get;
use App\Traits\Pipeable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Author extends Model
{
    use HasFactory;
    use Pipeable;
    protected $guarded = [];

    public function pipeable(){
        return [
            Get::class
        ];
    }

    public function comics(){
        return $this->belongsToMany(Comic::class);
    }
}
