@extends('layouts.app')
@section('title', '文档展示')

@section('content')
    <link rel="stylesheet" href="{{ asset('assets/layui/css/layui.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/pjax/pjax.css') }}">

    <div class="tt-tab-wrapper">
        <div class="container" id="pjax-container">
            <div class="tt-wrapper-inner">
                <h4 class="tt-title-separator"><span>{{ $article->title }}</span></h4>
            </div>
            <div class="tt-single-topic-list">
                <div class="tt-item">
                    <div class="tt-single-topic">
                        <div class="tt-item-header pt-noborder">
                            <div class="tt-item-info info-top">
                                <div class="tt-avatar-icon">
                                    <div class="user-avatar author-avatar">
                                        {{ mb_substr($article->author, 0, 1) }}
                                    </div>
                                </div>
                                <div class="tt-avatar-title">
                                    <a href="#">上传用户: {{ $article->author }}</a>
                                </div>
                                <a href="#" class="tt-info-time">
                                    {{ $article->created_at ? $article->creted_at : "2019 06 08"}}
                                </a>
                            </div>
                        </div>
                        <div class="tt-item-description">
                            {{ $articleDir->memo }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="tt-wrapper-inner">
                <h4 class="tt-title-separator"></h4>
            </div>

            <div class="tt-single-topic-list">
                <div class="tt-item">
                    <div class="tt-single-topic">
                        <div class="tt-item-description">
                            <h3 class="tt-item-title" style="margin-bottom: 30px">
                                <a href="#">{{ $article->title }}</a>
                            </h3>
                            {!! $article->content !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!--目录开始-->
        <ul class="site-dir">
            <div id="book" class="demo-tree" style=""></div>
        </ul>
        <!--目录结束-->
    </div>
@endsection

@section('scriptsAfterJs')
    <script src="{{ asset('assets/layui/layui.js') }}"></script>
    <script src="https://cdn.bootcss.com/jquery.pjax/2.0.1/jquery.pjax.min.js"></script>
    <script src="{{ asset('assets/pjax/pjax.js') }}"></script>
    <script>
        $(function () {
            let author = '{{ $article->author }}';
            getBackgroundColorByAuthor(author)
        });

        // 上传用户头像背景颜色
        function getBackgroundColorByAuthor(name) {
            $('.author-avatar').css('background-color', text2Img(name));
        }

        layui.use(['tree', 'jquery', 'layer'], function () {
            var tree = layui.tree,
                $ = layui.jquery,
                layer = layui.layer
            // 加载目录数据
            axios.get('{{ route('article_dir.show', ['id' => $articleDir->id]) }}').then((data) => {
                let res = data.data.data;
                tree.render({
                    elem: '#book',
                    data: res,
                    click: function (obj) {  // 点击目录触发事件
                        let data = obj.data
                        $.pjax.defaults.dataType = null;
                        if (data.hasOwnProperty("article_dir_id")) {  // 存在category_id表示是文章
                            $.pjax(
                                {
                                    container: '#pjax-container',
                                    url: "http://exam.test/article_dir/{{ $articleDir->id }}/article/" + data.id
                                }
                            );
                        }
                    }
                });
            }, function (error) {
                if (error.response && error.response.status === 401) {
                    swal('请先登录', '', 'error');
                } else if (error.response && (error.response.data.msg || error.response.data.message)) {
                    swal(error.response.data.msg ? error.response.data.msg : error.response.data.message, '', 'error');
                } else {
                    swal('系统错误', '', 'error');
                }
            });

            var siteDir = $('.site-dir');
            if (siteDir[0] && $(window).width() > 750) {
                layer.ready(function () {
                    layer.open({
                        type: 1
                        , content: siteDir
                        , skin: 'layui-layer-dir'
                        , area: 'auto'
                        , maxHeight: $(window).height() - 300
                        , title: '目录'
                        , closeBtn: false
                        , offset: 'r'
                        , shade: false
                        , success: function (layero, index) {
                            layer.style(index, {
                                marginLeft: -15
                            });
                        }
                    });
                });
                siteDir.find('li').on('click', function () {
                    var othis = $(this);
                    othis.find('a').addClass('layui-this');
                    othis.siblings().find('a').removeClass('layui-this');
                });
            }
        });


    </script>
@endsection
