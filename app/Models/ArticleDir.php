<?php

namespace App\Models;

use Encore\Admin\Traits\AdminBuilder;
use Encore\Admin\Traits\ModelTree;
use Illuminate\Database\Eloquent\Model;

class ArticleDir extends Model
{
    use ModelTree, AdminBuilder;

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->setParentColumn('pid');
        $this->setOrderColumn('sort');
        $this->setTitleColumn('category');
    }

    protected $fillable = [
        'category',
        'sort',
        'pid',
        'memo',
        'is_cover'
    ];

    protected $casts = [
        'is_cover' => 'boolean'
    ];

    // 是否为封面
    const NOT_COVER = 0;
    const IS_COVER = 1;

    public static $coverMap = [
        self::NOT_COVER => '不是封面',
        self::IS_COVER => '封面'
    ];

    public function articles()
    {
        return $this->hasMany(Article::class);
    }

}
