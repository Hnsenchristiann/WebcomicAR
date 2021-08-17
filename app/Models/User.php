<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Laratrust\Traits\LaratrustUserTrait;

class User extends Authenticatable
{
    use LaratrustUserTrait;
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'full_name',
        'purchase_history',
        'read_history'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function hasRead(){
        return $this->belongsToMany(Comic::class, 'read_histories', 'comic_id', 'user_id');
    }

    public function hasPurchased(){
        return $this->belongsToMany(Comic::class, 'purchase_histories', 'comic_id', 'user_id');
    }

    public function comments(){
        return $this->hasMany(Comment::class);
    }

    public function likes(){
        return $this->belongsToMany(Comic::class, 'likes', 'comic_id', 'user_id');
    }

    public function bookmarked(){
        return $this->belongsToMany(Page::class);
    }

    public function favorites(){
        return $this->belongsToMany(Comic::class);
    }

    public function checkComicPurchased($comicId){
        $purchaseHistory = collect(json_decode($this->purchase_history));
        return empty($purchaseHistory[$comicId]) ? [] : $purchaseHistory[$comicId];
    }

    public function getPurchasedComics(){
        $purchasedId = collect(json_decode($this->purchase_history))->keys()->toArray();
        return Comic::whereIn('id', $purchasedId)->get();
    }

    public function purchaseComic($comicId, $chapters, $ar = []){//to be called after sucessful payment
        $comicObj = Comic::findOrFail($comicId);
        $currentPurchaseObj = json_decode($this->purchase_history, true);
        $jsonString = 'purchase_history->' . $comicId;
        if(array_key_exists($comicId, $currentPurchaseObj)){
            $currentChapter = $currentPurchaseObj[$comicId]['chapters'];
            $currentChapter = array_merge($currentChapter, $chapters);
            $purchaseObject = [
                'price' => $comicObj->price,
                'ar' => $ar,
                'id' => $comicId,
                'date' => now(),
                'chapters' => $currentChapter
            ];
        }else{
            $purchaseObject = [
                'price' => $comicObj->price,
                'ar' => $ar,
                'id' => $comicId,
                'date' => now(),
                'chapters' => $chapters
            ];
        }
        $uid = $this->id;
        return self::where('id', $uid)->update([$jsonString => $purchaseObject]);
    }

    public function bookmarkPage($pageId){
        $siblingIds = Page::findOrFail($pageId)->comic()->with('pages')->get()->pluck('pages')[0]->pluck('id')->toArray();
        $bookmarked = $this->load('bookmarked')->bookmarked->pluck('id')->toArray();
        $newBookmarked = array_values(array_diff($bookmarked, $siblingIds));
        $newBookmarked[] = $pageId;
        return $this->bookmarked()->sync($newBookmarked);
    }

    public function toggleFavoriteComic($comicId){
        $faved = $this->load('favorites')->favorites->pluck('id')->toArray();
        if(in_array($comicId, $faved)){
            unset($faved[array_search($$comicId, $faved)]);
        }else{
            $faved[] = $comicId;
        }
        return $this->favorites()->sync($faved);
    }

    public function getComicBookmarkedPage($comicId){
        $bookmarked = $this->bookmarked()->get()->pluck('id')->toArray();
        $comicIds = Comic::findOrFail($comicId)->pages()->get()->pluck('id')->toArray();
        $pageId = array_values(array_intersect($bookmarked, $comicIds));
        if(!empty($pageId)){
            return Page::select('page_number', 'chapter')->findOrFail($pageId[0])->toArray();
        }else{
            return [];
        }
    }
}
