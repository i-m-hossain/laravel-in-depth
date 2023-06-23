<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Comment;
use App\Models\User;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Post extends Model
{
    use HasFactory;
    protected $casts=[
        'body'=>'array'
    ];
    protected function titleUpperCase():Attribute{
        return Attribute::make(
            get: fn()=> strtoupper($this->title)
        );
    }
    protected function title():Attribute{
        return Attribute::make(
            set:fn($value)=> $this->attributes['title'] = strtolower($value)
        );
    }
    public function comments(){
        return $this->hasMany(Comment::class, 'post_id');
    }
    // pivot table reference
    public function users(){
        return $this->belongsToMany(User::class, "post_user", "post_id", "user_id");
    }
}
