<?php
/**
 * 自定义辅助函数放在这里
 */




function route_class(){
    return str_replace('.','-',Route::currentRouteName());
}