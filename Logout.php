<?php

function destroy_session_and_data() {
    $_SESSION = array();
    setcookie(session_name(), '', time() - 2592000, '/');
    session_destroy();
}

//start session
session_start();

//ini_set('session.gc_maxlifetime', 60 * 60 * 24);

if(isset($_SESSION['username'])) {
    destroy_session_and_data();
    echo "You are now logged out!! <br> BYE!!";
}
else header("location: A5_authenticate1.php");





?>
