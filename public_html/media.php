<?php 
require_once($_SERVER['DOCUMENT_ROOT'].'/includes/config.php'); 
if (!$user->is_logged_in()) {header('Location: /');exit();}

if(isset($_FILES[0]["tmp_name"]) && isset($_FILES[0]["name"])){
        $typ1 = exif_imagetype($_FILES[0]["tmp_name"]);
        if($typ1 == IMAGETYPE_GIF || $typ1 == IMAGETYPE_JPEG || $typ1 == IMAGETYPE_PNG){
        	$typ2 = '';
        	if($typ1 == IMAGETYPE_GIF)
        		$typ2 = 'gif';
        	else if($typ1 == IMAGETYPE_JPEG)
        		$typ2 = 'jpg';
        	else if($typ1 == IMAGETYPE_PNG)
        		$typ2 = 'png';
                $handle_r = fopen($_FILES[0]["tmp_name"], "r");
                $f_r_len = filesize($_FILES[0]["tmp_name"]);
                $f_r = fread($handle_r, $f_r_len);
                fclose($handle_r);
                $new_url = '';
                $ran1 = '';
                $ran2 = '';
                $ran3 = '';
                $ran4 = '';
                $ran5 = '';
                do{
			$ran1 = bin2hex(openssl_random_pseudo_bytes(1));
			$ran2 = bin2hex(openssl_random_pseudo_bytes(1));
			$ran3 = bin2hex(openssl_random_pseudo_bytes(1));
			$ran4 = bin2hex(openssl_random_pseudo_bytes(1));
			$ran5 = bin2hex(openssl_random_pseudo_bytes(8));
			$new_url = $ran1.'/'.$ran2.'/'.$ran3.'/'.$ran4.'/'.$ran5;
                }while(pdo_is_media_exist_db($new_url) || is_file($_SERVER['DOCUMENT_ROOT'].'/media/'.$ran1.'/'.$ran2.'/'.$ran3.'/'.$ran4.'/'.$ran5));
                if(!is_dir($_SERVER['DOCUMENT_ROOT'].'/media/'.$ran1.'/'.$ran2.'/'.$ran3.'/'.$ran4.'/'))
                	mkdir($_SERVER['DOCUMENT_ROOT'].'/media/'.$ran1.'/'.$ran2.'/'.$ran3.'/'.$ran4.'/', 0700, true);
                $f_w = fopen($_SERVER['DOCUMENT_ROOT'].'/media/'.$new_url, 'w');
		fwrite($f_w, $f_r, $f_r_len);
		fclose($f_w);
		$cksum = dechex(crc32($f_r));
		$ts = time();
		$target = $_SESSION['memberID'];
		if(isset($_POST['target']))
			$target = pdo_get_memberID_from_profileID($_POST['target']);
		$level = '0';
		if(isset($_POST['level']))
			$level = trim($_POST['level']);
                pdo_add_media_link_to_database($_SESSION['memberID'], $target, $new_url, $typ2, $ts, $_FILES[0]["name"], $level, $cksum);
        }else if(false){
        	//video here
        }
        exit();
}else if(isset($_SESSION['memberID']) && isset($_GET['view'])){
	if(!preg_match("|^[0-9a-f]{2}/[0-9a-f]{2}/[0-9a-f]{2}/[0-9a-f]{2}/[0-9a-f]{16}$|", $_GET['view']))
		exit();
	if(!is_file($_SERVER['DOCUMENT_ROOT'].'/media/'.$_GET['view']))
		exit();
	$level = pdo_media_get_level($_GET['view']);
	$filename = $_SERVER['DOCUMENT_ROOT'].'/media/'.$_GET['view'];
	if($level === false){
		exit();
	}else if($level === 'all'){
		$finfo = finfo_open(FILEINFO_MIME_TYPE);
		$mimetype = finfo_file($finfo, $filename);
		finfo_close($finfo);
		header("content-type: ".$mimetype);
		echo file_get_contents($filename);
		exit();
	}else if($level === '0'){
		if(pdo_media_get_owner_from_url($_GET['view']) === $_SESSION['memberID']){
			$finfo = finfo_open(FILEINFO_MIME_TYPE);
			$mimetype = finfo_file($finfo, $filename);
			finfo_close($finfo);
			header("content-type: ".$mimetype);
			echo file_get_contents($filename);
			exit();
		}
	}else if($level === '1'){
		if(pdo_media_get_owner_from_url($_GET['view']) === $_SESSION['memberID'] || 
			pdo_media_get_target_from_url($_GET['view']) === $_SESSION['memberID']){
			$finfo = finfo_open(FILEINFO_MIME_TYPE);
			$mimetype = finfo_file($finfo, $filename);
			finfo_close($finfo);
			header("content-type: ".$mimetype);
			echo file_get_contents($filename);
			exit();
		}
	}
	$dname = $_SERVER['DOCUMENT_ROOT'].'/vendor/images/denied.jpg';
	$finfo = finfo_open(FILEINFO_MIME_TYPE);
	$mimetype = finfo_file($finfo, $dname);
	finfo_close($finfo);
	header("content-type: ".$mimetype);
	echo file_get_contents($dname);
	exit();
}else if(isset($_SESSION['memberID']) && isset($_POST['delete'])){
	if(!preg_match("|^[0-9a-f]{4}/[0-9a-f]{4}/[0-9a-f]{16}$|", $_POST['delete']))
		exit();
	if(!is_file($_SERVER['DOCUMENT_ROOT'].'/media/'.$_POST['delete']))
		exit();
	if(pdo_media_get_owner_from_url($_POST['delete']) === $_SESSION['memberID']){
		pdo_media_delete_url($_POST['delete']);
		unlink($_SERVER['DOCUMENT_ROOT'].'/media/'.$_POST['delete']);
	}
}else if(isset($_SESSION['memberID']) && isset($_POST['id'])){
	if(!empty($_POST['id'])){
		$omem = pdo_get_memberID_from_profileID($_POST['id']);
		if($omem !== false)
			echo json_encode(pdo_get_all_media($_SESSION['memberID'], $omem)); 
	}
}else if(isset($_SESSION['memberID']) && isset($_POST['recent'])){
	if(empty($_POST['recent']))
		echo json_encode(pdo_get_recent_media($_SESSION['memberID']));
	else{
		$omem = pdo_get_memberID_from_profileID($_POST['recent']);
		if($omem !== false)
			echo json_encode(pdo_get_recent_media($omem)); 
	}
}else if(isset($_SESSION['memberID'])){
	echo json_encode(pdo_get_all_media($_SESSION['memberID'], $_SESSION['memberID']));
}

?>