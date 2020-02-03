<?php

namespace App\Admin\Actions\User;

use Encore\Admin\Actions\Action;
use Illuminate\Http\Request;

class ImportUser extends Action
{
    protected $selector = '.import-user';

    public function handle(Request $request)
    {
        $request->file('file')->store('excel');
        return $this->response()->success('导入用户成功!')->refresh();
    }

    public function form()
    {
        $this->file('file', '请选择文件');
    }

    public function html()
    {
        return <<<HTML
        <a class="btn btn-sm btn-default import-user"><i class="fa fa-upload"></i> 导入用户</a>
HTML;
    }
}
