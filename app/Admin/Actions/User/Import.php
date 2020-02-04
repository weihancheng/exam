<?php

namespace App\Admin\Actions\User;

use App\Imports\UsersImport;
use Encore\Admin\Actions\Action;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class Import extends Action
{
    protected $selector = '.import';

    public function handle(Request $request)
    {
        // 导入excel
        Excel::import(new UsersImport(), $request->file('file'));
        return $this->response()->success('导入用户成功!')->refresh();
    }

    public function form()
    {
        $this->file('file', '请选择文件');
    }

    public function html()
    {
        return <<<HTML
        <a class="btn btn-sm btn-default import"><i class="fa fa-upload"></i> 导入用户</a>
HTML;
    }
}
