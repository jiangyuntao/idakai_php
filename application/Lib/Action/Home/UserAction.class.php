<?php
class UserAction extends AppAction {
    public function index() {
    }

    public function signup() {
        if ($this->isPost()) {
            $user = D('User');
            if ($user->create() && $user->add()) {
            } else {
            }
        }
        $this->display();
    }

    public function signin() {
        if ($this->isPost()) {
            $user = D('User');

            if (strpos($_POST['username'], '@')) {
                $condition = "email='{$_POST['email']}'";
            } else {
                $condition = "username='{$_POST['username']}'";
            }

            if (!$entry = $user->where($condition)->find()) {
            }

            $if ($entry->password != $user->encryptPassword($_POST['password'])) {
            }
        } else {
        }
        $this->display();
    }

    public function captcha() {
        import('ORG.Util.Image');
        Image::buildImageVerify();
    }
}
