<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Maize\Markable\Markable;
use Maize\Markable\Models\Like;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Photo extends Model implements HasMedia
{
    use InteractsWithMedia, Markable, Authenticatable;

    protected $fillable = [
        'caption'
    ];

    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
    ];

    protected $with = [
        'tags',
        'user'
    ];

    protected $appends = [ 
        'image',
        'like'
    ];

    protected $hidden = [ 
        'media'
    ];

    protected static $marks = [
        Like::class,
    ];

    public static function boot()
    { 
        parent::boot();

        static::creating(function ($model) {

            $model->user_id = auth()->user()->id;
        });
    }

    public function registerMediaCollections(): void
    {
        $this
            ->addMediaCollection('photo')
            ->acceptsMimeTypes(['image/jpeg', 'image/jpg', 'image/png', 'image/webp'])
            ->singleFile();
    }

    //MUTATORS
    public function getImageAttribute()
    {
        return $this->getFirstMediaUrl('photo') ?? null;
    }

    public function getLikeAttribute()
    {
        return $this->likes->count();
    }
    
    //RELATIONSHIP
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'photo_tag');
    }

    //SCOPE
    public function scopeMine($query)
    {
        return $query->where('user_id', auth()->user()->id);
    }
}