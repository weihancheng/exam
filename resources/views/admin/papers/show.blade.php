<style>
    .table-striped {
        border: 1px solid #e1e4e9;
    }

    .table-striped tr:nth-of-type(1) td {
        width: 33%;
    }

    .question .panel-body ol li{
        margin-top: 30px;
        border-top: 2px #e1e4e9 solid;
        padding:30px 30px 30px 10px;
        position: relative;
    }

    .question .panel-body ol li .btn-group{
        position: absolute;
        right: 0;
        top: -36px;
    }

    .question .panel-body ol li .btn-group button {
        color: #3c8dbc;
        margin-left: 2px;
    }

    .panel-body ol {
        background-color: #ffffff;
    }

    pre {
        background-color: unset;
        border: unset;
    }

    .paper-btn-group button{
        color: #3c8dbc;
        margin-right: 10px;
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
            <div class="btn-group paper-btn-group" role="group" aria-label="Basic example">
                <button type="button" class="btn btn-secondary"><a href="{{ route('admin.papers.edit', [$paper->id]) }}">修改试卷信息</a></button>
                <button type="button" class="btn btn-secondary"><a href="{{ route('admin.papers.create_question', [$paper->id]) }}">新增题目</a></button>
            </div>
            <table class="table table-striped">
                <tr>
                    <td class="form-group"><label>试卷创建人: </label> {{ $paper->author }}</td>
                    <td class="form-group"><label>题目总数: </label> {{ $paper->total }}</td>
                    <td class="form-group"><label>总分: </label> 100</td>
                </tr>
                <tr>
                    <td colspan="3" class="form-group"><label>试卷详情: </label> {{ $paper->description }}</td>
                </tr>
            </table>


            <section class="panel panel-default question">
                <div class="panel-heading">一、选择题（每题10分，共20分）</div>
                <div class="panel-body">
                    <ol>
                        @foreach($paper->questions as $key => $question)
                            @if($question->question_status === \App\Models\Question::SINGLE_CHOICE_QUESTION)
                                <li>
                                    <p>{{ $question->title }}</p>
                                    @foreach($question->items as $itemKey => $item)
                                        <div>
                                            {{ num2abc($itemKey) . '.' . $item->content }}
                                        </div>
                                    @endforeach
                                    <div class="btn-group" role="group" aria-label="Basic example">
                                        <button type="button" class="btn btn-secondary">
                                            <a href="{{ route('admin.questions.edit', [$question->id]) }}">修改</a>
                                        </button>
                                        <button type="button" class="btn btn-secondary btn-delete-question" data-id="{{ $question->id }}">
                                            删除
                                        </button>
                                    </div>
                                </li>
                            @endif
                        @endforeach
                    </ol>
                </div>
            </section>

            <section class="panel panel-default question">
                <div class="panel-heading">二、多选题（每题10分，共20分）</div>
                <div class="panel-body">
                    <ol>
                        @foreach($paper->questions as $key => $question)
                            @if($question->question_status === \App\Models\Question::MULTIPLE_CHOICE_QUESTIONS)
                                <li>
                                    <p>{{ $question->title }}</p>
                                    @foreach($question->items as $itemKey =>  $item)
                                        <div>
                                            {{ num2abc($itemKey) . '.' . $item->content }}
                                        </div>
                                    @endforeach
                                    <div class="btn-group" role="group" aria-label="Basic example">
                                        <button type="button" class="btn btn-secondary">
                                            <a href="{{ route('admin.questions.edit', [$question->id]) }}">修改</a>
                                        </button>
                                        <button type="button" class="btn btn-secondary btn-delete-question" data-id="{{ $question->id }}">
                                            删除
                                        </button>
                                    </div>
                                </li>
                            @endif
                        @endforeach
                    </ol>
                </div>
            </section>

            <section class="panel panel-default question">
                <div class="panel-heading">三、填空题（每题10分，共20分）</div>
                <div class="panel-body">
                    <ol>
                        @foreach($paper->questions as $key => $question)
                            @if($question->question_status === \App\Models\Question::MULTIPLE_TEXT)
                                <li>
                                    <pre>{{ str_replace('%s', '____', $question->title) }}</pre>
                                    <div class="btn-group" role="group" aria-label="Basic example">
                                        <button type="button" class="btn btn-secondary">
                                            <a href="{{ route('admin.questions.edit', [$question->id]) }}">修改</a>
                                        </button>
                                        <button type="button" class="btn btn-secondary btn-delete-question" data-id="{{ $question->id }}">
                                            删除
                                        </button>
                                    </div>
                                </li>
                            @endif
                        @endforeach
                    </ol>
                </div>
            </section>

            <section class="panel panel-default question">
                <div class="panel-heading">四、问答题（每题10分，共20分）</div>
                <div class="panel-body">
                    <ol>
                        @foreach($paper->questions as $key => $question)
                            @if($question->question_status === \App\Models\Question::SINGLE_TEXT)
                                <li>
                                    <pre>{{ $question->title }}</pre>
                                    <div class="btn-group" role="group" aria-label="Basic example">
                                        <button type="button" class="btn btn-secondary">
                                            <a href="{{ route('admin.questions.edit', [$question->id]) }}">修改</a>
                                        </button>
                                        <button type="button" class="btn btn-secondary btn-delete-question" data-id="{{ $question->id }}">
                                            删除
                                        </button>
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

<script>
    $(document).ready(function () {

        // 从当前试卷中删除本题
        $('.btn-delete-question').click(function () {
            let question_id = $(this).data('id');
            swal({
                title: '你确定要从本试卷中剔除本题吗？',
                type: 'warning',
                showCancelButton: true,
                confirmButtonText: "确认",
                cancelButtonText: "取消",
                showLoaderOnConfirm: true,
                preConfirm: function () {
                    return $.ajax({
                        url: '{{ route('admin.papers.delete_question', [ $paper->id ]) }}',
                        type: 'POST',
                        data: JSON.stringify({
                            question_id: question_id,
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
                    title: '删除成功!',
                    type: 'success'
                }).then(function () {
                    location.reload();
                })
            });
        });
    });
</script>

<style>

</style>
