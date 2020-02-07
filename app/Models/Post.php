<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = [
        'name',
        'sort'
    ];

    public function question()
    {
        return $this->hasMany(Question::class);
    }
}
