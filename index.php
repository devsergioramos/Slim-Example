<?php
session_start();//inicia uma nova sessão ou resuma uma sessão existente

error_reporting(E_ALL | E_STRICT);// Define quais erros serão reportados
//E_ALL = mostra todos os erros | E_STRICT = Permite o PHP sugerir mudanças ao seu codigo   
ini_set('display_errors', 'On');//exibe erros

require 'vendor/autoload.php';
require 'config/constants.php';
require 'config/config.php';

$app = new \Slim\App(['settings' => $config]);

$container = $app->getContainer();

$container['view'] = new \Slim\Views\PhpRenderer('resources/views/');

$container['db'] = function ($c) {

    $db = $c['settings']['db'];

    $pdo = new PDO('mysql:host=' . $db['host'] . ';dbname=' . $db['dbname'],
        $db['user'], $db['pass']);

    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    
    return $pdo;
};

require 'app/routes.php';

$app->run();