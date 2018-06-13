<?php

namespace oop;


use oop\Session;
use oop\Config;



class Token {
  public static function generate() {
    //print_r(Config::get('session/token_name')['session_name']);
    return Session::put(Config::get('session/token_name'), md5(uniqid()));
  }

  public static function check($token) {
    $tokenName = Config::get('session/token_name');

    if(Session::exists($tokenName) && $token === Session::get($tokenName)) {
      Session::delete($tokenName);
      return true;
    }

    return false;
  }
}