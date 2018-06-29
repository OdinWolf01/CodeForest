<?php
exit();
require_once($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');

//collect values from the url
if(!isset($_GET['x']) || !isset($_GET['y']))
	exit();
$memberID = trim($_GET['x']);
$active = trim($_GET['y']);

//if id is number and the active token is not empty carry on
if(is_numeric($memberID) && !empty($active)){

	//update users record set the active column to Yes where the memberID and active value match the ones provided in the array
	$stmt = $db->prepare("UPDATE members SET active = 'Yes' WHERE memberID = :memberID AND active = :active");
	$stmt->execute(array(
		':memberID' => $memberID,
		':active' => $active
	));

	//if the row was updated redirect the user
	if($stmt->rowCount() == 1){

		//redirect to login page
		header('Location: index.php?action=active');
		exit;

	} else {
		echo "Your account could not be activated."; 
	}
	
}

//?x=-1&y=&resend=username
if(isset($_GET['resend'])){
  $email = pdo_get_email_from_username($_GET['resend']);
  if($email === false)
    exit();
  
  $active = pdo_get_active_from_email($email);
  $id = pdo_get_memberID_from_username($_GET['resend']);
  if($id === false || $active === false || $active === 'Yes' || $active === 'No')
    exit();

  //send email
  $to      = $email;
  $subject = "Registration Confirmation";
  $body    = "<p>Thank you for registering at Signature Web Design.</p>
<p>To activate your account, please click on this link: <a href='".DIR."activate.php?x=$id&y=$active'>" .DIR."activate.php?x=$id&y=$active</a></p>
<p>Regards Site Admin</p>";

  $mail = new Mail();
  $mail->setFrom(SITEEMAIL);
  $mail->addAddress($to);
  $mail->subject($subject);
  $mail->body($body);
  $mail->send();

  //redirect to index page
  header('Location: index.php?action=resend');
  exit();

}
?>