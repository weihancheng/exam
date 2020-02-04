<?php

namespace App\Admin\Actions\User;

use Encore\Admin\Actions\BatchAction;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Carbon;

class BatchAdminVerified extends BatchAction
{
    public $name = '批量通过';

    public function handle(Collection $collection)
    {
        foreach ($collection as $model) {
            $model->admin_verified_at = Carbon::now();
            $model->save();
        }

        return $this->response()->success('操作成功')->refresh();
    }

}
