<?php
/**
 * 本文件存放自定义辅助函数
 */

function route_class() {
    return str_replace('.', '-', Route::currentRouteName());
}

// 数字转Abcd
function num2abc($num) {
    $abc = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N',
        'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'S', 'Y', 'Z'];
    return $abc[$num];
}
