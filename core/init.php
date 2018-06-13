<?php

require 'vendor/autoload.php';

use oop\Config;
use oop\Cookie;
use oop\Session;
use oop\DB;
use oop\User;

session_start();

$GLOBALS['config'] = array(
  'mysql' => array(
    'host' => '127.0.0.1',
    'username' => 'root',
    'password' => '',
    'db' => 'loginsys'
  ),
  'remember' => array(
    'cookie_name' => 'hash',
    'cookie_expiry' => 604800
  ),
  'session' => array(
    'session_name' => 'user',
    'token_name' => 'token'
  )
);

require_once 'functions/sanitize.php';

if(Cookie::exists(Config::get('remember/cookie_name')) && !Session::exists(Config::get('session/session_name'))) {
  $hash = Cookie::get(Config::get('remember/cookie_name'));
  $hashCheck = DB::getInstance()->get('users_session', ['hash', '=', $hash]);

  if($hashCheck->count()) {
    $user = new User($hashCheck->first()->user_id);
    $user->login();
  }
}
