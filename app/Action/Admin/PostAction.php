<?php

namespace App\Action\Admin;

use App\Action\Action as Action;

final class PostAction extends Action {//mesmo nome do file

    public function index($request, $response) {

        $vars['title'] = 'Lista de Posts';
        $vars['page'] = 'posts/list';

        $posts = $this->db->prepare("SELECT `id`, `titulo`, `descricao` FROM `posts` ORDER BY `id` DESC");
        $posts->execute();

        if ($posts->rowCount() > 0) {
            $vars['posts'] = $posts->fetchAll(\PDO::FETCH_OBJ);
        }

        return $this->view->render($response, 'admin/template.phtml', $vars);
    }

    public function view($request, $response) {

        $id = $request->getAttribute('id');

        if (! is_numeric($id)) {
            return $response->withRedirect(PATH . '/admin/posts');
        }

        $post = $this->db->prepare("SELECT `id`, `titulo`, `descricao` FROM `posts` WHERE `id` = ?");
        $post->execute(array($id));

        if ($post->rowCount() == 0) {
            return $response->withRedirect(PATH . '/admin/posts');
        }

        $vars['post'] = $post->fetch(\PDO::FETCH_OBJ);

        $vars['title'] = 'Visualizando';
        $vars['page'] = 'posts/view';

        return $this->view->render($response, 'admin/template.phtml', $vars);
    }

    public function add($request, $response) {

        $vars['title'] = 'Novo Post';
        $vars['page'] = 'posts/add';

        return $this->view->render($response, 'admin/template.phtml', $vars);
    }

    public function store($request, $response) {

        $data = $request->getParsedBody();

        $titulo = filter_var($data['titulo'], FILTER_SANITIZE_STRING);
        $descricao = filter_var($data['descricao'], FILTER_SANITIZE_STRING);

        if ($titulo != "" && $descricao != "") {
            
            $cadastrar = $this->db->prepare("INSERT INTO `posts` SET `titulo` = ?, `descricao` = ?");
            $cadastrar->execute(array($titulo, $descricao));

            return $response->withRedirect(PATH . '/admin/posts');
        }

        $vars['title'] = 'Novo Post';
        $vars['page'] = 'posts/add';

        $vars['error'] = 'Preencha todos os campos.';

        return $this->view->render($response, 'admin/template.phtml', $vars);
    }

    public function edit($request, $response) {

        $id = $request->getAttribute('id');

        if (! is_numeric($id)) {
            return $response->withRedirect(PATH . '/admin/posts');
        }

        $post = $this->db->prepare("SELECT `id`, `titulo`, `descricao` FROM `posts` WHERE `id` = ?");
        $post->execute(array($id));

        if ($post->rowCount() == 0) {
            return $response->withRedirect(PATH . '/admin/posts');
        }

        $vars['post'] = $post->fetch(\PDO::FETCH_OBJ);

        $vars['title'] = 'Editar Post';
        $vars['page'] = 'posts/edit';

        return $this->view->render($response, 'admin/template.phtml', $vars);
    }

    public function update($request, $response) {
        $id = $request->getAttribute('id');

        if (! is_numeric($id)) {
            return $response->withRedirect(PATH . '/admin/posts');
        }

        $post = $this->db->prepare("SELECT `id`, `titulo`, `descricao` FROM `posts` WHERE `id` = ?");
        $post->execute(array($id));

        if ($post->rowCount() == 0) {
            return $response->withRedirect(PATH . '/admin/posts');
        }

        $data = $request->getParsedBody();

        $titulo = filter_var($data['titulo'], FILTER_SANITIZE_STRING);
        $descricao = filter_var($data['descricao'], FILTER_SANITIZE_STRING);

        if ($titulo != "" && $descricao != "") {
            
            $atualizar = $this->db->prepare("UPDATE `posts` SET `titulo` = ?, `descricao` = ? WHERE `id` = ?");
            $atualizar->execute(array($titulo, $descricao, $id));

            return $response->withRedirect(PATH . '/admin/posts');
        }

        $vars['post'] = $post->fetch(\PDO::FETCH_OBJ);

        $vars['title'] = 'Editar Post';
        $vars['page'] = 'posts/edit';

        $vars['error'] = 'Preencha todos os campos.';

        return $this->view->render($response, 'admin/template.phtml', $vars);
    }

    public function del($request, $response) {

        $id = $request->getAttribute('id');

        if (! is_numeric($id)) {
            return $response->withRedirect(PATH . '/admin/posts');
        }

        $post = $this->db->prepare("SELECT `id`, `titulo`, `descricao` FROM `posts` WHERE `id` = ?");
        $post->execute(array($id));

        if ($post->rowCount() == 0) {
            return $response->withRedirect(PATH . '/admin/posts');
        }

        $deletar = $this->db->prepare("DELETE FROM `posts` WHERE `id` = ?");
        $deletar->execute(array($id));

        return $response->withRedirect(PATH . '/admin/posts');
    }
}