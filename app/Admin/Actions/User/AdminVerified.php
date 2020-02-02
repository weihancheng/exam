<?php

namespace App\Admin\Actions\User;

use Encore\Admin\Actions\BatchAction;
use Illuminate\Database\Eloquent\Model;

class AdminVerified extends BatchAction
{
    public $name = '管理员验证';

    public function handle(Model $model)
    {
        return $this->response()->success('Success message.')->refresh();
    }

}
