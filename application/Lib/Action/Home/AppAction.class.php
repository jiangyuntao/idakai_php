<?php
class AppAction extends Action {
    // @todo 用户登录验证之类的
    public function __construct() {
        parent::__construct();
    }

    protected function isPost() {
        if (isset($_SERVER['REQUEST_METHOD'])
            && strtolower($_SERVER['REQUEST_METHOD']) == 'post') {
            return true;
        } else {
            return false;
        }
    }
}
