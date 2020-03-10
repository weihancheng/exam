<div id="js-popup-settings" class="tt-popup-settings">
    <div class="tt-btn-col-close">
        <a href="#" style="display: flex; align-items: center">
			<span class="tt-icon-title">
				<span class="icon iconfont icon-icon-test16"></span>
			</span>
            <span class="tt-icon-text">
				设置
			</span>
            <span class="tt-icon-close">
				<span class="icon iconfont icon-icon-test44"></span>
			</span>
        </a>
    </div>
    <div class="tt-form-upload">
        <div class="row no-gutter">
            <div class="col-auto">
                <div class="tt-icon">
                    <div class="user-avatar">
                        {{ mb_substr(Auth::user()->username, 0, 1) }}
                    </div>
                </div>
            </div>
            <div class="col-auto ml-auto">
                <a href="#" class="btn btn-primary">上传头像</a>
            </div>
        </div>
    </div>
    <form action="{{ route('users.update.own', [ 'user' => auth()->user()->id ]) }}" method="post">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="settingsUserName">用户名</label>
            <input type="text" name="username" class="form-control" placeholder="{{ Auth::user()->username }}"
                   value="{{ Auth::user()->username }}">
        </div>
        <div class="form-group">
            <label for="settingsUserEmail">手机号</label>
            <input type="text" name="mobile" class="form-control" placeholder="{{ Auth::user()->mobile }}"
                   value="{{ Auth::user()->mobile }}">
        </div>
        <div class="form-group">
            <label for="settingsUserWebsite">身份证</label>
            <input type="text" name="id_card" class="form-control" placeholder="{{ Auth::user()->id_card }}"
                   value="{{ Auth::user()->id_card }}">
        </div>
        <div class="form-group">
            <label for="settingsUserAbout">反馈</label>
            <textarea name="memo" placeholder="您的反馈对我们十分重要" class="form-control"></textarea>
        </div>
        <div class="form-group">
            <label for="settingsUserAbout">功能设置</label>
            <div class="checkbox-group">
                <input type="checkbox" id="settingsCheckBox01" name="checkbox">
                <label for="settingsCheckBox01">
                    <span class="check"></span>
                    <span class="box"></span>
                    <span class="tt-text">文档目录置于左边</span>
                </label>
            </div>
            <div class="checkbox-group">
                <input type="checkbox" id="settingsCheckBox02" name="checkbox">
                <label for="settingsCheckBox02">
                    <span class="check"></span>
                    <span class="box"></span>
                    <span class="tt-text">默认开启黑夜模式</span>
                </label>
            </div>
            <div class="checkbox-group">
                <input type="checkbox" id="settingsCheckBox03" name="checkbox">
                <label for="settingsCheckBox03">
                    <span class="check"></span>
                    <span class="box"></span>
                    <span class="tt-text">申请开启管理员功能</span>
                </label>
            </div>
        </div>
        <div class="form-group">
            <button type="submit" href="#" class="btn btn-secondary btn-user-update-own">保存</button>
        </div>
    </form>
</div>
