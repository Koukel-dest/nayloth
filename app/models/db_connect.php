<?php
require_once __DIR__ . "/../../env.php";

$db = new PDO("mysql:host=localhost;dbname=$db_name", $db_user, $db_password);
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);