<?php

/* 
 * SignOut Destroy the session value
 */

session_start();
$_SESSION = array();
unset($_SESSION);
session_destroy();
header("Location:/");
exit;