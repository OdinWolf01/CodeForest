<?php require_once 'includes/config.php'; 
if (!$user->is_logged_in()) {header('Location: /');exit();}

if(isset($_GET['id'])){
    $test_memberID = pdo_get_memberID_from_profileID($_GET['id']);
    if($test_memberID === false){
        header('Location: /');
        echo "Error: memberID";
        exit();
    }
    echo json_encode(pdo_get_profile_info($test_memberID));
}else{
    if(isset($_POST['fullname'])){
        pdo_set_profile_info_fullname($_SESSION['memberID'], $_POST['fullname']);
    }else if(isset($_POST['location'])){
        pdo_set_profile_info_location($_SESSION['memberID'], $_POST['location']);
    }else if(isset($_POST['schooling'])){
        pdo_set_profile_info_schooling($_SESSION['memberID'], $_POST['schooling']);
    }else if(isset($_POST['profession'])){
        pdo_set_profile_info_profession($_SESSION['memberID'], $_POST['profession']);
    }else if(isset($_POST['company'])){
        pdo_set_profile_info_company($_SESSION['memberID'], $_POST['company']);
    }else if(isset($_POST['hobbies'])){
        pdo_set_profile_info_hobbies($_SESSION['memberID'], $_POST['hobbies']);
    }else if(isset($_POST['aboutme'])){
        pdo_set_profile_info_aboutme($_SESSION['memberID'], $_POST['aboutme']);
    }else if(isset($_POST['relationshipstatus'])){
        pdo_set_profile_info_relationshipstatus($_SESSION['memberID'], $_POST['relationshipstatus']);
    }else if(isset($_SESSION['memberID'])){
        echo json_encode(pdo_get_profile_info($_SESSION['memberID']));
    }
}
?>
