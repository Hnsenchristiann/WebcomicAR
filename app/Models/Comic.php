<?php

namespace App\Models;

use App\Filters\Get;
use App\Filters\WhereGenre;
use App\Filters\WhereTag;
use App\Filters\WhereInId;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Pipeable;

class Comic extends Model
{
    use HasFactory;
    use Pipeable;
    protected $guarded = [];

    public function pipeable(){
        return [
            Get::class,
            WhereTag::class,
            WhereGenre::class,
            WhereInId::class,
        ];
    }

    public function authors(){
        return $this->belongsToMany(Author::class);
    }

    public function pages(){
        return $this->hasMany(Page::class);
    }

    public function purchasedBy(){
        $whereName = implode('->', ['purchase_history', $this->id, 'id']);
        return User::where($whereName, $this->id)->get();
        // return $this->belongsToMany(User::class, 'purchase_histories', 'user_id', 'comic_id');
    }

    public function readBy(){
        return $this->belongsToMany(User::class, 'read_histories', 'user_id', 'comic_id');
    }

    public function ratings(){
        return $this->belongsToMany(User::class, 'ratings', 'user_id', 'comic_id')->withPivot(['rating']);
    }

    public function likes(){
        return $this->belongsToMany(User::class, 'likes', 'user_id', 'comic_id');
    }

    public function comments(){
        return $this->hasMany(Comment::class);
    }

    public function favorited(){
        return $this->belongsToMany(User::class);
    }
}
