<?php

require_once __DIR__ . '/../models/Utilisateur.php';
require_once __DIR__ . '/../models/client.php';

$method = $_SERVER['REQUEST_METHOD'];
$uri = str_replace('/NAYLOTH/public', '', parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));

checkUserRole('admin');

if($method === 'GET' && $uri === '/admin/clients'){}
elseif($method === 'GET' && $uri === '/admin/clients/create'){}
elseif($method === 'GET' && $uri === '/admin/clients/show'){}
elseif($method === 'GET' && $uri === '/admin/clients/edit'){}
elseif($method === 'POST' && $uri === '/admin/clients/create'){}
elseif($method === 'POST' && $uri === '/admin/clients/edit'){}
elseif($method === 'POST' && $uri === '/admin/clients/delete'){}