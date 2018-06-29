<?php
require_once 'includes/config.php'; 
if (!$user->is_logged_in()) {header('Location: /');exit();}

function processIdsIntoProfileIDs($input){
	$a = array();
	if(!is_array($input))
		return;
	foreach($input as $id){
		$u = pdo_get_username_from_memberID($id);
		$p = pdo_get_profileID_from_memberID($id);
		$av = pdo_get_avatarID_from_memberID($id);
		if($u !== false && $p !== false ){
			$a[] = array('u' => $u, 'p' => $p, 'av' => ($av !== false)?$av:'');
		}else{
			pdo_del_from_friends_bad_memberID($id);
		}
	}
	echo json_encode($a);
}

if(isset($_SESSION['memberID']) && isset($_POST['add'])){
	$other_memberID = pdo_get_memberID_from_profileID($_POST['add']);
	if($other_memberID === false || pdo_add_new_friend($_SESSION['memberID'], $other_memberID) === false){
		echo 'Error Adding Friend';
	}
}else if(isset($_SESSION['memberID']) && isset($_POST['del'])){
	$other_memberID = pdo_get_memberID_from_profileID($_POST['del']);
	if($other_memberID === false || pdo_del_friend($_SESSION['memberID'], $other_memberID) === false){
		echo 'Error Deleting Friend';
	}
}else if(isset($_SESSION['memberID']) && isset($_POST['decline'])){
	$other_memberID = pdo_get_memberID_from_profileID($_POST['decline']);
	if($other_memberID === false || pdo_decline_friend($_SESSION['memberID'], $other_memberID) === false){
		echo 'Error Declining Friend';
	}
}else if(isset($_SESSION['memberID']) && isset($_GET['inc_requests'])){
	processIdsIntoProfileIDs(pdo_get_friend_incomming_requests_array($_SESSION['memberID']));
}else if(isset($_SESSION['memberID']) && isset($_GET['out_requests'])){
	processIdsIntoProfileIDs(pdo_get_friend_outgoing_requests_array($_SESSION['memberID']));
}else if(isset($_SESSION['memberID']) && isset($_GET['friends'])){
	if(empty($_GET['friends'])){
		processIdsIntoProfileIDs(pdo_get_all_friends_array($_SESSION['memberID']));
	}else{
		$oid = pdo_get_memberID_from_profileID($_GET['friends']);
		if($oid !== false){
			processIdsIntoProfileIDs(pdo_get_all_friends_array($oid));
		}
	}
}
?>