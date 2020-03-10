@extends('layouts.app')
@section('title', '错题集界面页面')

@section('content')
{{--  计算单选题, 多选题, 填空题, 问答题所占分值start  --}}
@php ($singleChoiceQuestionMark = 0)
@foreach($paper->questions as $key => $question)
    @if($question->question_status === \App\Models\Question::SINGLE_CHOICE_QUESTION)
        @php($singleChoiceQuestionMark += \App\Models\Option::get('single_choice_question_mark'))
    @endif
@endforeach

@php ($multipleChoiceQuestionScore = 0)
@foreach($paper->questions as $key => $question)
    @if($question->question_status === \App\Models\Question::MULTIPLE_CHOICE_QUESTIONS)
        @php($multipleChoiceQuestionScore += \App\Models\Option::get('multiple_choice_question_mark'))
    @endif
@endforeach

@php ($multipleTextScore = 0)
@foreach($paper->questions as $key => $question)
    @if($question->question_status === \App\Models\Question::MULTIPLE_TEXT)
        @php($multipleTextScore += \App\Models\Option::get('multiple_text_mark'))
    @endif
@endforeach

@php ($sigleTextScore = 0)
@foreach($paper->questions as $key => $question)
    @if($question->question_status === \App\Models\Question::SINGLE_TEXT)
        @php($sigleTextScore += \App\Models\Option::get('single_text_mark'))
    @endif
