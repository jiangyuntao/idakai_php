<?php
/**
 * PAction
 *
 * @uses AppAction
 * @version $Id$
 * @author Thor Jiang <jiangyuntao@gmail.com>
 */
class PAction extends AppAction {
    protected $offset = 15;

    public function index() {
        $pView = D('PView');

        import('ORG.Util.Page');

        $condition = "language='{$this->data['setting']['default_language']}'";
        if (isset($_GET['q'])) {
            $condition .= " && title LIKE '%{$_GET['q']}%'";
            $this->data['q'] = $_GET['q'];
        }

        $p_count = $pView->where($condition)->count('p.id');
        $page = new Page($p_count, $this->offset);
        if (isset($_GET['q'])) {
            $page->parameter = 'q=' . urlencode($_GET['q']);
        }

        $this->data['list'] = $pView->where($condition)
            ->order('sortorder desc, id desc')
            ->limit($page->firstRow . ',' . $page->listRows)
            ->select();

        $this->data['pagination'] = $page->show();

        $this->assign($this->data);
        $this->display();
    }

    public function create() {
        $p = D('P');

        if ($this->isPost()) {
            $_POST['author'] || $_POST['author'] = $this->auth['username'];

            // 主表添加信息
            if ($p->create() && $id = $p->add()) {
                // 根据 id 更新 sortorder
                $p->find($id);
                $p->sortorder = $id;
                $p->save();

                // 添加不同语言内容
                foreach ($this->data['language'] as $lang) {
                    $pLocal = D('PLocal');

                    $pLocal->p_id = $id;
                    $pLocal->language = $lang['language'];
                    $pLocal->title = $_POST['title'][$lang['language']];
                    $pLocal->keywords = $_POST['keywords'][$lang['language']];
                    $pLocal->description = $_POST['description'][$lang['language']];
                    $pLocal->content = $_POST['content'][$lang['language']];
                    $pLocal->created = $pLocal->modified = time();

                    if (!$pLocal->add()) {
                        // 如果某一语言内容添加失败，删除之前添加的主表信息和其他语言内容
                        $p->where("id='{$id}'")->delete();
                        $pLocal->where("p_id='{$id}'")->delete();

                        $this->assign('waitSecond', 2);
                        $this->assign('jumpUrl', U('p/create'));
                        return $this->error('创建失败！');
                    }
                }

                $this->assign('waitSecond', 2);
                $this->assign('jumpUrl', U('p/index'));
                return $this->success('创建成功');
            } else {
                $this->assign('waitSecond', 2);
                $this->assign('jumpUrl', U('p/create'));
                return $this->error('创建失败');
            }
        }

        $this->assign($this->data);
        $this->display();
    }

    public function modify() {
        $p = D('P');

        if ($this->isPost()) {
            $_POST['author'] || $_POST['author'] = $this->auth['username'];

            // 修改主表信息
            if ($p->create() && $p->save()) {
                // 修改不同语言内容
                foreach ($this->data['language'] as $lang) {
                    $pLocal = D('PLocal');

                    $pLocal->where("p_id='{$_GET['id']}' && language='{$lang['language']}'")->find();
                    $pLocal->title = $_POST['title'][$lang['language']];
                    $pLocal->keywords = $_POST['keywords'][$lang['language']];
                    $pLocal->description = $_POST['description'][$lang['language']];
                    $pLocal->content = $_POST['content'][$lang['language']];
                    $pLocal->modified = time();

                    if (!$pLocal->save()) {
                        $this->assign('waitSecond', 2);
                        $this->assign('jumpUrl', U('p/modify', 'id=' . $_GET['id']));
                        return $this->error('创建失败！');
                    }
                }

                $this->assign('waitSecond', 2);
                $this->assign('jumpUrl', U('p/modify', 'id=' . $_GET['id']));
                return $this->success('修改成功');
            } else {
                return $this->error('修改失败');
            }
        }

        $this->data['p'] = $p->find($_GET['id']);

        $pLocal = D('PLocal');
        $locals = $pLocal->where("p_id='{$_GET['id']}'")->select();
        foreach ($locals as $v) {
            $this->data['p']['language'][$v['language']] = $v;
        }

        $this->assign($this->data);
        $this->display();
    }

    public function remove() {
        $p = D('P');
        $pLocal = D('PLocal');

        if ($p->delete($_GET['id']) && $pLocal->where("p_id='{$_GET['id']}'")->delete()) {
            $this->assign('waitSecond', 2);
            $this->assign('jumpUrl', U('p/index'));
            return $this->success('删除成功');
        } else {
            $this->assign('waitSecond', 2);
            $this->assign('jumpUrl', U('p/index', $_SESSION['listpage']));
            return $this->error('删除失败' . $p->getError());
        }
    }

    public function up() {
        $p = D('P');

        $current = $p->find($_GET['id']);
        $upper = $p->where("sortorder>'{$current['sortorder']}'")->order('sortorder asc, id asc')->limit(1)->find();

        if ($upper) {
            $tmp = $current['sortorder'];
            $current['sortorder'] = $upper['sortorder'];
            $upper['sortorder'] = $tmp;
            $p->save($upper);
            $p->save($current);
        }

        redirect(U('p/index', $_SESSION['listpage']));
    }

    public function down() {
        $p = D('P');

        $current = $p->find($_GET['id']);
        $upper = $p->where("sortorder<'{$current['sortorder']}'")->order('sortorder desc, id desc')->limit(1)->find();

        if ($upper) {
            $tmp = $current['sortorder'];
            $current['sortorder'] = $upper['sortorder'];
            $upper['sortorder'] = $tmp;
            $p->save($upper);
            $p->save($current);
        }

        redirect(U('p/index', $_SESSION['listpage']));
    }
}
