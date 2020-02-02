<?php
/**
 * 本文件存放自定义辅助函数
 */

function route_class() {
    return str_replace('.', '-', Route::currentRouteName());
}
