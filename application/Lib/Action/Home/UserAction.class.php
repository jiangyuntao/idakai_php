<?php
class UserAction extends Action {
    public function index() {
    }

    public function signup() {
        $this->display();
    }

    public function signin() {
        $this->display();
    }

    public function captcha() {
        import('ORG.Util.Image');
        Image::buildImageVerify();
    }
}
