<?php
require_once __DIR__ . '/../models/Utilisateur.php';

checkUserRole('admin');

$filename = $_GET['file'] ?? '';

// Bloquer toute tentative de path traversal
if(empty($filename) || strpos($filename, '..') !== false || strpos($filename, '/') !== false || strpos($filename, '\\') !== false){
    http_response_code(400);
    exit;
}

$path = __DIR__ . '/../../storage/pdfs/' . $filename;

if(!file_exists($path)){
    http_response_code(404);
    exit;
}

header('Content-Type: application/pdf');
header('Content-Disposition: inline; filename="' . $filename . '"');
readfile($path);
exit;
