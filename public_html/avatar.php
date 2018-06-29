<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/includes/config.php'); 

if(isset($_GET['pic'])){
        header('Content-Type: image/jpeg');
        $img = pdo_get_avatar_from_database($_GET['pic']);
        if($img !== false){
                echo $img;
        }else{
                echo file_get_contents($_SERVER['DOCUMENT_ROOT'].'/vendor/images/default.jpeg');
        }
        exit();
}

if(isset($_FILES[0]["tmp_name"])){
        $typ = exif_imagetype($_FILES[0]["tmp_name"]);
        if($typ == IMAGETYPE_GIF || $typ == IMAGETYPE_JPEG || $typ == IMAGETYPE_PNG){
                $handle = fopen($_FILES[0]["tmp_name"], "r");
                $im = imagecreatefromstring(fread($handle, filesize($_FILES[0]["tmp_name"])));
                fclose($handle);
                $size = 400;
                if(imagesy($im) < $size && imagesx($im) < $size){
                        $thumb = $im;
                }else{
                        $ar = imagesy($im)/imagesx($im);
                        if($ar <= 1.0){
                                $newwidth = $size;
                                $newheight = intval(floor($size*$ar));
                        }else{
                                $newwidth = intval(floor($size/$ar));
                                $newheight = $size;
                        }
                        $thumb = imagecreatetruecolor( $newwidth, $newheight );
                        imagecopyresized($thumb, $im, 0, 0, 0, 0, $newwidth, $newheight, imagesx($im), imagesy($im));
                }
                $tmpfname = tempnam(sys_get_temp_dir(), 'avatar');
                imagejpeg($thumb, $tmpfname);
                $contents = file_get_contents($tmpfname);
                unlink($tmpfname);
                do{
			$uid = bin2hex(openssl_random_pseudo_bytes(8));
                        //$uid = uniqid();
                }while(pdo_count_avatarID($uid));
                pdo_add_avatar_to_database($_SESSION['memberID'], $uid, $contents);
        }
        exit();
}

?>