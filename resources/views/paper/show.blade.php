@extends('layouts.app')
@section('title', '试卷页面')

@section('content')
    <div class="tt-wrapper-inner">
        <h4 class="tt-title-separator"><span>学习宝考试界面</span></h4>
    </div>
    <div class="tt-single-topic-list">
        <div class="tt-item">
            <div class="tt-single-topic">
                <div class="tt-item-header">
                    <div class="tt-item-info info-top">
                        <div class="tt-avatar-icon">
                            <div class="exam-room-avatar">测试</div>
                        </div>
                        <div class="tt-avatar-title">
                            考场名称: 测试考场名称
                        </div>
                        <a href="#" class="tt-info-time">
                            <i class="tt-icon">
                                <svg>
                                    <use xlink:href="#icon-time"></use>
                                </svg>
                            </i>考试剩余时间: 20分钟
                        </a>
                    </div>
                    <h3 class="tt-item-title">
                        <a href="#">试卷名称: {{ $paper->title }}</a>
                    </h3>
                    <div class="tt-item-tag">
                        <ul class="tt-list-badge">
                            <li><a href="#"><span class="tt-color03 tt-badge">正在考试</span></a></li>
                            <li><a href="#"><span class="tt-badge">题目数:10条</span></a></li>
                            <li><a href="#"><span class="tt-badge">总分:100分</span></a></li>
                        </ul>
                    </div>
                </div>
                <div class="tt-item-description">
                    <section class="panel panel-default question">
                        <div class="panel-heading"><h4><b>一、选择题（每题10分，共20分）</b></h4></div>
                        <div class="panel-body">
                            <ol>
                                @foreach($paper->questions as $key => $question)
                                    @if($question->question_status === \App\Models\Question::SINGLE_CHOICE_QUESTION)
                                        <li>
                                            <!-- 显示题目内容start -->
                                            <h6 class="tt-title">{{ $question->title }}</h6>
                                            <!-- 显示题目内容end -->
                                            <!-- 显示选项start -->
                                            @foreach($question->items as $itemKey => $item)
                                                <div>
                                                    {{ num2abc($itemKey) . '.' . $item->content }}
                                                </div>
                                            @endforeach
                                            <!-- 显示选项end -->
                                            <!-- 显示选择框start -->
                                            @foreach($question->items as $itemKey => $item)
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio1" value="option1">
                                                    <label class="form-check-label" for="inlineRadio1">{{ num2abc($itemKey) }}</label>
                                                </div>
                                            @endforeach
                                            <!-- 显示选择框end -->
                                        </li>
                                    @endif
                                @endforeach
                            </ol>
                        </div>
                    </section>

                    <section class="panel panel-default question">
                        <div class="panel-heading"><h4><b>二、多选题（每题10分，共20分）</b></h4></div>
                        <div class="panel-body">
                            <ol>
                                @foreach($paper->questions as $key => $question)
                                    @if($question->question_status === \App\Models\Question::MULTIPLE_CHOICE_QUESTIONS)
                                        <li>
                                            <h6 class="tt-title">{{ $question->title }}</h6>
                                            @foreach($question->items as $itemKey =>  $item)
                                                <div>
                                                    {{ num2abc($itemKey) . '.' . $item->content }}
                                                </div>
                                            @endforeach

                                            @foreach($question->items as $itemKey => $item)
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="checkbox" id="inlineCheckbox1" value="option1">
                                                    <label class="form-check-label" for="inlineCheckbox1">{{ num2abc($itemKey) }}</label>
                                                </div>
                                            @endforeach
                                        </li>
                                    @endif
                                @endforeach
                            </ol>
                        </div>
                    </section>

                    <section class="panel panel-default question">
                        <div class="panel-heading"><h4><b>三、填空题（每题10分，共20分）</b></h4></div>
                        <div class="panel-body">
                            <ol>
                                @foreach($paper->questions as $key => $question)
                                    @if($question->question_status === \App\Models\Question::MULTIPLE_TEXT)
                                        <li>
                                            <pre class="tt-title">{{ str_replace('%s', ' ______', $question->title) }}</pre>
                                            <div class="form-group answer">
                                                @for($i = 0 ; $i < substr_count($question->title, '%s'); $i ++)
                                                    <input type="text" name="name" class="form-control" placeholder="选项{{ $i + 1 }}">
                                                @endfor
                                            </div>
                                        </li>
                                    @endif
                                @endforeach
                            </ol>
                        </div>
                    </section>

                    <section class="panel panel-default question">
                        <div class="panel-heading"><h4><b>四、问答题（每题10分，共20分）</b></h4></div>
                        <div class="panel-body">
                            <ol>
                                @foreach($paper->questions as $key => $question)
                                    @if($question->question_status === \App\Models\Question::SINGLE_TEXT)
                                        <li>
                                            <pre class="tt-title">{{ $question->title }}</pre>
                                            <div class="form-group answer">
                                                <textarea name="" placeholder="" class="form-control"></textarea>
                                            </div>
                                        </li>
                                    @endif
                                @endforeach
                            </ol>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </div>
@endsection
