<?php

namespace App\Action\Admin;

use App\Action\Action as Action;

final class LoginAction extends Action {//mesmo nome do file

    public function index ($request, $response) {
        if (isset($_SESSION[PREFIX . 'logado'])) {
            return $response->withRedirect(PATH . '/admin');
        }
        return $this->view->render($response, 'admin/login/login.phtml');

    }

    public function logar ($request, $response) {

        $data = $request->getParsedBody();

        $email = strip_tags(filter_var($data['email'], FILTER_SANITIZE_STRING));
        $senha = strip_tags(filter_var($data['senha'], FILTER_SANITIZE_STRING));

        if ($email != '' && $senha != '') {
            $sql = "SELECT `id` FROM `usuarios` WHERE `email` = ? AND `senha` = ?";
            $verifaNoBanco = $this->db->prepare($sql);
            $verifaNoBanco->execute(array($email, $senha));

            if ($verifaNoBanco->rowCount() > 0) {
                $_SESSION[PREFIX . 'logado'] = true;

                return $response->withRedirect(PATH . '/admin');
            } else {
                $vars['erro'] = 'Você não foi encontrado no sistema.';

                return $this->view->render($response, 'admin/login/login.phtml', $vars);
            }
        } else {
            $vars['erro'] = 'Preencha todos os campos.';

            return $this->view->render($response, 'admin/login/login.phtml', $vars);
        }
    }

    public function logout ($request, $response) {
        unset($_SESSION[PREFIX . 'logado']);
        session_destroy();

        return $response->withRedirect(PATH . '/admin/login');
    }
}