@extends('layouts.app')
@section('title', '首页')

@section('content')
    <div class="tt-tab-wrapper">
        <div class="tt-wrapper-inner">
            <ul class="nav nav-tabs pt-tabs-default" role="tablist">
                <li class="nav-item tt-hide-md">
                    <a class="nav-link active" data-toggle="tab" href="#tt-tab-01" role="tab"><span>最新文档</span></a>
                </li>
            </ul>
        </div>
        <div class="tab-content" style="min-height: 500px">
            <div class="tab-pane show active" id="tt-tab-01" role="tabpanel">
                <a href="#">
                    <div class="tt-wrapper-inner">
                        <div class="tt-categories-list">
                            <div class="row">
                                <!-- 文档start -->
                                @foreach($article_dirs as $article_dir)
                                    <a href="{{ route('article.show', ['articleDir' => $article_dir->id]) }}">
                                        <div class="col-md-6 col-lg-3 book">
                                            <div class="tt-item">
                                                <div class="tt-item-layout">
                                                    <div class="innerwrapper">
                                                        <h6 class="tt-title">{{ $article_dir['category'] }}</h6>
                                                        <div class="cover">
                                                            <div
                                                                class="cover-title tt-innerwrapper">{{ $article_dir['category'] }}</div>
                                                        </div>
                                                    </div>
                                                    <div class="tt-item-header">
                                                        <ul class="tt-list-badge">
                                                            <li><a href="#"><span
                                                                        class="tt-color15 tt-badge">点击阅读</span></a>
                                                            </li>
                                                        </ul>
                                                        <h6 class="tt-title"><a href="#">Threads - 1,245</a></h6>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                            @endforeach
                            <!-- 文档end -->
                                <div class="book-pagination">
                                    <div>{{ $article_dirs->render() }}</div>
                                </div>
                            </div>
                        </div>
                    </div>

            </div>
        </div>
    </div>
@endsection

@section('scriptsAfterJs')
    <script !src="">
        $(function () {
            $('.open-book').click(function () {

            });
        })
    </script>
@endsection
