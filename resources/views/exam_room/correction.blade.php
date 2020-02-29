@extends('layouts.app')
@section('title', '批改界面')

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
                            <li><a href="#"><span class="tt-badge">总分: 100分</span></a></li>
                            <li><a href="#"><span class="tt-badge">考试时间: {{ \Illuminate\Support\Carbon::parse($exam_room->start_at)->format('H:i:s') }}~{{ \Illuminate\Support\Carbon::parse($exam_room->end_at)->format('H:i:s') }}</span></a>
                            </li>
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
                                            <!-- 显示选择框start -->
                                            @foreach($question->items as $itemKey => $item)
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input single-question-answer"
                                                           style="width: 20px; height: 20px" type="radio"
                                                           name="{{ $question->id }}" value="{{ $item->id }}">
                                                    <label class="form-check-label"
                                                           for="inlineRadio1">{{ num2abc($itemKey) }}</label>
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
                                        <li id="question_{{ $question->id }}" data-id="{{ $question->id }}"
                                            class="question_{{ $question->id }}">
                                            <h6 class="tt-title">{{ $question->title }}</h6>
                                            @foreach($question->items as $itemKey =>  $item)
                                                <div>
                                                    {{ num2abc($itemKey) . '.' . $item->content }}
                                                </div>
                                            @endforeach

                                            @foreach($question->items as $itemKey => $item)
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input multiple-question-answer"
                                                           style="width: 20px; height: 20px" name="{{ $question->id }}"
                                                           type="checkbox" value="{{ $item->id }}">
                                                    <label class="form-check-label"
                                                           for="inlineCheckbox1">{{ num2abc($itemKey) }}</label>
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
                                        <li id="question_{{ $question->id }}" data-id="{{ $question->id }}">
                                            <pre
                                                class="tt-title">{{ str_replace('%s', ' ______', $question->title) }}</pre>
                                            <div class="form-group answer">
                                                @for($i = 0 ; $i < substr_count($question->title, '%s'); $i ++)
                                                    <input type="text" name="{{ $question->id }}"
                                                           class="form-control multiple-text-answer"
                                                           title="{{ $i + 1 }}" data-key="{{ $i + 1 }}"
                                                           placeholder="选项{{ $i + 1 }}">
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
                                        <li id="question_{{ $question->id }}" data-id="{{ $question->id }}">
                                            <pre class="tt-title">{{ $question->title }}</pre>
                                            <div class="form-group answer">
                                                <textarea class="single-text-answer form-control"
                                                          name="{{ $question->id }}" placeholder=""></textarea>
                                            </div>
                                        </li>
                                    @endif
                                @endforeach
                            </ol>
                        </div>
                    </section>

                    <div class="text-md-right">
                        <button class="btn btn-secondary btn-width-lg saveAnswer">提交试卷</button>
                    </div>

                    <!-- 悬浮按钮组start -->
                    <ul class="fixbar">
                        <li><i class="icon iconfont icon-icon-test58 toTop" style="font-size: 35px"></i></li>
                        <li><i class="icon iconfont icon-icon-test9 saveAnswer" style="font-size: 30px"></i></li>
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
            countTime();  // 开启考试倒计时

            let menu = [];
            // 获取题目列表, 同时得到该题类型
            @foreach($paper->questions as $key => $question)
            menu.push({"question_id": "{{ $question->id }}", "question_status": "{{ $question->question_status }}"})
            @endforeach
            // 刷新后调用 判断用户是否有填写答案
            if (hasAnswer()) updateRenderPage(); // 刷新时重新渲染页面

            // 单选题缓存
            $('.single-question-answer').click(function () {
                let item_id = $(this).val()
                let question_id = $(this).parent().parent().data('id');
                // 保存到缓存中
                putAnswer(question_id, item_id);
            });

            // 问答题缓存
            $('.single-text-answer').change(function () {
                let text = $(this).val()
                let question_id = $(this).parent().parent().data('id');
                // 保存到缓存中
                putAnswer(question_id, text);
            });

            // 多选题缓存
            $('.multiple-question-answer').click(function () {
                let item_id = $(this).val();
                let question_id = $(this).parent().parent().data('id');
                // 获取原本在缓存中的数据
                let value = getAnswer(question_id);
                if (value) {
                    let arr = value.split(',');
                    if (arr.includes(item_id)) {
                        arr = arr.filter(item => parseInt(item) !== parseInt(item_id))
                    } else {
                        arr.push(item_id);
                    }
                    // 保存到缓存中
                    putAnswer(question_id, arr);
                } else {
                    putAnswer(question_id, item_id);
                }
            });

            // 填空题缓存
            $('.multiple-text-answer').change(function () {
                let text = $(this).val();  // 选项内容
                let text_key = $(this).data('key');  // 选项key
                let question_id = $(this).parent().parent().data('id');  // question_id
                let value = getAnswer(question_id);
                let new_value = {
                    'key': text_key,
                    'value': text
                }
                if (value) {
                    value = JSON.parse(value);
                    if (Array.isArray(value)) {
                        let index = value.findIndex(item => parseInt(item.key) === parseInt(text_key));
                        (index === -1) ? value.push(new_value) : value[index] = new_value;
                        putAnswer(question_id, JSON.stringify(value));
                    } else {
                        (parseInt(value.key) !== parseInt(new_value.key))
                            ? putAnswer(question_id, JSON.stringify([value, new_value]))
                            : putAnswer(question_id, JSON.stringify(new_value));
                    }
                } else {
                    putAnswer(question_id, JSON.stringify(new_value));
                }
            });

            // 提交试卷
            $('.saveAnswer').click(function () {
                swal({
                    title: "是否确定提交试卷?",
                    icon: "warning",
                    buttons: ['取消', '确定'],
                    dangerMode: true
                }).then(function (willSave) {
                    if (!willSave) return;
                    // 提交试卷函数
                    saveAnswer();
                })
            });

            // 缓存答案方法
            function putAnswer(key, value) {
                let scope = "exam_room_" + "{{ $exam_room->id }}" + "_";
                key = scope + "question_" + key;
                return sessionStorage.setItem(key, value);
            }

            // 获取缓存中的答案
            function getAnswer(key) {
                let scope = "exam_room_" + "{{ $exam_room->id }}" + "_";
                key = scope + "question_" + key;
                return sessionStorage.getItem(key);
            }

            // 删除缓存中的内容
            function delAnswer(key) {
                let scope = "exam_room_" + "{{ $exam_room->id }}" + "_";
                key = scope + "question_" + key;
                return sessionStorage.removeItem(key);
            }

            // 获取当前作用域的所有数据
            function allAnswer() {
                let scope = "exam_room_" + "{{ $exam_room->id }}" + "_";
                let arr = [];
                for (let i = 0; i < sessionStorage.length; i++) {
                    let key = sessionStorage.key(i);
                    let value = sessionStorage[key];
                    let count = (scope + "question_").length;
                    let id = key.substring(count);
                    if (key.includes(scope)) {
                        let item = {"id": id, "value": value};
                        arr.push(item);
                    }
                }
                return arr;
            }

            // 获取当前作用域是否有数据
            function hasAnswer() {
                let scope = "exam_room_" + "{{ $exam_room->id }}" + "_";
                for (let i = 0; i < sessionStorage.length; i++) {
                    let key = sessionStorage.key(i);
                    if (key.includes(scope)) {
                        return true;
                    }
                }
                return false;
            }

            // 重新加载页面
            function updateRenderPage() {
                // 取得所有用户答案
                let answer = allAnswer();
                // 重新渲染页面
                for (let i = 0; i < answer.length; i++) {
                    let value = answer[i];

                    // 单选题重新渲染
                    $('input[name=' + value.id + '][type=radio]').each((index, element) => {
                        if (value.value == element.value) element.checked = true
                    });

                    // 多选题重新渲染
                    $('input[type=checkbox][name=' + value.id + ']').each((index, element) => {
                        if (value.value.split(',').includes(element.value)) element.checked = true;
                    });

                    // 填空题重新渲染
                    $('input[type=text][name=' + value.id + ']').each((index, element) => {
                        let json = JSON.parse(value.value);
                        if (Array.isArray(json)) {
                            for (let i = 0; i < json.length; i++) {
                                if (json[i].key == element.title) element.value = json[i].value;
                            }
                        } else {
                            if (json.key == element.title) element.value = json.value;
                        }
                    });

                    // 问答题重新渲染
                    $('textarea[name=' + value.id + ']').val(value.value);
                }
            }

            /**
             * 提交试卷方法
             * param validateQuestion true:校验用户是否完成试卷 false:不校验用户是否完成试卷
             */
            function saveAnswer(validateQuestion = true) {
                let answers = allAnswer();
                // 整理数据
                for (let i = 0; i < answers.length; i++) {
                    let answer = answers[i];
                    for (let j = 0; j < menu.length; j++) {
                        let question = menu[j];
                        if (answer.id == question.question_id) {
                            // 数据处理
                            if (question.question_status === "multiple") { // 如果是多选题
                                answers[i]["value"] = answer.value.split(',');
                            }
                            if (question.question_status === "multiple text") { // 如果是填空题
                                answers[i]["value"] = JSON.parse(answer.value);
                                console.log(answers[i])
                            }
                            break;
                        }
                    }
                }
                let req = {
                    answers: answers,  // 用户的考试答案
                    exam_room_id: "{{ $exam_room->id }}"
                }
                if ('{{ $paper->total }}' != answers.length && validateQuestion) {
                    swal('你还未完成试卷请继续答题', '', 'error');
                    // 锚点跳转
                    let arr = menu.filter(ea => answers.every(eb => eb.id !== ea.question_id)).map(item => item.question_id); //未完成的试题数组
                    var target = $("#question_" + arr[0]);
                    var top = target.offset().top - 120; // 距离顶部120像素
                    if(top > 0) {
                        $('html,body').animate({ scrollTop: top }, 1000); //带jq动画的跳转
                    }
                    return;
                }
                axios.post('{{ route('answers.store') }}', req).then(() => {
                    // 清除所有缓存
                    sessionStorage.clear();
                    location.href = "{{ route('root') }}";
                }, function (error) {
                    if (error.response && error.response.status === 401) {
                        swal('请先登录', '', 'error');
                    } else if (error.response && (error.response.data.msg || error.response.data.message)) {
                        swal(error.response.data.msg ? error.response.data.msg : error.response.data.message, '', 'error');
                    } else {
                        swal('系统错误', '', 'error');
                    }
                });
            }

            // 考试倒计时
            function countTime() {
                let date = new Date()
                let now = date.getTime() //获取当前时间

                let endTime = "{{ \Illuminate\Support\Carbon::parse($exam_room->end_at)->timestamp }}" //设置截止时间 ，后台传入考试结束时间即可
                endTime = parseInt(endTime)

                //js和php的时间戳相互转化要*1000
                let end = endTime * 1000
                //时间差
                let leftTime = end - now
                //定义变量 d,h,m,s保存倒计时的时间
                let d, h, m, s
                if (leftTime >= 0) {
                    d = Math.floor(leftTime / 1000 / 60 / 60 / 24)
                    h = Math.floor(leftTime / 1000 / 60 / 60 % 24)
                    m = Math.floor(leftTime / 1000 / 60 % 60)
                    s = Math.floor(leftTime / 1000 % 60)
                } else {
                    // 考试结束, 自动提交试卷
                    saveAnswer(false);
                }
                //将倒计时赋值到div中
                $("#end-time").text("考试剩余时间: " + h + "时 " + m + "分 " + s + "秒")
                //递归每秒调用countTime方法，显示动态时间效果
                this.setTimeout(countTime, 500)
            }

            // 跳转到顶部
            $('.toTop').click(function () {
                $("html,body").animate({ scrollTop: "0px" }, 500);//500毫秒完成回到顶部动画
            })
        })
    </script>
@endsection
