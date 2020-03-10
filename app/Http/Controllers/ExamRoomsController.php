<?php

namespace App\Http\Controllers;

use App\Exceptions\InvalidRequestException;
use App\Models\ExamRoom;
use App\Models\Paper;
use App\Models\Score;
use Illuminate\Http\Request;

class ExamRoomsController extends Controller
{

    // 考试界面首页[默认为网站首页]
    public function index()
    {
        // 当用户进入考场首页的时候, 自动触发考场状态刷新
        ExamRoom::updateStatus();
        // 界面数据加载
        $newExamRooms = $this->getNewExamRoom();
        $examRoomWithMe = $this->getExamRoomWithMe();
        $shipExamRooms = $this->getShipExamRoom();
        $nowExamRooms = $this->getNowExamRoom();
        $myScore = $this->getMyScore();
        $endExamRooms = $this->getEndExamRoom();
        return view('exam_room.index', compact('newExamRooms', 'shipExamRooms', 'examRoomWithMe', 'nowExamRooms', 'myScore', 'endExamRooms'));
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

    // 获取我的考试成绩
    public function getMyScore()
    {
        $myScore = auth()->user()->scores()->orderBy('id', 'desc')->get();
        return $myScore;
    }

    // 考试
    public function exam(ExamRoom $exam_room, Paper $paper, Request $request)
    {
        // 检查用户是否有考试权限
        $this->authorize('view', $exam_room);
        if ($exam_room->status === ExamRoom::EXAM_ROOM_STATUS_END)
            throw new InvalidRequestException('考试已结束');

        // 校验用户是否已经提交试卷了, 如果已经提交试卷, 则直接返回首页
        if (Score::query()->where('user_id', $request->user()->id)->where('exam_room_id', $exam_room->id)->exists())
            throw new InvalidRequestException('你已提交试卷');


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

    // 获取已经结束的考场详细信息
    public function getEndExamRoom()
    {
        $examRoom = ExamRoom::query()
            ->where('status', ExamRoom::EXAM_ROOM_STATUS_END)
            ->orderBy('end_at', 'desc')
            ->paginate(9);
        return $examRoom;
    }
}
