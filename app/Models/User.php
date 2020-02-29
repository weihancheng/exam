<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username', 'password', 'mobile', 'id_card'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'admin_verified_at' => 'datetime',
    ];

    // 批改者模型关联考场
    public function correctionExamRoom()
    {
        return $this->hasMany(ExamRoom::class);
    }

    // 考生模型关联考场
    public function studentsExamRoom()
    {
        return $this->belongsToMany(ExamRoom::class)->withTimestamps();
    }

    // 关联成绩表
    public function scores()
    {
        return $this->hasMany(Score::class);
    }
}
