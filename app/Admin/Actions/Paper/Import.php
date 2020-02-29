<?php

namespace App\Admin\Actions\Paper;

use App\Imports\PapersImport;
use App\Models\Paper;
use Encore\Admin\Actions\Action;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class Import extends Action
{
    protected $selector = '.import';

    public function handle(Request $request)
    {
        // 导入试卷
        $papersImport = new PapersImport();
        // 将excel数据转为数组数据
        $temp = Excel::toArray($papersImport, $request->file('file'));
        // 对paper数组数据进行处理
        $paperContent = $papersImport->getPaper($temp[0]);

        // 将paper数据保存到数据库中
        $paper = Paper::create([
            'author' => $request->input('author'),
            'total' => count($paperContent['content']),
            'description' => $request->input('description'),
            'title' => $request->input('title'),
            'type' => $paperContent['type']
        ]);
        $paper->questions()->sync($paperContent['content']);

        return $this->response()->success('导入试卷成功')->refresh();
    }

    public function form()
    {
        $this->text('title', '试卷标题')->placeholder('输入 试卷标题(必填)')->required()->rules('required|between:2,30');
        $this->text('author', '出题人')->placeholder('输入 出题人(选填)')->rules('required|between:2,20');
        $this->text('description', '试卷简介')->placeholder('输入 试卷简介(选填)')->rules('required|between:2,150');
        $this->file('file', '请选择Excel');
    }

    public function html()
    {
        return <<<HTML
        <a class="btn btn-sm btn-default import"><i class="fa fa-upload"></i> 导入试卷</a>
HTML;
    }
}
