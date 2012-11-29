<?php
class SquareAction extends AppAction {
    public function index() {
        $this->assign($this->data);
        $this->display();
    }
}
