<?php
class IndexAction extends AppAction {
    public function index() {
        $this->assign($this->data);
        $this->display();
    }

    public function home() {
        $this->assign($this->data);
        $this->display();
    }
}
