<div class="tt-wrapper-section">
    <div class="container">
        <div class="tt-user-header">
            <div class="tt-col-avatar">
                <div class="tt-icon">
                    <div class="user-avatar">
                        {{ mb_substr(Auth::user()->username, 0, 1) }}
                    </div>
                </div>
            </div>
            <div class="tt-col-title">
                <div class="tt-title">
                    <a href="#">{{ Auth::user()->username }}</a>
                </div>
                <ul class="tt-list-badge">
                    <li><a href="#"><span class="tt-color14 tt-badge">用户</span></a></li>
                </ul>
            </div>
            <div class="tt-col-btn" id="js-settings-btn">
                <div class="tt-list-btn">
                    <a href="#" class="tt-btn-icon">
				        <span class="icon iconfont icon-icon-test16"></span>
                    </a>
                    <a href="#" class="btn btn-primary">信息通知</a>
                    <a href="#" class="btn btn-secondary">设置</a>
                </div>
            </div>
        </div>
    </div>
</div>
