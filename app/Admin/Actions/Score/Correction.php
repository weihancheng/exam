<?php

namespace App\Admin\Actions\Score;

use Encore\Admin\Actions\RowAction;

class Correction extends RowAction
{
    public $name = '批改';

    public function href()
    {
        return route('admin.scores.correction', ['score' => $this->getKey()]);
    }
}
