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

}
