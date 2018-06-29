<?php require_once 'includes/config.php';

if (!$user->is_logged_in()) {exit();}

// INFO:
//    $_POST['target'] is the profileID of the user that you want to send the post too, blank or non-existant is posted to self
//    $_POST['mssg_body'] is the contents of the post
//    $_GET['index'] is an integer for how many pages back you want to retrieve
//    $_GET['view'] is the profileID of the user that you want to look at, blank or non-existant is to view self
//    $_POST['delete'] is the post_id value of the post to be deleted.

if(isset($_POST['delete'])){
	if(is_numeric($_POST['delete'])){
		$dnum = $_POST['delete'] + 0;
		if(is_int($dnum)){
			pdo_del_comments_from_database($_SESSION['memberID'], $dnum);
			exit();
		}
	}
}

$targetmemberID = NULL;
if(isset($_POST['target'])){
	$targetID = pdo_get_memberID_from_profileID($_POST['target']);
	if($targetID !== false){
		$targetmemberID = $targetID;
	}
}

$replypid = NULL;
if(isset($_POST['reply'])){
  if(is_numeric($_POST['reply'])){
    $cnum = $_POST['reply'] + 0;
    if(is_int($cnum)){
      $replypid = $cnum;
    }else{
      header('Location: /');
      exit();
    }
  }else{
    header('Location: /');
    exit();
  }
}


if (isset($_POST['mssg_body']) && !empty($_POST['mssg_body'])) {
	pdo_add_comments_into_database($_SESSION['memberID'], $_POST['mssg_body'], $targetmemberID, $replypid);
	if(!is_null($targetmemberID))
		pdo_notifications_set_post($targetmemberID, 1);
}

$commentsindex = 0;

if (isset($_GET['index'])) {
	if(is_numeric($_GET['index'])){
		$cnum = $_GET['index'] + 0;
		if(is_int($cnum)){
			$commentsindex = $cnum;
		}else{
			header('Location: /');
			exit();
		}
	}else{
		header('Location: /');
		exit();
	}
}

$memberID_to_retrieve = $_SESSION['memberID'];
if (isset($_GET['view']) && !empty($_GET['view'])) {
	$other_memberID = pdo_get_memberID_from_profileID($_GET['view']);
	if ($other_memberID === false) {
		header('Location: /');
		exit();
	}
	$memberID_to_retrieve = $other_memberID;
}

$c = pdo_comments_from_database($memberID_to_retrieve, $commentsindex, 30);

if (!empty($c)) {
    echo json_encode($c);
}
?>
