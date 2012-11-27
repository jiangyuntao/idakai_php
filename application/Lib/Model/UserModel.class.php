<?php
class UserModel extends AppModel {
    public function __construct() {
        parent::__construct();

        $this->_auto = array_merge($this->_auto, array(
            array('signup_time', 'time', Model::MODEL_INSERT, 'function'),
            array('signup_ip', 'get_client_ip', Model::MODEL_INSERT, 'function'),
        ));
    }

    /**
     * 登录
     *
     * @param string $username
     * @param string $password
     * @access public
     * @return mixed. -1 用户不存在; -2 密码错误; 否则返回用户信息
     */
    public function signin($username = '', $password = '') {
        if (strpos($username, '@')) {
            $condition = "email='{$username}'";
        } else {
            $condition = "username='{$username}'";
        }

        if (!$user = $this->where($condition)->find()) {
            return -1;
        }

        if ($this->encryptPassword($password) != $user['password']) {
            return -2;
        }

        return $user;
    }

    public function encryptPassword($password = '') {
        import('ORG.Crypt.Crypt');
        return md5(Crypt::encrypt($password, C('SALT'), true));
    }
}
