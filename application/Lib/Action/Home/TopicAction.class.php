<?php
class TopicAction extends AppAction {
    public function index() {
        $this->assign($this->data);
        $this->display();
    }

    public function detail() {
        $this->assign($this->data);
        $this->display();
    }
}
