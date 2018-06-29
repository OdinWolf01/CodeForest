<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');
if (!$user->is_logged_in()) {exit();}

?>
<form action="chat_status.php" method="post">
<input type=text name=open placeholder='profileID of chat to read.'>
<input type=submit>
</form>
<br />
<form action="chat_status.php" method="post">
<input type=text name=send placeholder='profileID of chat to send.'>
<input type=text name=message placeholder='message to send.'>
<input type=submit>
</form>
<br />
<form action="chat_status.php" method="get">
<input type=submit value="how many unread messages">
</form>
