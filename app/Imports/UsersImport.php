<?php

namespace App\Imports;

use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class UsersImport implements ToModel, WithHeadingRow
{

    public function model(array $row)
    {
        $user = new User([
            'username' => $row['姓名'],
            'mobile' => $row['电话'],
            'id_card' => $row['身份证'],
            'password' => bcrypt($row['密码'])
        ]);

        $user->admin_verified_at = Carbon::now();
        $user->remember_token = Str::random(10);
        return $user;
    }
}
