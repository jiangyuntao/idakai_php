<?php
class IndexAction extends Action {
    public function index() {
        $this->display();
    }

    public function foo() {
        echo 'foo';
    }
}
