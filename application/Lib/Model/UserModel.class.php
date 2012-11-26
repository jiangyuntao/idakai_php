<?php
class UserModel extends AppModel {
    public function __construct() {
        parent::__construct();

        $this->_auto = array_merge($this->_auto, array(
            array('signup_time', 'time', Model::MODEL_INSERT, 'function'),
            array('signup_ip', 'get_client_ip', Model::MODEL_INSERT, 'function'),
        ));
    }

    public function encryptPassword($password = '') {
        import('ORG.Crypt.Crypt');
        return md5(Crypt::encrypt($password, C('SALT'), true));
    }
}
