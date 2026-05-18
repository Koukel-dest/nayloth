<?php

if ($_SESSION['user_role'] === 'admin') {
    require_once __DIR__ . '/../views/admin.php';
} elseif ($_SESSION['user_role'] === 'manager') {
    require_once __DIR__ . '/../views/manager.php';
} elseif ($_SESSION['user_role'] === 'agent') {
    require_once __DIR__ . '/../views/agent.php';
}