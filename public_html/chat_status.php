<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');
if (!$user->is_logged_in()) {exit();}


if(isset($_SESSION['memberID']) && isset($_POST['open'])){
    echo json_encode(pdo_open_chat_with_user($_SESSION['memberID'], $_POST['open']));
}else if(isset($_SESSION['memberID']) && isset($_GET['open'])){
    echo json_encode(pdo_open_chat_with_user($_SESSION['memberID'], $_GET['open']));
}else if(isset($_SESSION['memberID']) && isset($_POST['read'])){
    echo json_encode(pdo_set_chat_read_with_user($_SESSION['memberID'], $_POST['read']));
}else if(isset($_SESSION['memberID']) && isset($_POST['send']) && isset($_POST['message'])){
    pdo_send_chat_to_user($_SESSION['memberID'], $_POST['send'], $_POST['message']);
    echo json_encode(pdo_open_chat_with_user($_SESSION['memberID'], $_POST['send']));
}else if(isset($_SESSION['memberID']) && isset($_POST['clear']) ){
    pdo_clear_chat_to_user($_SESSION['memberID'], $_POST['clear']);
    echo json_encode(pdo_open_chat_with_user($_SESSION['memberID'], $_POST['clear']));
}else if(isset($_SESSION['memberID'])){
    $num_unread = pdo_have_unread_chats($_SESSION['memberID']);
    if($num_unread > 0){
        echo json_encode(pdo_have_unread_chats_with_who($_SESSION['memberID']));
    }else{
        echo json_encode(false);
    }
}
?>