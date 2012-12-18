<?php
class GroupAction extends AppAction {
    public function index() {
        $this->assign($this->data);
        $this->display();
    }

    public function create() {
        $category = D('Category');
        $this->data['categories'] = $category->getList();

        $this->assign($this->data);
        $this->display();
    }
}
