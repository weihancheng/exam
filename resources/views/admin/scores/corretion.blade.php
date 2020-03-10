<style>
    .box p, pre {
        font-size: 18px;
    }

    .table-striped {
        border: 1px solid #e1e4e9;
    }

    .table-striped tr:nth-of-type(1) td {
        width: 33%;
    }

    .question .panel-body ol li {
        margin-top: 30px;
        border-top: 2px #e1e4e9 solid;
        padding: 30px 30px 30px 10px;
        position: relative;
    }

    .panel-body ol {
        background-color: #ffffff;
    }

    pre {
        background-color: unset;
        border: unset;
    }

    li .correction {
        position: absolute;
        display: flex;
        right: 20px;
        width: 400px;
        bottom: 20px;
        align-items: center;
        background-color: #feffde;
        justify-content: space-between;
        height: 80px;
        line-height: 80px;
        border-radius: 10px;
        padding: 0 20px;
    }

    .correction .btn-group button {
        border-radius: 10px;
        color: #ffffff;
    }
</style>

<div class="box box-info">
    <div class="box-header with-border">
        <h3 class="box-title">详细</h3>
        <div class="box-tools">
            <div class="btn-group float-right" style="margin-right: 10px">
                <a href="{{ route('admin.papers.index') }}" class="btn btn-sm btn-default"><i class="fa fa-list"></i>列表</a>
            </div>
        </div>
    </div>
    <div class="box-body">
        <div class="row" style="padding: 20px">
            <header>
                <div class="text-center"><h3>{{ $paper->title }}</h3></div>
            </header>
            <table class="table table-striped">
                <tr>
                    <td class="form-group" style="width: 25%">
                        <label>考生名称: </label> {{ $score->user()->first()->username }}</td>
                    <td class="form-group" style="width: 25%"><label>题目总数: </label> {{ $paper->total }}</td>
                    <td class="form-group" style="width: 25%"><label>试卷总分: </label>
                        @php ($summaryScore = 0)
                        @foreach($paper->questions as $question)
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
                        {{ $summaryScore }}
                    </td>
                    <td class="form-group" style="width: 25%"><label>考生总分: </label> 100</td>
                </tr>
                <tr>
                    <td class="form-group">
                        <label>单选题分值: </label> {{ \App\Models\Option::get('single_choice_question_mark') }}</td>
                    <td class="form-group">
                        <label>多选题分值: </label> {{ \App\Models\Option::get('multiple_choice_question_mark') }}</td>
                    <td class="form-group"><label>填空题分值: </label> {{ \App\Models\Option::get('multiple_text_mark') }}
                    </td>
                    <td class="form-group"><label>问答题分值: </label> {{ \App\Models\Option::get('single_text_mark') }}</td>
                </tr>
                <tr>
                    <td colspan="4" class="form-group"><label>试卷详情: </label> {{ $paper->description }}</td>
                </tr>
            </table>
            <!-- 填空题批改 start -->
            <section class="panel panel-default question">
                <div class="panel-heading">三、填空题（每题{{\App\Models\Option::get('multiple_text_mark')}}分，共
                    @php ($multipleTextScore = 0)
                    @foreach($paper->questions as $key => $question)
                        @if($question->question_status === \App\Models\Question::MULTIPLE_TEXT)
                            @php($multipleTextScore += \App\Models\Option::get('multiple_text_mark'))
                        @endif
                    @endforeach {{$multipleTextScore}}分）
                </div>
                <div class="panel-body">
                    <ol>
                        @foreach($paper->questions as $key => $question)
                            @if($question->question_status === \App\Models\Question::MULTIPLE_TEXT)
                                <li>
                                    <pre>{{ str_replace('%s', '____', $question->title) }}</pre>
                                    <div class="input-group mb-3">
                                        @for($i = 0 ; $i < substr_count($question->title, '%s'); $i ++)
                                            <div class="input-group-prepend">
                                                <span class="input-group-text" id="basic-addon3">空缺{{ $i + 1 }}</span>
                                                <!-- 判断是否是多维数组 -->
                                            @if(count(json_decode($question->answers[0]->text_answer, true)) == count(json_decode($question->answers[0]->text_answer, true), 1))
                                                <!-- 一维数组 -->
                                                    <input type="text" style="width:400px;" name="{{ $question->id }}"
                                                           value="{{ json_decode($question->answers[0]->text_answer, true)['value'] }}"
                                                           class="form-control" aria-describedby="basic-addon3"
                                                           disabled>
                                            @else
                                                <!-- 多维数组 -->
                                                    @foreach(json_decode($question->answers[0]->text_answer, true) as $item)
                                                        @if(($i + 1) === $item['key'])
                                                            <input type="text" style="width:400px;"
                                                                   name="{{ $question->id }}"
                                                                   value="{{ $item['value'] }}"
                                                                   class="form-control" aria-describedby="basic-addon3"
                                                                   disabled>
                                                        @endif
                                                    @endforeach
                                                @endif
                                            </div>
                                        @endfor
                                    </div>
                                    <div class="correction">
                                        <input type="text" required name="correction[]" style="width: 100px;"
                                               title="{{ $question->id }}" placeholder="请输入分数" class="form-control">
                                        <div class="btn-group" role="group" aria-label="Basic example">
                                            <button type="button"
                                                    title="{{ \App\Models\Option::get('multiple_choice_question_mark')  }}"
                                                    class="full btn btn-secondary" style="background-color: #00bcd4;">
                                                本题满分
                                            </button>
                                            <button type="button" title="0" class="zero btn btn-secondary"
                                                    style="background-color: #00a65a;">本题零分
                                            </button>
                                        </div>
                                    </div>
                                </li>
                            @endif
                        @endforeach
                    </ol>
                </div>
            </section>
            <!-- 填空题批改 end -->
            <!-- 问答题批改 start -->
            <section class="panel panel-default question">
                <div class="panel-heading">四、问答题（每题{{ \App\Models\Option::get('single_text_mark') }}分，共
                    @php ($sigleTextScore = 0)
                    @foreach($paper->questions as $key => $question)
                        @if($question->question_status === \App\Models\Question::SINGLE_TEXT)
                            @php($sigleTextScore += \App\Models\Option::get('single_text_mark'))
                        @endif
                    @endforeach {{$sigleTextScore}}分）
                </div>
                <div class="panel-body">
                    <ol>
                        @foreach($paper->questions as $key => $question)
                            @if($question->question_status === \App\Models\Question::SINGLE_TEXT)
                                <li>
                                    <pre>{{ $question->title }}</pre>
                                    <textarea style="width:600px; height: 200px;" name="{{ $question->id }}" cols="30"
                                              rows="10" disabled>{{ $question->answers[0]->text_answer }}</textarea>
                                    <div class="correction">
                                        <input type="text" required name="correction[]" style="width: 100px;"
                                               title="{{ $question->id }}" placeholder="请输入分数" class="form-control">
                                        <div class="btn-group" role="group" aria-label="Basic example">
                                            <button type="button"
                                                    title="{{ \App\Models\Option::get('single_text_mark') }}"
                                                    class="btn btn-secondary full" style="background-color: #00bcd4;">
                                                本题满分
                                            </button>
                                            <button type="button" title="0" class="btn btn-secondary zero"
                                                    style="background-color: #00a65a;">本题零分
                                            </button>
                                        </div>
                                    </div>
                                </li>
                            @endif
                        @endforeach
                    </ol>
                </div>
            </section>
            <!-- 问答题批改 end -->
            <div class="box-footer">
                <div class="col-md-12">
                    <div class="btn-group pull-right">
                        <button type="submit" class="btn btn-primary btn-correction-update">提交</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {

        // 本题满分
        $(document).on('click', '.full', function () {
            $(this).parent().prev().children().val($(this).attr('title'))
        })

        // 本题零分
        $(document).on('click', '.zero', function () {
            $(this).parent().prev().children().val($(this).attr('title'))
        })

        $('.btn-correction-update').click(function () {
            swal({
                title: '是否批改完毕？',
                type: 'warning',
                showCancelButton: true,
                confirmButtonText: "确认",
                cancelButtonText: "取消",
                showLoaderOnConfirm: true,
                preConfirm: function () {
                    let correction = [];
                    $('input[name="correction[]"]').each(function () {
                        correction.push({
                            value: parseInt($(this).val()),
                            question_id: parseInt($(this).attr('title'))
                        })
                    });
                    return $.ajax({
                        url: '{{ route('admin.scores.correction.update', [$score->id]) }}',
                        type: 'PUT',
                        data: JSON.stringify({
                            correction: correction,
                            _token: LA.token,
                        }),
                        contentType: 'application/json',
                    });
                },
                allowOutsideClick: false
            }).then(function (ret) {
                if (ret.dismiss === 'cancel') {
                    return;
                }
                swal({
                    title: '试卷批改完毕!',
                    type: 'success'
                }).then(function () {
                    // location.reload();
                })
            });
        });
    });
</script>
