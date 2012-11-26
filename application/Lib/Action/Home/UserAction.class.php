<?php
class UserAction extends AppAction {
    public function index() {
    }

    public function signup() {
        if ($this->isPost()) {
            $user = D('User');
            $user->password = $user->encryptPassword($_POST['password']);
            if ($user->create() && $user->add()) {
                // @todo 成功后自动登录
                // @todo 成功后跳转到上传头像, UserAction::signup_finish()
            } else {
                // @todo 跳转到错误页
            }
            return;
        }
        $this->display();
    }

    public function signupFinish() {
        echo 'foo';
        $this->display();
    }

    public function signin() {
        if ($this->isPost()) {
            $user = D('User');

            if (strpos($_POST['username'], '@')) {
                $condition = "email='{$_POST['username']}'";
            } else {
                $condition = "username='{$_POST['username']}'";
            }

            if (!$entry = $user->where($condition)->find()) {
                // @todo 帐号不存在
            }

            if ($entry->password != $user->encryptPassword($_POST['password'])) {
                // @todo 密码错误
            }

            $auth = array(
                'id' => $entry->id,
                'username' => $entry->username,
                'avatar' => $entry->avatar,
            );

            if ($_POST['remember']) {
                Cookie::set();
            } else {
                Cookie::set();
            }

            return;
        }

        $this->display();
    }

    public function signout() {
    }

    public function captcha() {
        import('ORG.Util.Image');
        Image::buildImageVerify();
    }

    public function avatar_upload() {
    }
}
