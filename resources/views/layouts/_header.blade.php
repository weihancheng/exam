<nav class="panel-menu" id="mobile-menu">
    <ul></ul>
    <div class="mm-navbtn-names">
        <div class="mm-closebtn">
            Close
            <div class="tt-icon">
                <svg>
                    <use xlink:href="#icon-cancel"></use>
                </svg>
            </div>
        </div>
        <div class="mm-backbtn">Back</div>
    </div>
</nav>
<header id="tt-header">
    <div class="container">
        <div class="row tt-row no-gutters">
            <div class="col-auto">
                <!-- toggle mobile menu -->
                <a class="toggle-mobile-menu" href="#">
                    <svg class="tt-icon">
                        <use xlink:href="#icon-menu_icon"></use>
                    </svg>
                </a>
                <!-- /toggle mobile menu -->
                <!-- logo -->
                <div class="tt-logo">
                    <a href="index.html"><img src="{{ asset('assets/images/logo.png') }}" alt=""></a>
                </div>
                <!-- /logo -->
                <!-- desctop menu -->
                <div class="tt-desktop-menu">
                    <nav>
                        <ul>
                            <li><a href="{{ route('exam_room.index') }}"><span>考试</span></a></li>
                            <li><a href="{{ route('article_dir.index') }}"><span>文档</span></a></li>
                            <li><a href="page-create-topic.html"><span>视屏</span></a></li>
                            <li>
                                <a href="page-single-user.html"><span>后台管理</span></a>
                                <ul>
                                    <li><a href="{{ route('admin.login') }}" target="_blank">进入后台</a></li>
                                    <li><a href="{{ route('admin.papers.create') }}" target="_blank">添加试卷</a></li>
                                    <li><a href="{{ route('admin.examrooms.create') }}" target="_blank">添加考场</a></li>
                                    <li><a href="{{ route('admin.examrooms.index') }}" target="_blank">批改试卷</a></li>
                                    <li><a href="index.html" target="_blank">检测考场</a></li>
                                    <li><a href="index.html" target="_blank">发送消息</a></li>
                                </ul>
                            </li>
                        </ul>
                    </nav>
                </div>
                <!-- /desctop menu -->
                <!-- tt-search -->
                <div class="tt-search" style="position: relative;">
                    <!-- toggle -->
                    <i class="icon iconfont icon-icon-test12" style="font-size: 24px;z-index: 100;position: absolute;bottom: 0px;left: 8px;"></i>
                    <!-- /toggle -->
                    <form class="search-wrapper">
                        <div class="search-form">
                            <input type="text" class="tt-search__input" placeholder="Search">
                            <button class="tt-search__btn" type="submit">
                                <svg class="tt-icon">
                                    <use xlink:href="#icon-search"></use>
                                </svg>
                            </button>
                            <button class="tt-search__close">
                                <svg class="tt-icon">
                                    <use xlink:href="#cancel"></use>
                                </svg>
                            </button>
                        </div>
                        <div class="search-results">
                            <div class="tt-search-scroll">
                                <ul>
                                    <li>
                                        <a href="page-single-topic.html">
                                            <h6 class="tt-title">Rdr2 secret easter eggs</h6>
                                            <div class="tt-description">
                                                Here’s what I’ve found in Red Dead Redem..
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="page-single-topic.html">
                                            <h6 class="tt-title">Top 10 easter eggs in Red Dead Rede..</h6>
                                            <div class="tt-description">
                                                You can find these easter eggs in Red Dea..
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="page-single-topic.html">
                                            <h6 class="tt-title">Red Dead Redemtion: Arthur Morgan..</h6>
                                            <div class="tt-description">
                                                Here’s what I’ve found in Red Dead Redem..
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="page-single-topic.html">
                                            <h6 class="tt-title">Rdr2 secret easter eggs</h6>
                                            <div class="tt-description">
                                                Here’s what I’ve found in Red Dead Redem..
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="page-single-topic.html">
                                            <h6 class="tt-title">Top 10 easter eggs in Red Dead Rede..</h6>
                                            <div class="tt-description">
                                                You can find these easter eggs in Red Dea..
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="page-single-topic.html">
                                            <h6 class="tt-title">Red Dead Redemtion: Arthur Morgan..</h6>
                                            <div class="tt-description">
                                                Here’s what I’ve found in Red Dead Redem..
                                            </div>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            <button type="button" class="tt-view-all" data-toggle="modal"
                                    data-target="#modalAdvancedSearch">Advanced Search
                            </button>
                        </div>
                    </form>
                </div>
                <!-- /tt-search -->
            </div>
            <div class="col-auto ml-auto">
                <div class="tt-user-info d-flex justify-content-center">
                    <a href="#" class="tt-btn-icon">
                        <i class="tt-icon">
                            <svg>
                                <use xlink:href="#icon-notification"></use>
                            </svg>
                        </i>
                    </a>
                    <div class="tt-avatar-icon tt-size-md">
                        <i class="tt-icon">
                            <svg>
                                <use xlink:href="#icon-ava-a"></use>
                            </svg>
                        </i>
                    </div>
                    <div class="custom-select-01">
                        <select>
                            <option value="Default Sorting">韦汉成</option>
                            <option value="value 01" class="logout">退出</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
