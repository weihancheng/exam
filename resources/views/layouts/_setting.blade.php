<div id="js-popup-settings" class="tt-popup-settings">
    <div class="tt-btn-col-close">
        <a href="#">
			<span class="tt-icon-title">
				<svg>
					<use xlink:href="#icon-settings_fill"></use>
				</svg>
			</span>
            <span class="tt-icon-text">
				设置
			</span>
            <span class="tt-icon-close">
				<svg>
					<use xlink:href="#icon-cancel"></use>
				</svg>
			</span>
        </a>
    </div>
    <form class="form-default">
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
        <div class="form-group">
            <label for="settingsUserName">用户名</label>
            <input type="text" name="name" class="form-control" id="settingsUserName" placeholder="{{ Auth::user()->username }}">
        </div>
        <div class="form-group">
            <label for="settingsUserEmail">手机号</label>
            <input type="text" name="name" class="form-control" id="settingsUserEmail" placeholder="{{ Auth::user()->mobile }}">
        </div>
        <div class="form-group">
            <label for="settingsUserPassword">密码</label>
            <input type="password" name="name" class="form-control" id="settingsUserPassword"
                   placeholder="******">
        </div>
        <div class="form-group">
            <label for="settingsUserWebsite">身份证</label>
            <input type="text" name="name" class="form-control" id="settingsUserWebsite" placeholder="{{ Auth::user()->id_card }}">
        </div>
        <div class="form-group">
            <label for="settingsUserAbout">反馈</label>
            <textarea name="" placeholder="您的反馈对我们十分重要" class="form-control" id="settingsUserAbout"></textarea>
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
            <a href="#" class="btn btn-secondary">Save</a>
        </div>
    </form>
</div>
