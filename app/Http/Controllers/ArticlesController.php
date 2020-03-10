<?php

namespace App\Http\Controllers;

use App\Exceptions\InvalidRequestException;
use App\Models\Article;
use App\Models\ArticleDir;
use App\Services\WordDocServices;
use Illuminate\Http\Request;

class ArticlesController extends Controller
{
    // 显示文章
    public function show(ArticleDir $articleDir, $id = 0, WordDocServices $wordDocServices)
    {
        // 获取目录树
        $dir_tree = $wordDocServices->getFormatDirTree($articleDir);
        // 获取文档列表
        $artilceList = $wordDocServices->getArticleListByMenu($dir_tree);
        // 如果没有文档
        if (empty($artilceList)) throw new InvalidRequestException('当前文档没有数据');
        // 获取文档
        $article = ($id === 0) ? Article::find($artilceList[0]['id']) : Article::find($id);
        return view('article.show', compact('artilceList', 'article', 'articleDir'));
    }


}
