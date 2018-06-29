<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');
if (!$user->is_logged_in()) {header('Location: /'); exit();}
if(isset($_POST['q'])&& !empty($_POST['q'])){
	$ary = pdo_search_friends_request($_POST['q']);
	if($ary !== false){
		$ret = array();
		foreach($ary as $u){
			$memberID = pdo_get_memberID_from_username($u);
			if($memberID !== false){
				$proid = pdo_get_profileID_from_memberID($memberID);
				if($proid !== false){
					$avatarID = pdo_get_avatarID_from_memberID($memberID);
					$row = array('u' => $u, 'p' => $proid, 'av' => ($avatarID !== false)?$avatarID:'');
					$ret[] = $row;
				}
			}
		}
		echo json_encode($ret);
	}
}
exit();
?>