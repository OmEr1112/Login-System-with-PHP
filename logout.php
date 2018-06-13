<?php

require_once 'core/init.php';

use oop\User;
use oop\Redirect;

$user = new User();
$user->logout();

Redirect::to('index.php');