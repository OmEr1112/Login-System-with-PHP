<?php

require_once 'core/init.php';

use oop\Input;
use oop\Redirect;
use oop\User;

if(!$username = Input::get('user')) {
  Redirect::to(404);
} else {
  $user = new User($username);
  if(!$user->exists()) {
    Redirect::to(404);
  } else {
  $data = $user->data();
  }
  ?>

  <h3>Hi, <?= escape($data->username); ?></h3>
  <p>Full name: <?= escape($data->name); ?></p>

<?php

}