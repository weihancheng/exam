<?php

namespace App\Admin\Controllers;

use App\Admin\Actions\User\Import;
use App\Models\User;
use Carbon\Carbon;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class UsersController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '用户';

    /**
     * 方法来决定列表页要展示哪些列
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new User());

        $grid->id('ID')->sortable();
        $grid->username('用户名')->editable();
        $grid->mobile('电话')->editable();
        $grid->id_card('身份证')->editable();
        // 管理员是否验证
        $grid->admin_verified_at('已验证用户')->display(function ($value) {
            return $value ? '是' : '否';
        });
        $grid->created_at('注册时间')->sortable();

        // 筛选
        $grid->filter(function($filter){
            $filter->scope('admin_verified_at', '未验证用户')->whereNull('admin_verified_at');
        });

        $grid->tools(function ($tools) {
            $tools->append(new Import());
        });

        return $grid;
    }

    /**
     * 方法用来展示用户详情页
     *
     * @param mixed $id
     * @return Show
     */
    protected function detail($id)
    {
        $show = new Show(User::findOrFail($id));

        $show->field('id', __('用户ID'));
        $show->field('username', __('用户真实姓名'));
        $show->field('mobile', __('用户电话'));
        $show->field('id_card', __('用户身份证'));
        $show->field('remember_token', __('Remember token'));
        $show->field('created_at', __('注册时间'));
        $show->field('updated_at', __('最近一次登录时间'));

        return $show;
    }

    /**
     * form() 方法用于编辑和创建用户
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new User());

        $form->display('id', 'ID');
        $form->text('username', '真实姓名')->required('required|between:2,20');
        $form->mobile('mobile', '电话号码')->required('required|regex:/^13\d{9}$|^14\d{9}$|^15\d{9}$|^17\d{9}$|^18\d{9}$/');
        $form->password('password', '密码')->default('123456')->required('required|between:5,50');
        // 身份证负责唯一性校验
        $form->text('id_card', '身份证')->rules(function ($form) {
            if ($id = $form->model()->id) {
                // 编辑时的规则
                return 'required|unique:users,id_card,'.$id.',id';
            } else {
                // 添加时的规则
                return 'required|unique:users';
            }
        });

        $form->saving(function (Form $form) {
            $form->model()->admin_verified_at = Carbon::now(); // 所有后台添加的用户默认通过管理员校验
            $form->model()->password = bcrypt($form->model()->password); // 密码加密
        });

        return $form;
    }
}
