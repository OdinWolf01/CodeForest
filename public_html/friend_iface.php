<?php
require_once('includes/config.php');
if (!$user->is_logged_in()) {exit();}

?>
<form action="friend.php" method="post">
<input type=text name=add placeholder='profileID of friend to add.'>
<input type=submit>
</form>
<br />
<form action="friend.php" method="post">
<input type=text name=del placeholder='profileID of friend to delete.'>
<input type=submit>
</form>
<br />
<form action="friend.php" method=get>
<input type=hidden name=friends>
<input type=submit value="get current friends">
</form>
<br />
<form action="friend.php" method=get>
<input type=hidden name=inc_requests>
<input type=submit value="get current friend requests">
</form>
<br />
<form action="friend.php" method=get>
<input type=hidden name=out_requests>
<input type=submit value="get friend requests sent out">
</form>