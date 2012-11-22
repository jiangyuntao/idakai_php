<?php
class UserModel extends AppModel {
    protected $_auto = array_merge(parent::$_auto, array(
        array('signup_time', 'time', Model::MODEL_INSERT, 'function'),
        array('signup_ip', 'get_client_ip', Model::MODEL_INSERT, 'function'),
    ));

    public function encryptPassword($password = '') {
        import('ORG.Crypt.Crypt');
        return md5(Crypt::encrypt($password, C('SALT'), true));
    }
}
