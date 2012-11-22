<?php
class UserAction extends AppAction {
    public function index() {
    }

    public function signup() {
        if ($this->isPost()) {
            dump($_POST);
            exit;
        }
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
