<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'content', 'published_at', 'image'];

    public function category(){
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function tags(){
        return $this->belongsToMany(Tag::class)->withPivot('post_id', 'tag_id');
    }
}
