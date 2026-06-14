<?php


session_unset();
session_destroy();

header('Location: /NAYLOTH/public/nayloth');
exit;