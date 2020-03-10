<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    protected $fillable = [
        'title',
        'author',
        'content',
        'sort'
    ];

    public function article_dir()
    {
        return $this->hasOne(ArticleDir::class);
    }

}
