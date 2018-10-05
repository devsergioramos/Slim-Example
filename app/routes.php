<?php

// ADMINISTRAÇÃO
$app->get('/admin/login', 'App\Action\Admin\LoginAction:index');
$app->post('/admin/login', 'App\Action\Admin\LoginAction:logar');
$app->get('/admin/logout', 'App\Action\Admin\LoginAction:logout');

$app->group('/admin', function() {
    $this->get('', 'App\Action\Admin\HomeAction:index');

    //POSTS
    $this->get('/posts', 'App\Action\Admin\PostAction:index');
    $this->get('/posts/{id}/view', 'App\Action\Admin\PostAction:view');
    $this->get('/posts/add', 'App\Action\Admin\PostAction:add');
    $this->post('/posts/add', 'App\Action\Admin\PostAction:store');
    $this->get('/posts/{id}/edit', 'App\Action\Admin\PostAction:edit');
    $this->post('/posts/{id}/edit', 'App\Action\Admin\PostAction:update');
    $this->get('/posts/{id}/del', 'App\Action\Admin\PostAction:del');
})->add(App\Middleware\Admin\AuthMiddleware::class);

// Site
$app->get('/', 'App\Action\HomeAction:index');
$app->get('/sobre', 'App\Action\HomeAction:sobre');
$app->get('/contato', 'App\Action\HomeAction:contato');