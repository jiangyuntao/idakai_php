<?php
/**
 * AdminModel
 *
 * @uses AppModel
 * @version $Id$
 * @author Thor Jiang <jiangyuntao@gmail.com>
 */
class AdminModel extends AppModel {
    public function encryptPassword($password = '') {
        import('ORG.Crypt.Crypt');
        return md5(Crypt::encrypt($password, C('SALT'), true));
    }
}
