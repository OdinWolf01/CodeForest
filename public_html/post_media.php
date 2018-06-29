<?php require_once 'includes/config.php'; 
if (!$user->is_logged_in()) {header('Location: /');exit();}

//this will be for handling user storage and retrival of pictures, video, and other media

?>