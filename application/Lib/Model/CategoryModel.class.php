<?php
class CategoryModel extends AppModel {
    public function getList() {
        return $this->order('sortorder desc, id desc')->select();
    }
}
