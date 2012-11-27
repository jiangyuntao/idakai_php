<?php
class AppAction extends Action {
    protected $data = array();

    // @todo 用户登录验证之类的
    public function __construct() {
        parent::__construct();

        // uploadify hack。由于客户端不同，只能手动传递 session
        if (isset($_GET['PHPSESSIONID'])) {
            session_id($_GET['PHPSESSIONID']);
        }
        session_start();

        load('extend');
        import('ORG.Crypt.Crypt');
        import('ORG.Util.Cookie');

        // 获取用户登录信息
        $this->data['auth'] = unserialize(Crypt::decrypt(COOKIE::get('auth'), C('SALT'), true));
    }

    protected function jsonReturn($data = null) {
        header("Expires: Mon, 26 Jul 1997 05:00:00 GMT" );
        header("Last-Modified: " . gmdate( "D, d M Y H:i:s" ) . " GMT" );
        header("Cache-Control: no-cache, must-revalidate" );
        header("Pragma: no-cache" );
        header("Content-type: text/x-json");
        exit(json_encode($data));
    }
}
