<?php


namespace App\Services;

// 旧文档模块
use App\Models\ArticleDir;

class WordDocServices
{
    public function getTree(ArticleDir $articleDir)
    {
        // 获取当前文章的树结构
        $dir_tree = $articleDir->with('articles:id,article_dir_id,title,sort')
            ->orderBy('sort', 'desc')
            ->get()
            ->toArray();
        $dir_tree = $this->buildNestedArray($dir_tree, $articleDir->id);   // 完整结构
        return $dir_tree;
    }

    /**
     * 获取格式化后的dirTree
     */
    public function getFormatDirTree(ArticleDir $articleDir)
    {
        // 获取当前文章的树结构
        $dir_tree = $articleDir->with('articles:id,article_dir_id,title,sort')
            ->orderBy('sort', 'desc')
            ->get()
            ->toArray();
        $dir_tree = $this->buildNestedArray($dir_tree, $articleDir->id);   // 完整结构
        $dir_tree = $this->menuFormat($dir_tree);  // 方便用户观看的结构
        return $dir_tree;
    }


    /**
     * 生成完整的文档目录
     * @param array $nodes
     * @param int $parentId
     * @return array
     */
    protected function buildNestedArray(array $nodes = [], $parentId = 0)
    {
        $branch = [];
        if (empty($nodes)) {
            $nodes = ArticleDir::all()->toArray();
        }
        foreach ($nodes as $node) {
            if ($node['pid'] == $parentId) {
                $children = $this->buildNestedArray($nodes, $node['id']);
                if ($children) $node['children'] = $children;
                $node['title'] = $node['category'];
                $branch[] = $node;
            }
        }
        return $branch;
    }

    /**
     * 目的：由于早期文章模块的混乱，本函数的目的主要是兼容多级文章目录多级转两级
     * 作用：将tree返回的文章目录（原本是3级的）传到本函数里，返回两级的菜单
     */
    private function menuFormat($tree_arr, $arr = [])
    {
        if (empty($arr)) $arr = [];
        foreach ($tree_arr as $value) {
            if (isset($value['children'])) {
                $arr[] = $this->menuFormat($value['children'], $arr);
            }
            if (isset($value['articles']) && count($value['articles']) != 0) {
                $value['children'] = $value['articles'];
                return $value;
            }
        }
        return $arr;
    }

    /**
     * 菜单规范支持: layui-tree
     */
    private function menuFormat2($tree_arr, $parentId)
    {
        $branch = [];
        foreach ($tree_arr as $node) {
            if ($node['pid'] == $parentId) {
                $children = $this->buildNestedArray($tree_arr, $node['id']);
                if ($children) $node['children'] = $children;
                $branch[] = $node;
            }
        }
        return $branch;
    }

    /**
     * 根据传过来的文章目录菜单生成文章列表
     * @param $dir_tree 要传入getDetailDirTree() 或者 getFormatDirTree()返回的dir_tree
     * @return array
     */
    public function getArticleListByMenu($dir_tree) {
        $articleList = [];
        foreach (array_column($dir_tree, 'articles') as $item) {
            $articleList = array_merge($articleList, $item);
        }
        return $articleList;
    }
}
