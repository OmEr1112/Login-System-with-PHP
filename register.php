<?php
require_once 'core/init.php';

use oop\Input;
use oop\Validate;
use oop\Token;
use oop\Session;
use oop\Hash;
use oop\User;
use oop\Redirect;


if(Input::exists()) {
  if(Token::check(Input::get('token'))) {
    $validate = new Validate();
    $validation = $validate->check($_POST, [
      'username' => [
        'required' => true,
        'min' => 2,
        'max' => 20,
        'unique' => 'users'
      ],
      'password' => [
        'required' => true,
        'min' => 6
      ],
      'password_again' => [
        'required' => true,
        'matches' => 'password'
      ],
      'name' => [
        'required' => true,
        'min' => 2,
        'max' => 50
      ]
    ]);

    if($validation->passed()) {
      $user = new User();
      $salt = Hash::salt(32);
      try {
        $user->create([
          'username' => Input::get('username'),
          'password' => Hash::make(Input::get('password'), $salt),
          'salt' => $salt,
          'name' => Input::get('name'),
          'joined' => date('Y-m-d H:i:s'),
          'group' => 1
        ]);

        Session::flash('home', 'You have been registered and can now log in!');
        Redirect::to('index.php');

      } catch(Exception $e) {
        die($e->getMessage());
      }

      
    } else {
      foreach($validation->errors() as $error) {
        echo $error, '<br>';
      }
    }
  }
}


?>
<form action="" method="post">

  <div class="field">
    <label for="username">Username</label>
    <input type="text" name="username" id="username" value="<?= escape(Input::get('username')); ?>" autocomplete="off">
  </div>

  <div class="field">
    <label for="password">Choose a password</label>
    <input type="password" name="password" id="password">
  </div>

  <div class="field">
    <label for="password_again">Enter your password again</label>
    <input type="password" name="password_again" id="password_again">
  </div>

  <div class="field">
    <label for="name">Enter your name</label>
    <input type="text" name="name" value="<?= escape(Input::get('name')); ?>" id="name">
  </div>

  <input type="hidden" name="token" value="<?= Token::generate(); ?>">
  <input type="submit" value="Register">

</form>