@endforeach
{{--  计算单选题, 多选题, 填空题, 问答题所占分值end --}}

    <div class="tt-wrapper-inner">
        <h4 class="tt-title-separator"><span>学习宝错题集界面</span></h4>
    </div>
    <div class="tt-single-topic-list">
        <div class="tt-item">
            <div class="tt-single-topic">
                <div class="tt-item-header">
                    <div class="tt-item-info info-top">
                        <div class="tt-avatar-icon">
                            <div class="exam-room-avatar">{{ mb_substr($exam_room->name, 0, 2) }}</div>
                        </div>
                        <div class="tt-avatar-title">
                            考场名称: {{ $exam_room->name }}
                        </div>
                        <a href="#" class="tt-info-time">
                            <div id="end-time"></div>
                        </a>
                    </div>
                    <h3 class="tt-item-title">
                        <a href="#">试卷名称: {{ $paper->title }}</a>
                    </h3>
                    <div class="tt-item-tag">
                        <ul class="tt-list-badge">
                            <li><a href="#"><span class="tt-color03 tt-badge">正在考试</span></a></li>
                            <li><a href="#"><span class="tt-badge">题目数: {{ $paper->total }}条</span></a></li>
                            <li><a href="#"><span class="tt-badge">总分: {{ $singleChoiceQuestionMark + $multipleChoiceQuestionScore + $multipleTextScore + $sigleTextScore}}分</span></a></li>
                            <li><a href="#"><span class="tt-badge">考试时间: {{ \Illuminate\Support\Carbon::parse($exam_room->start_at)->format('H:i:s') }}~{{ \Illuminate\Support\Carbon::parse($exam_room->end_at)->format('H:i:s') }}</span></a>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="tt-item-description">
                    <section class="panel panel-default question">
                        <div class="panel-heading"><h4><b>一、选择题（每题{{ \App\Models\Option::get('single_choice_question_mark') }}分，共{{ $singleChoiceQuestionMark }}分）</b></h4></div>
                        <div class="panel-body">
                            <ol>
                                @foreach($paper->questions as $key => $question)
                                    @if($question->question_status === \App\Models\Question::SINGLE_CHOICE_QUESTION)
                                        <li id="question_{{ $question->id }}" data-id="{{ $question->id }}">
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
                                            <!-- 显示用户答案start -->
                                            <div
                                                class="error-collection @if($question->answers[0]->is_true) error-collection-color-true @else error-collection-color-false @endif">
                                                <div class="error-collection-title">你的答案:</div>
                                                <div class="error-collection-content">
                                                    @foreach($question->items as $itemKey => $item)
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input single-question-answer"
                                                                   style="width: 20px; height: 20px" type="radio"
                                                                   @if ($item->id == $question->answers[0]->question_answer) checked="checked"
                                                                   @endif
                                                                   name="{{ $question->id }}" value="{{ $item->id }}">
                                                            <label class="form-check-label"
                                                                   for="inlineRadio1">{{ num2abc($itemKey) }}</label>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                            <!-- 显示用户答案end -->
                                            <!-- 显示正确答案start -->
                                            <div class="error-collection">
                                                <div class="error-collection-title">正确答案:</div>
                                                <div class="error-collection-content">
                                                    @foreach($question->items as $itemKey => $item)
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input single-question-answer"
                                                                   style="width: 20px; height: 20px" type="radio"
                                                                   @if ($item->is_answer) checked="checked" @endif
                                                                   name="ture-{{ $question->id }}"
                                                                   value="{{ $item->id }}">
                                                            <label class="form-check-label"
                                                                   for="inlineRadio1">{{ num2abc($itemKey) }}</label>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                            <!-- 显示正确答案end -->
                                            @if($question->memo)
                                                <div class="error-collection error-collection-color-memo">
                                                    <div class="error-collection-title error-collection-memo">问题解释:</div>
                                                    <div>
                                                    <textarea class="single-text-answer form-control" style="width: 500px; height: 120px"
                                                              placeholder="">{{ $question->memo }}</textarea>
                                                    </div>
                                                </div>
                                            @endif
                                        </li>
                                    @endif
                                @endforeach


                            </ol>
                        </div>
                    </section>

                    <section class="panel panel-default question">
                        <div class="panel-heading"><h4><b>二、多选题（每题{{ \App\Models\Option::get('multiple_choice_question_mark') }}分，共{{ $multipleChoiceQuestionScore }}分）</b></h4></div>
                        <div class="panel-body">
                            <ol>
                                @foreach($paper->questions as $key => $question)
                                    @if($question->question_status === \App\Models\Question::MULTIPLE_CHOICE_QUESTIONS)
                                        <li id="question_{{ $question->id }}" data-id="{{ $question->id }}"
                                            class="question_{{ $question->id }}">
                                            <h6 class="tt-title">{{ $question->title }}</h6>
                                            @foreach($question->items as $itemKey =>  $item)
                                                <div>
                                                    {{ num2abc($itemKey) . '.' . $item->content }}
                                                </div>
                                            @endforeach

                                            <div
                                                class="error-collection @if($question->answers[0]->is_true) error-collection-color-true @else error-collection-color-false @endif">
                                                <div class="error-collection-title">你的答案:</div>
                                                <div class="error-collection-content">
                                                    @foreach($question->items as $itemKey => $item)
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input multiple-question-answer"
                                                                   style="width: 20px; height: 20px"
                                                                   name="{{ $question->id }}"
                                                                   @if (in_array($item->id, explode(',', $question->answers[0]->question_answer))) checked="checked"
                                                                   @endif
                                                                   type="checkbox" value="{{ $item->id }}">
                                                            <label class="form-check-label"
                                                                   for="inlineCheckbox1">{{ num2abc($itemKey) }}</label>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                            <div class="error-collection">
                                                <div class="error-collection-title">正确答案:</div>
                                                <div class="error-collection-content">
                                                    @foreach($question->items as $itemKey => $item)
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input multiple-question-answer"
                                                                   style="width: 20px; height: 20px"
                                                                   name="true-{{ $question->id }}"
                                                                   @if ($item->is_answer) checked="checked" @endif
                                                                   type="checkbox" value="{{ $item->id }}">
                                                            <label class="form-check-label"
                                                                   for="inlineCheckbox1">{{ num2abc($itemKey) }}</label>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                            @if($question->memo)
                                                <div class="error-collection error-collection-color-memo">
                                                    <div class="error-collection-title error-collection-memo">问题解释:</div>
                                                    <div>
                                                    <textarea class="single-text-answer form-control" style="width: 500px; height: 120px"
                                                              placeholder="">{{ $question->memo }}</textarea>
                                                    </div>
                                                </div>
                                            @endif
                                        </li>
                                    @endif
                                @endforeach
                            </ol>
                        </div>
                    </section>

                    <section class="panel panel-default question">
                        <div class="panel-heading"><h4><b>三、填空题（每题{{\App\Models\Option::get('multiple_text_mark')}}分，共{{$multipleTextScore}}分）</b></h4></div>
                        <div class="panel-body">
                            <ol>
                                @foreach($paper->questions as $key => $question)
                                    @if($question->question_status === \App\Models\Question::MULTIPLE_TEXT)
                                        <li id="question_{{ $question->id }}" data-id="{{ $question->id }}">
                                            <pre
                                                class="tt-title">{{ str_replace('%s', ' ______', $question->title) }}</pre>
                                            <div class="form-group answer">
                                                <!-- 判断answers是否为多维数组 -->
                                                @for($i = 0 ; $i < substr_count($question->title, '%s'); $i ++)
                                                    @if(count(json_decode($question->answers[0]->text_answer, true)) == count(json_decode($question->answers[0]->text_answer, true), 1))
                                                        <input type="text" name="{{ $question->id }}"
                                                               value="{{ json_decode($question->answers[0]->text_answer, true)['value'] }}"
                                                               class="form-control multiple-text-answer"
                                                               title="{{ $i + 1 }}" data-key="{{ $i + 1 }}"
                                                               placeholder="选项{{ $i + 1 }}">
                                                    @else
                                                    <!-- answers为多维数组 start -->
                                                        @foreach(json_decode($question->answers[0]->text_answer, true) as $item)
                                                            @if(($i + 1) === $item['key'])
                                                                <input type="text" name="{{ $question->id }}"
                                                                       class="form-control multiple-text-answer"
                                                                       title="{{ $i + 1 }}" data-key="{{ $i + 1 }}"
                                                                       value="{{ $item['value'] }}"
                                                                       placeholder="选项{{ $i + 1 }}">
                                                            @endif
                                                        @endforeach
                                                    <!-- answers为多维数组 end -->
                                                    @endif
                                                @endfor
                                            </div>
                                            @if($question->memo)
                                                <div class="error-collection error-collection-color-memo">
                                                    <div class="error-collection-title error-collection-memo">问题解释:</div>
                                                    <div>
                                                    <textarea class="single-text-answer form-control" style="width: 500px; height: 120px"
                                                              placeholder="">{{ $question->memo }}</textarea>
                                                    </div>
                                                </div>
                                            @endif
                                        </li>
                                    @endif
                                @endforeach
                            </ol>
                        </div>
                    </section>

                    <section class="panel panel-default question">
                        <div class="panel-heading"><h4><b>四、问答题（每题{{ \App\Models\Option::get('single_text_mark') }}分，共{{$sigleTextScore}}分）</b></h4></div>
                        <div class="panel-body">
                            <ol>
                                @foreach($paper->questions as $key => $question)
                                    @if($question->question_status === \App\Models\Question::SINGLE_TEXT)
                                        <li id="question_{{ $question->id }}" data-id="{{ $question->id }}">
                                            <pre class="tt-title">{{ $question->title }}</pre>
                                            <div class="form-group answer">
                                                <textarea class="single-text-answer form-control"
                                                          name="{{ $question->id }}"
                                                          placeholder="">{{ $question->answers[0]->text_answer }}</textarea>
                                            </div>
                                        </li>
                                        @if($question->memo)
                                            <div class="error-collection error-collection-color-memo">
                                                <div class="error-collection-title error-collection-memo">问题解释:</div>
                                                <div>
                                                    <textarea class="single-text-answer form-control" style="width: 500px; height: 120px"
                                                              placeholder="">{{ $question->memo }}</textarea>
                                                </div>
                                            </div>
                                        @endif
                                    @endif
                                @endforeach
                            </ol>
                        </div>
                    </section>

                    <!-- 悬浮按钮组start -->
                    <ul class="fixbar">
                        <li><i class="icon iconfont icon-icon-test58 toTop" style="font-size: 35px"></i></li>
                    </ul>
                    <!-- 悬浮按钮组end -->
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scriptsAfterJs')
    <script>
        $(function () {
            // 跳转到顶部
            $('.toTop').click(function () {
                $("html,body").animate({scrollTop: "0px"}, 500);//500毫秒完成回到顶部动画
            })
        })
    </script>
@endsection
