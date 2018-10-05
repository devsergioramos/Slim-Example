<?php

namespace App\Action\Admin;

use App\Action\Action as Action;

final class HomeAction extends Action {//mesmo nome do file

    public function index($request, $response) {
        $vars['page'] = 'home';

        return $this->view->render($response, 'admin/template.phtml', $vars);
    }
}