<?php

// require 'vendor/autoload.php';

require_once 'core/init.php';

use oop\DB;
use oop\Session;
use oop\Config;
use oop\User;

if(Session::exists('home')) {
  echo '<p>' . Session::flash('home') . '</p>';
}

$user = new User;

if($user->isLoggedIn()) {
?>
  <p>Hello <a href="profile.php?user=<?= escape($user->data()->username); ?>"><?= escape($user->data()->username); ?></a>!</p>

  <ul>
    <li><a href="update.php">Update Details</a></li>
    <li><a href="changepassword.php">Change Password</a></li>
    <li><a href="logout.php">Logout</a></li>
  </ul> 
<?php

  if($user->hasPermission('admin')) {
    echo '<p>You are an adminstrator!</p>';
  }


} else {
  echo '<p>You need to <a href="login.php">log in</a> or <a href="register.php">register</a></p>';
}

//echo Session::get(Config::get('session/session_name'));


// $userInsert = DB::getInstance()->update('users', 2, [
//   'password' => 'password23',
//   'name' => 'Dale barret'
//   ]);




// if (!$user->count()) {
//   echo 'No user';
// } else {
//   echo $user->first()->username;
// }
