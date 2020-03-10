<?php

namespace App\Http\Controllers;

use App\Models\ArticleDir;
use App\Services\WordDocServices;
use Illuminate\Http\Request;

class ArticleDirsController extends Controller
{
    public function index()
    {
        $article_dirs = ArticleDir::query()->where('is_cover', ArticleDir::IS_COVER)->paginate(8);
        return view('article_dir.index', compact('article_dirs'));
    }

    // 获取文章目录
    public function show($id, WordDocServices $wordDocServices)
    {
        $data = $wordDocServices->getFormatDirTree(ArticleDir::find($id));
        return response()->json(['msg' => 'success', 'data' => $data]);
    }
}
