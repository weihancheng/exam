@extends('layouts.app')
@section('title', '首页')

@section('content')
    <div class="tt-tab-wrapper">
        <div class="tt-wrapper-inner">
            <ul class="nav nav-tabs pt-tabs-default" role="tablist">
                <li class="nav-item show">
                    <a class="nav-link active" data-toggle="tab" href="#tt-tab-01" role="tab"><span>我相关考场</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#tt-tab-02" role="tab"><span>最新考场</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#tt-tab-03" role="tab"><span>开考考场</span></a>
                </li>
                <li class="nav-item tt-hide-xs">
                    <a class="nav-link" data-toggle="tab" href="#tt-tab-04" role="tab"><span>待考考场</span></a>
                </li>
                <li class="nav-item tt-hide-md">
                    <a class="nav-link" data-toggle="tab" href="#tt-tab-05" role="tab"><span>我的考试成绩</span></a>
                </li>
                <li class="nav-item tt-hide-md">
                    <a class="nav-link" data-toggle="tab" href="#tt-tab-06" role="tab"><span>结束考场成绩</span></a>
                </li>
            </ul>
        </div>
        <div class="tab-content" style="min-height: 500px">
            <!-- 与我相关的考场start -->
            <div class="tab-pane tt-indent-none show active" id="tt-tab-01" role="tabpanel">
                <div class="tt-topic-list">
                    <div class="tt-list-header">
                        <div class="tt-col-topic">考场名称</div>
                        <div class="tt-col-value-large hide-mobile">考场状态</div>
                        <div class="tt-col-value-large hide-mobile">人数</div>
                        <div class="tt-col-value-large hide-mobile">开考时间</div>
                    </div>
                    @foreach($examRoomWithMe as $examRoom)
                        <div class="tt-item">
                            <div class="tt-col-avatar">
                                <a href="{{ route('exam_room.exam', ['exam_room' => $examRoom->id, 'paper' => $examRoom->paper->id]) }}">
                                    <div class="exam-room-avatar" style="background-color: {{ $examRoom->background_color }}!important;">
                                        {{ mb_substr($examRoom['name'], 0, 2) }}
                                    </div>
                                </a>
                            </div>
                            <div class="tt-col-description">
                                <a href="{{ route('exam_room.exam', ['exam_room' => $examRoom->id, 'paper' => $examRoom->paper->id]) }}">
                                    <h6 class="tt-title">
                                        <b>考试名称: {{ $examRoom['name'] }}</b>
                                        <span>[试卷名称: {{ $examRoom->paper->title }}]</span>
                                    </h6>
                                    <div class="tt-col-message">
                                        试卷详情: {{ $examRoom->paper->description }}
                                    </div>
                                </a>
                            </div>
                            <div class="tt-col-category tt-col-value-large hide-mobile">
                                <a href="{{ route('exam_room.exam', ['exam_room' => $examRoom->id, 'paper' => $examRoom->paper->id]) }}">
                                    @if($examRoom->status == \App\Models\ExamRoom::EXAM_ROOM_STATUS_SHIP)
                                        <span class="tt-color09 tt-badge">
                                            {{ \App\Models\ExamRoom::$examRoomType[$examRoom->status] }}
                                        </span>
                                    @elseif($examRoom->status == \App\Models\ExamRoom::EXAM_ROOM_STATUS_NOW)
                                        <span class="tt-color04 tt-badge">
                                            {{ \App\Models\ExamRoom::$examRoomType[$examRoom->status] }}
                                        </span>
                                    @else
                                        <span class="tt-color08 tt-badge">
                                            {{ \App\Models\ExamRoom::$examRoomType[$examRoom->status] }}
                                        </span>
                                    @endif
                                </a>
                            </div>
                            <div class="tt-col-value-large hide-mobile">
                                <a href="{{ route('exam_room.exam', ['exam_room' => $examRoom->id, 'paper' => $examRoom->paper->id]) }}"
                                   class="tt-btn-icon">
                                    {{ count($examRoom->students) }}
                                </a>
                            </div>
                            <div class="tt-col-value-large hide-mobile">
                                {{ \Illuminate\Support\Carbon::parse($examRoom->start_at)->format('m-d') }}
                                {{ \Illuminate\Support\Carbon::parse($examRoom->start_at)->format('H: i') }}
                            </div>
                        </div>
                    @endforeach
                    <div class="tt-row-btn">
                        {{ $examRoomWithMe->links() }}
                    </div>
                </div>
            </div>
            <!-- 与我相关的考场end -->
            <!-- 最新考场start -->
            <div class="tab-pane tt-indent-none" id="tt-tab-02" role="tabpanel">
                <div class="tt-topic-list">
                    <div class="tt-list-header">
                        <div class="tt-col-topic">考场名称</div>
                        <div class="tt-col-value-large hide-mobile">考场状态</div>
                        <div class="tt-col-value-large hide-mobile">人数</div>
                        <div class="tt-col-value-large hide-mobile">开考时间</div>
                    </div>
                    @foreach($newExamRooms as $newExamRoom)
                        <div class="tt-item">
                            <div class="tt-col-avatar">
                                <a href="{{ route('exam_room.exam', ['exam_room' => $newExamRoom->id, 'paper' => $newExamRoom->paper->id]) }}">
                                    <div class="exam-room-avatar"
                                         style="background-color: {{ $newExamRoom->background_color }}!important;">
                                        {{ mb_substr($newExamRoom['name'], 0, 2) }}
                                    </div>
                                </a>
                            </div>
                            <div class="tt-col-description">
                                <a href="{{ route('exam_room.exam', ['exam_room' => $newExamRoom->id, 'paper' => $newExamRoom->paper->id]) }}">
                                    <h6 class="tt-title">
                                        <b>考试名称: {{ $newExamRoom['name'] }}</b> <span>[试卷名称: {{ $newExamRoom->paper->title }}]</span>
                                    </h6>
                                    <div class="tt-col-message">
                                        试卷详情: {{ $newExamRoom->paper->description }}
                                    </div>
                                </a>
                            </div>
                            <div class="tt-col-category tt-col-value-large hide-mobile">
                                <a href="{{ route('exam_room.exam', ['exam_room' => $newExamRoom->id, 'paper' => $newExamRoom->paper->id]) }}">
                                    @if($newExamRoom->status == \App\Models\ExamRoom::EXAM_ROOM_STATUS_SHIP)
                                        <span class="tt-color09 tt-badge">
                                            {{ \App\Models\ExamRoom::$examRoomType[$newExamRoom->status] }}
                                        </span>
                                    @elseif($newExamRoom->status == \App\Models\ExamRoom::EXAM_ROOM_STATUS_NOW)
                                        <span class="tt-color04 tt-badge">
                                            {{ \App\Models\ExamRoom::$examRoomType[$newExamRoom->status] }}
                                        </span>
                                    @else
                                        <span class="tt-color08 tt-badge">
                                            {{ \App\Models\ExamRoom::$examRoomType[$newExamRoom->status] }}
                                        </span>
                                    @endif
                                </a>
                            </div>
                            <div class="tt-col-value-large hide-mobile">
                                <a href="{{ route('exam_room.exam', ['exam_room' => $newExamRoom->id, 'paper' => $newExamRoom->paper->id]) }}"
                                   class="tt-btn-icon">
                                    {{ count($newExamRoom->students) }}
                                </a>
                            </div>
                            <div class="tt-col-value-large hide-mobile">
                                {{ \Illuminate\Support\Carbon::parse($newExamRoom->start_at)->format('m-d') }}
                                {{ \Illuminate\Support\Carbon::parse($newExamRoom->start_at)->format('H: i') }}
                            </div>
                        </div>
                    @endforeach
                    <div class="tt-row-btn">
                        {{ $newExamRooms->links() }}
                    </div>
                </div>
            </div>
            <!-- 最新考场end -->
            <!-- 已经开考考场start -->
            <div class="tab-pane tt-indent-none" id="tt-tab-03" role="tabpanel">
                <div class="tt-topic-list">
                    <div class="tt-list-header">
                        <div class="tt-col-topic">考场名称</div>
                        <div class="tt-col-value-large hide-mobile">考场状态</div>
                        <div class="tt-col-value-large hide-mobile">人数</div>
                        <div class="tt-col-value-large hide-mobile">开考时间</div>
                    </div>
                    @foreach($nowExamRooms as $examRoom)
                        <div class="tt-item">
                            <div class="tt-col-avatar">
                                <a href="{{ route('exam_room.exam', ['exam_room' => $examRoom->id, 'paper' => $examRoom->paper->id]) }}">
                                    <div class="exam-room-avatar">
                                        {{ mb_substr($examRoom['name'], 0, 2) }}
                                    </div>
                                </a>
                            </div>
                            <div class="tt-col-description">
                                <a href="{{ route('exam_room.exam', ['exam_room' => $examRoom->id, 'paper' => $examRoom->paper->id]) }}">
                                    <h6 class="tt-title">
                                        <b>考试名称: {{ $examRoom['name'] }}</b>
                                        <span>[试卷名称: {{ $examRoom->paper->title }}]</span>
                                    </h6>
                                    <div class="tt-col-message">
                                        试卷详情: {{ $examRoom->paper->description }}
                                    </div>
                                </a>
                            </div>
                            <div class="tt-col-category tt-col-value-large hide-mobile">
                                <a href="{{ route('exam_room.exam', ['exam_room' => $examRoom->id, 'paper' => $examRoom->paper->id]) }}">
                                    @if($examRoom->status == \App\Models\ExamRoom::EXAM_ROOM_STATUS_SHIP)
                                        <span class="tt-color09 tt-badge">
                                            {{ \App\Models\ExamRoom::$examRoomType[$examRoom->status] }}
                                        </span>
                                    @elseif($examRoom->status == \App\Models\ExamRoom::EXAM_ROOM_STATUS_NOW)
                                        <span class="tt-color04 tt-badge">
                                            {{ \App\Models\ExamRoom::$examRoomType[$examRoom->status] }}
                                        </span>
                                    @else
                                        <span class="tt-color08 tt-badge">
                                            {{ \App\Models\ExamRoom::$examRoomType[$examRoom->status] }}
                                        </span>
                                    @endif
                                </a>
                            </div>
                            <div class="tt-col-value-large hide-mobile">
                                <a href="{{ route('exam_room.exam', ['exam_room' => $examRoom->id, 'paper' => $examRoom->paper->id]) }}"
                                   class="tt-btn-icon">
                                    {{ count($examRoom->students) }}
                                </a>
                            </div>
                            <div class="tt-col-value-large hide-mobile">
                                {{ \Illuminate\Support\Carbon::parse($examRoom->start_at)->format('m-d') }}
                                {{ \Illuminate\Support\Carbon::parse($examRoom->start_at)->format('H: i') }}
                            </div>
                        </div>
                    @endforeach
                    <div class="tt-row-btn">
                        {{ $nowExamRooms->links() }}
                    </div>
                </div>
            </div>
            <!-- 已经开考考场end -->
            <!-- 待考考场start -->
            <div class="tab-pane tt-indent-none" id="tt-tab-04" role="tabpanel">
                <div class="tt-topic-list">
                    <div class="tt-list-header">
                        <div class="tt-col-topic">考场名称</div>
                        <div class="tt-col-value-large hide-mobile">考场状态</div>
                        <div class="tt-col-value-large hide-mobile">人数</div>
                        <div class="tt-col-value-large hide-mobile">开考时间</div>
                    </div>
                    @foreach($shipExamRooms as $examRoom)
                        <div class="tt-item">
                            <div class="tt-col-avatar">
                                <a href="{{ route('exam_room.exam', ['exam_room' => $examRoom->id, 'paper' => $examRoom->paper->id]) }}">
                                    <div class="exam-room-avatar">
                                        {{ mb_substr($examRoom['name'], 0, 2) }}
                                    </div>
                                </a>
                            </div>
                            <div class="tt-col-description">
                                <a href="{{ route('exam_room.exam', ['exam_room' => $examRoom->id, 'paper' => $examRoom->paper->id]) }}">
                                    <h6 class="tt-title">
                                        <b>考试名称: {{ $examRoom['name'] }}</b>
                                        <span>[试卷名称: {{ $examRoom->paper->title }}]</span>
                                    </h6>
                                    <div class="tt-col-message">
                                        试卷详情: {{ $examRoom->paper->description }}
                                    </div>
                                </a>
                            </div>
                            <div class="tt-col-category tt-col-value-large hide-mobile">
                                <a href="{{ route('exam_room.exam', ['exam_room' => $examRoom->id, 'paper' => $examRoom->paper->id]) }}">
                                    @if($examRoom->status == \App\Models\ExamRoom::EXAM_ROOM_STATUS_SHIP)
                                        <span class="tt-color09 tt-badge">
                                            {{ \App\Models\ExamRoom::$examRoomType[$examRoom->status] }}
                                        </span>
                                    @elseif($examRoom->status == \App\Models\ExamRoom::EXAM_ROOM_STATUS_NOW)
                                        <span class="tt-color04 tt-badge">
                                            {{ \App\Models\ExamRoom::$examRoomType[$examRoom->status] }}
                                        </span>
                                    @else
                                        <span class="tt-color08 tt-badge">
                                            {{ \App\Models\ExamRoom::$examRoomType[$examRoom->status] }}
                                        </span>
                                    @endif
                                </a>
                            </div>
                            <div class="tt-col-value-large hide-mobile">
                                <a href="{{ route('exam_room.exam', ['exam_room' => $examRoom->id, 'paper' => $examRoom->paper->id]) }}"
                                   class="tt-btn-icon">
                                    {{ count($examRoom->students) }}
                                </a>
                            </div>
                            <div class="tt-col-value-large hide-mobile">
                                {{ \Illuminate\Support\Carbon::parse($examRoom->start_at)->format('m-d') }}
                                {{ \Illuminate\Support\Carbon::parse($examRoom->start_at)->format('H: i') }}
                            </div>
                        </div>
                    @endforeach
                    <div class="tt-row-btn">
                        {{ $shipExamRooms->links() }}
                    </div>
                </div>
            </div>
            <!-- 待考考场end -->

            <div class="tab-pane tt-indent-none" id="tt-tab-05" role="tabpanel">
                <div class="tt-followers-list">
                    <div class="tt-list-header">
                        <div class="tt-col-name">考场名称&试卷名称</div>
                        <div class="tt-col-value-large hide-mobile">考试开始时间</div>
                        <div class="tt-col-value-large hide-mobile">考试总时间长</div>
                        <div class="tt-col-value-large hide-mobile">选择题分数</div>
                        <div class="tt-col-value-large hide-mobile">简答题分数</div>
                        <div class="tt-col-value-large hide-mobile">总分</div>
                        <div class="tt-col-value">状态</div>
                    </div>
                    @foreach($myScore as $score)
                    <div class="tt-item">
                        <div class="tt-col-merged">
                            <div class="tt-col-description">
                                <h6 class="tt-title"><a href="{{ route('score.show.error_collection', ['score' => $score->id]) }}">{{ $score->examRoom()->get()[0]->name }}</a></h6>
                                <ul>
                                    <li><a href="{{ route('score.show.error_collection', ['score' => $score->id]) }}">{{ \App\Models\Paper::find($score->examRoom()->get()[0]->paper_id)->title }}</a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="tt-col-value-large hide-mobile"><a href="{{ route('score.show.error_collection', ['score' => $score->id]) }}">{{ $score->examRoom()->get()[0]->start_at }}</a></div>
                        <div class="tt-col-value-large hide-mobile tt-color-select"><a href="{{ route('score.show.error_collection', ['score' => $score->id]) }}">{{ $score->examRoom()->get()[0]->examMinute }}</a></div>
                        <div class="tt-col-value-large hide-mobile"><a href="{{ route('score.show.error_collection', ['score' => $score->id]) }}">{{ $score->questions_mark }}</a></div>
                        <div class="tt-col-value-large hide-mobile"><a href="{{ route('score.show.error_collection', ['score' => $score->id]) }}">{{ $score->text_mark }}</a></div>
                        <div class="tt-col-value-large hide-mobile"><a href="{{ route('score.show.error_collection', ['score' => $score->id]) }}">{{ $score->mark }}</a></div>
                        <div class="tt-col-value"><a href="{{ route('score.show.error_collection', ['score' => $score->id]) }}"><span class="tt-color19 tt-badge">{{ \App\Models\Score::$scoreType[$score->type] }}</span></a></div>
                    </div>
                    @endforeach
                </div>
            </div>

            <div class="tab-pane" id="tt-tab-06" role="tabpanel">
                <div class="tt-wrapper-inner">
                    <div class="tt-categories-list">
                        <div class="row">
                            @foreach($endExamRooms as $examRoom)
                            <div class="col-md-6 col-lg-4">
                                <div class="tt-item">
                                    <div class="tt-item-header">
                                        <ul class="tt-list-badge">
                                            <li><a href="#"><span class="tt-color01 tt-badge">{{ $examRoom->name }}</span></a>
                                            </li>
                                        </ul>
                                        <h6 class="tt-title"><a href="#">{{ \Illuminate\Support\Carbon::parse($examRoom->start_at)->format('m-d H:i') }}</a></h6>
                                    </div>
                                    <div class="tt-item-layout">
                                        <div class="innerwrapper">
                                            试卷名称: {{ $examRoom->paper()->first()->title }}<br>详情: {{ $examRoom->paper()->first()->description }}
                                        </div>
                                        <div class="innerwrapper">
                                            <h6 class="tt-title">试卷标签</h6>
                                            <ul class="tt-list-badge">
                                                <li><a href="#"><span class="tt-badge">总分:
                                                            @php ($summaryScore = 0)
                                                            @foreach($examRoom->paper()->first()->questions as $question)
                                                                @if($question->question_status === \App\Models\Question::SINGLE_TEXT)
                                                                    @php($summaryScore = \App\Models\Option::get('single_text_mark') + $summaryScore)
                                                                @elseif($question->question_status === \App\Models\Question::MULTIPLE_TEXT)
                                                                    @php($summaryScore = \App\Models\Option::get('multiple_text_mark') + $summaryScore)
                                                                @elseif($question->question_status === \App\Models\Question::MULTIPLE_CHOICE_QUESTIONS)
                                                                    @php($summaryScore = \App\Models\Option::get('multiple_choice_question_mark') + $summaryScore)
                                                                @else
                                                                    @php($summaryScore = \App\Models\Option::get('single_choice_question_mark') + $summaryScore)
                                                                @endif
                                                            @endforeach
                                                            {{ $summaryScore }}</span></a>
                                                </li>
                                                <li><a href="#"><span class="tt-badge">考试总时长: {{ $examRoom->exam_minute }}</span></a></li>
                                                <li><a href="#"><span class="tt-badge">题目总数: {{ $examRoom->paper()->first()->total }}</span></a></li>
                                                <li><a href="#"><span class="tt-badge">试卷批改人: {{ $examRoom->user()->first()->username }}</span></a>
                                                </li>
                                                <li><a href="#"><span class="tt-badge">试卷类型: {{ \App\Models\Paper::$paperType[$examRoom->paper()->first()->type] }}</span></a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    <a href="#" class="btn btn-color02 btn-block btn-xs" style="width: 110px; margin-top: 10px"><span class="icon iconfont icon-icon-test18"></span> 下载成绩</a>
                                </div>
                            </div>
                            @endforeach
                            <div class="tt-row-btn">
                                {{ $endExamRooms->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
