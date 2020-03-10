<?php

namespace App\Http\Controllers;

use App\Models\Score;
use Illuminate\Http\Request;

class ScoresController extends Controller
{
    // 错题集界面
    public function showErrorCollection(Score $score)
    {
        $this->authorize('view', $score);
        $exam_room = $score->examRoom()->first();  // 考场
        $paper = $exam_room->paper()->with(['questions', 'questions.answers' => function ($query) use ($score) {
            $query->where('user_id', $score->user_id)->where('exam_room_id', $score->exam_room_id);
        }])->find($exam_room->paper_id);  // 试卷和用户答案
        return view('score.show_error_collection', compact('score', 'paper', 'exam_room'));
    }
}
