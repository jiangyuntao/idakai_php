<?php
class UserAction extends AppAction {
    /**
     * 用户中心
     *
     * @access public
     * @return void
     */
    public function index() {
        $this->display();
    }

    /**
     * 注册
     *
     * @access public
     * @return void
     */
    public function signup() {
        if ($this->isPost()) {
            if ($_SESSION['verify'] != md5($_POST['captcha'])) {
                $this->error('验证码输入错误');
            }

            $user = D('User');
            $_POST['password'] = $user->encryptPassword($_POST['password']);

            if ($user->create() && $id = $user->add()) {
                // 注册成功后自动登录
                $this->_setAuthCookie(array(
                    'id' => $id,
                    'username' => $_POST['username'],
                ));

                // 成功后跳转到上传头像, UserAction::signup_finish()
                $this->redirect('/signup_finish');
            } else {
                // 跳转到错误页
                $this->error('注册失败，再来再来');
            }
        }

        $this->display();
    }

    /**
     * 注册完成。处理头像吧
     *
     * @access public
     * @return void
     */
    public function signupFinish() {
        echo 'fuck me';
        $this->display();
    }

    /**
     * 登录
     *
     * @access public
     * @return void
     */
    public function signin() {
        if ($this->isPost()) {
            $user = D('User');

            switch ($user = $user->signin($this->_post('username'), $this->_post('password'))) {
                case -1:
                break;
                case -2:
                break;
                default:
                    $this->_setAuthCookie(array(
                        'id' => $user['id'],
                        'username' => $user['username'],
                        'avatar' => $user['avatar'],
                    ));
                    $this->redirect('/square');
            }
        }

        $this->display();
    }

    protected function _setAuthCookie($auth = array(), $remember = true) {
        $auth = Crypt::encrypt(serialize($auth), C('SALT'), true);

        if ($remember) {
            // Cookie 记住10年
            Cookie::set('auth', $auth, 315576000);
        } else {
            Cookie::set('auth', $auth);
        }
    }

    /**
     * 退出登录
     *
     * @access public
     * @return void
     */
    public function signout() {
        Cookie::delete('auth');
        $this->redirect('/signin');
    }

    /**
     * 显示验证码
     *
     * @access public
     * @return void
     */
    public function captcha() {
        import('ORG.Util.Image');
        Image::buildImageVerify();
    }

    /**
     * 用户中心显示头像上传的页面
     *
     * @access public
     * @return void
     */
    public function avatar() {
        $this->display();
    }

    /**
     * 上传头像的处理方法
     *
     * @access public
     * @return void
     */
    public function avatarUpload() {
    }
}
