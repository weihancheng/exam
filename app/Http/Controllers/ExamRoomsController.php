<?php

namespace App\Http\Controllers;

use App\Models\ExamRoom;
use App\Models\Paper;

class ExamRoomsController extends Controller
{

    // 考试界面首页
    public function index()
    {
        // 当用户进入考场首页的时候, 自动触发考场状态刷新
        ExamRoom::updateStatus();
        // 界面数据加载
        $newExamRooms = $this->getNewExamRoom();
        $examRoomWithMe = $this->getExamRoomWithMe();
        $shipExamRooms = $this->getShipExamRoom();
        $nowExamRooms = $this->getNowExamRoom();
        return view('exam_room.index', compact('newExamRooms', 'shipExamRooms', 'examRoomWithMe', 'nowExamRooms'));
    }

    // 获取最新考场
    public function getNewExamRoom()
    {
        $examRoom = ExamRoom::query()->orderBy('start_at', 'desc')->paginate(10);
        return $examRoom;
    }

    // 获取与我相关的考场
    public function getExamRoomWithMe()
    {
        $user = request()->user();
        $examRoom = ExamRoom::query()->whereHas('examinee', function ($query) use($user) {
            $query->where('user_id', $user->id);
        })->orderBy('start_at', 'desc')->paginate(10);
        return $examRoom;
    }

    // 获取正在待考的考场
    public function getShipExamRoom()
    {
        $examRoom = ExamRoom::query()
            ->where('status', ExamRoom::EXAM_ROOM_STATUS_SHIP)
            ->orderBy('start_at', 'desc')
            ->paginate(10);
        return $examRoom;
    }

    // 获取正在开始的考场
    public function getNowExamRoom()
    {
        $examRoom = ExamRoom::query()
            ->where('status', ExamRoom::EXAM_ROOM_STATUS_NOW)
            ->orderBy('start_at', 'desc')
            ->paginate(10);
        return $examRoom;
    }

    // 考试
    public function exam(ExamRoom $exam_room, Paper $paper)
    {
        // 检查用户是否有考试权限
        $this->authorize('view', $exam_room);
        // 刷新考场状态
        ExamRoom::updateStatus();
        return view('exam_room.exam', compact('exam_room', 'paper'));
    }

    // 试卷批改界面 (以考场为单位的批改)
    public function correction(ExamRoom $exam_room)
    {
        // 检查用户是否有进入批改界面的权限
        $this->authorize('correctionView', $exam_room);

        // 加载批改界面
        return view('exam_room.correction', compact('exam_room'));
    }
}
