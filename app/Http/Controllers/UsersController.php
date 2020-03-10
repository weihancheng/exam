<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class UsersController extends Controller
{
    // 更新用户配置
    public function updateOwn(User $user, Request $request)
    {
        $this->authorize('own', $user);
        $this->validate($request, [
            'username' => [
                'required',
                'unique:users,username,' . $user->id,
                'max:40'
            ],
            'mobile' => [
                'required',
                'unique:users,mobile,' . $user->id,
                'max:40',
                'regex:/^13\d{9}$|^14\d{9}$|^15\d{9}$|^17\d{9}$|^18\d{9}$/'
            ],
            'id_card' => [
                'required',
                'unique:users,id_card,' . $user->id,
                'max:50',
                'regex:/(^[1-9]\d{5}(18|19|([23]\d))\d{2}((0[1-9])|(10|11|12))(([0-2][1-9])|10|20|30|31)\d{3}[0-9Xx]$)|(^[1-9]\d{5}\d{2}((0[1-9])|(10|11|12))(([0-2][1-9])|10|20|30|31)\d{3}$)/'
            ],
            'feedback' => 'max:255',
        ]);

        $data = $request->only('username', 'mobile', 'id_card', 'feedback');
        $user = $request->user();
        $user->username = $data['username'];
        $user->mobile = $data['mobile'];
        $user->id_card = $data['id_card'];
        $user->save();
        // 同时退出登录
        Auth::logout();
        return response()->redirectTo('login');
    }
}
