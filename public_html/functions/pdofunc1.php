<?php  

function pdo_add_comments_into_database($memberID, $comments, $targetID, $replypid){
  global $db;
  $timestamp = time();
  if(is_null($replypid)){
    $stmt = $db->prepare('INSERT INTO comments (memberID, targetID, comments, timestamp) VALUES ( :memberID , :targetID , :comments , :timestamp );');
    $stmt->execute(array(':memberID' => $memberID, ':targetID' => $targetID, ':comments' => $comments, ':timestamp' => $timestamp));
  }else{
    $test = pdo_does_original_comment_exist($replypid);
    if($test === true){
      $stmt = $db->prepare('INSERT INTO comments (subpost_id, memberID, targetID, comments, timestamp) VALUES ( :subpost_id, :memberID , :targetID , :comments , :timestamp );');
      $stmt->execute(array(':subpost_id' => $replypid, ':memberID' => $memberID, ':targetID' => $targetID, ':comments' => $comments, ':timestamp' => $timestamp));
    }
  }
}

function pdo_does_original_comment_exist($post_id){
  global $db;
  $ret = NULL;
  $stmt = $db->prepare('SELECT count(*) FROM comments WHERE post_id = :post_id AND subpost_id IS NULL;', array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
  $stmt->execute(array(':post_id' => $post_id));
  while ($row = $stmt->fetch(PDO::FETCH_NUM, PDO::FETCH_ORI_NEXT)) {
    $ret = boolval($row[0]);
  }
  $stmt = null;
  return $ret;
}

function pdo_del_comments_from_database($memberID, $post_id){
        global $db;
        $stmt = $db->prepare('DELETE FROM comments WHERE memberID = :memberID AND post_id = :post_id ;');
        $stmt->execute(array(':memberID' => $memberID, ':post_id' => $post_id));
}

function pdo_comments_from_database($memberID, $offset, $limit){
        global $db;
        $ret = array();
        $stmt = $db->prepare('SELECT timestamp,comments,memberID,post_id,privacy FROM comments WHERE ( memberID = :memberID AND targetID IS NULL AND subpost_id IS NULL ) OR ( targetID = :memberID1 AND subpost_id IS NULL ) ORDER BY timestamp DESC LIMIT :limit OFFSET :offset;', 
                        array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
        $muloffset = $offset * $limit;
        $stmt->execute(array(':memberID' => $memberID, ':memberID1' => $memberID, ':limit' => $limit, ':offset' => strval($muloffset)));
        while ($row = $stmt->fetch(PDO::FETCH_NUM, PDO::FETCH_ORI_NEXT)) {
        	if($row[2] === 'friends' && !pdo_friends_is_user_my_friend($row[2]) && $row[2] !== $_SESSION['memberID']) continue;
                $t = pdo_get_username_from_memberID($row[2]);
                if($t === false)
                    continue;
		$avtrID = pdo_get_avatarID_from_memberID($row[2]);
		if($avtrID === false)
			$avtrID = '';
		$proID = pdo_get_profileID_from_memberID($row[2]);
		if($proID === false)
			$proID = '';
		$likes = pdo_likes_get_count($row[3], 'like', 'post');
		$dislikes = pdo_likes_get_count($row[3], 'dislike', 'post');
		$replies = pdo_comments_get_replies_for_comment($memberID, $row[3], $offset, $limit);
        	$rowary = array('ts' => $row[0], 'text' => htmlentities($row[1],ENT_QUOTES), 'user' => $t, 'pid' => $row[3], 'aid' => $avtrID, 'proid' => $proID, 'likes' => $likes, 'dislikes' => $dislikes, 'replies' => $replies );
                $ret[] = $rowary;
        }
        $stmt = null;
        return $ret;
}

function pdo_comments_get_replies_for_comment($memberID, $post_id, $offset, $limit){
        global $db;
        $ret = array();
        $stmt = $db->prepare('SELECT timestamp,comments,memberID,post_id,privacy FROM comments WHERE ( memberID = :memberID AND targetID IS NULL AND subpost_id = :post_id ) OR ( targetID = :memberID1 AND subpost_id = :post_id1 ) ORDER BY timestamp DESC LIMIT :limit OFFSET :offset;', 
                        array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
        $muloffset = $offset * $limit;
        $stmt->execute(array(':memberID' => $memberID, ':memberID1' => $memberID, ':post_id' => $post_id, ':post_id1' => $post_id, ':limit' => $limit, ':offset' => strval($muloffset)));
        while ($row = $stmt->fetch(PDO::FETCH_NUM, PDO::FETCH_ORI_NEXT)) {
        	if($row[2] === 'friends' && !pdo_friends_is_user_my_friend($row[2]) && $row[2] !== $_SESSION['memberID']) continue;
                $t = pdo_get_username_from_memberID($row[2]);
                if($t === false)
                    continue;
		$avtrID = pdo_get_avatarID_from_memberID($row[2]);
		if($avtrID === false)
			$avtrID = '';
		$proID = pdo_get_profileID_from_memberID($row[2]);
		if($proID === false)
			$proID = '';
		$likes = pdo_likes_get_count($row[3], 'like', 'post');
		$dislikes = pdo_likes_get_count($row[3], 'dislike', 'post');
        	$rowary = array('ts' => $row[0], 'text' => htmlentities($row[1],ENT_QUOTES), 'user' => $t, 'pid' => $row[3], 'aid' => $avtrID, 'proid' => $proID, 'likes' => $likes, 'dislikes' => $dislikes);
                $ret[] = $rowary;
        }
        $stmt = null;
        return $ret;
}

function pdo_add_avatar_to_database($memberID, $avatarID, $imgdata){
        global $db;
        $stmt = $db->prepare('INSERT INTO avatars (memberID, avatarID, imgdata) VALUES ( :memberID , :avatarID , :imgdata ) '.
                        'ON DUPLICATE KEY UPDATE avatarID = :avatarID1, imgdata = :imgdata1;'); 
        // ON DUPLICATE KEY UPDATE imgdata = VALUES( :imgdata )
        $stmt->execute(array(':memberID' => $memberID, ':avatarID' => $avatarID, ':imgdata' => $imgdata,
                ':avatarID1' => $avatarID, ':imgdata1' => $imgdata));
}

function pdo_count_memberID($memberID){
        global $db;
        $ret = 0;
        $stmt = $db->prepare('SELECT count(*) FROM members WHERE memberID = :memberID;', 
                        array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
        $stmt->execute(array(':memberID' => $memberID));
        while ($row = $stmt->fetch(PDO::FETCH_NUM, PDO::FETCH_ORI_NEXT)) {
                $ret = intval($row[0]);
        }
        $stmt = null;
        return $ret;
}

function pdo_get_memberID_from_username($username){
        global $db;
        $ret = false;
        $stmt = $db->prepare('SELECT memberID FROM members WHERE username = :username LIMIT 1;', 
                        array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
        $stmt->execute(array(':username' => $username));
        while ($row = $stmt->fetch(PDO::FETCH_NUM, PDO::FETCH_ORI_NEXT)) {
                $ret = $row[0];
        }
        $stmt = null;
        return $ret;
}

function pdo_get_username_from_memberID($memberID){
        global $db;
        $ret = false;
        $stmt = $db->prepare('SELECT username FROM members WHERE memberID = :memberID LIMIT 1;', 
                        array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
        $stmt->execute(array(':memberID' => $memberID));
        while ($row = $stmt->fetch(PDO::FETCH_NUM, PDO::FETCH_ORI_NEXT)) {
                $ret = $row[0];
        }
        $stmt = null;
        return $ret;
}

function pdo_get_active_from_email($email){
        global $db;
        $ret = false;
        $stmt = $db->prepare('SELECT active FROM members WHERE email = :email LIMIT 1;', 
                        array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
        $stmt->execute(array(':email' => $email));
        while ($row = $stmt->fetch(PDO::FETCH_NUM, PDO::FETCH_ORI_NEXT)) {
                $ret = $row[0];
        }
        $stmt = null;
        return $ret;
}

function pdo_get_email_from_username($username){
        global $db;
        $ret = false;
        $stmt = $db->prepare('SELECT email FROM members WHERE username = :username LIMIT 1;', 
                        array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
        $stmt->execute(array(':username' => $username));
        while ($row = $stmt->fetch(PDO::FETCH_NUM, PDO::FETCH_ORI_NEXT)) {
                $ret = $row[0];
        }
        $stmt = null;
        return $ret;
}

function pdo_get_avatar_from_database($avatarID){
        global $db;
        $ret = false;
        $stmt = $db->prepare('SELECT imgdata FROM avatars WHERE avatarID = :avatarID LIMIT 1;', 
                        array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
        $stmt->execute(array(':avatarID' => $avatarID));
        while ($row = $stmt->fetch(PDO::FETCH_NUM, PDO::FETCH_ORI_NEXT)) {
                $ret = $row[0];
        }
        $stmt = null;
        return $ret;
}

function pdo_get_avatarID_from_memberID($memberID){
        global $db;
        $ret = false;
        $stmt = $db->prepare('SELECT avatarID FROM avatars WHERE memberID = :memberID LIMIT 1;', 
                        array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
        $stmt->execute(array(':memberID' => $memberID));
        while ($row = $stmt->fetch(PDO::FETCH_NUM, PDO::FETCH_ORI_NEXT)) {
                $ret = $row[0];
        }
        $stmt = null;
        return $ret;
}

function pdo_count_avatarID($avatarID){
        global $db;
        $ret = 0;
        $stmt = $db->prepare('SELECT count(*) FROM avatars WHERE avatarID = :avatarID;', 
                        array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
        $stmt->execute(array(':avatarID' => $avatarID));
        while ($row = $stmt->fetch(PDO::FETCH_NUM, PDO::FETCH_ORI_NEXT)) {
                $ret = $row[0];
        }
        $stmt = null;
        return $ret;
}

function pdo_get_avatarID_from_username($username){
        $ret = false;
        $memberID = pdo_get_memberID_from_username($username);
        if($memberID !== false){
                $ret = pdo_get_avatarID_from_memberID($memberID);
        }
        return $ret;
}

function pdo_count_profileID($profileID){
        global $db;
        $ret = 0;
        $stmt = $db->prepare('SELECT count(*) FROM profiles WHERE profileID = :profileID;', 
                        array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
        $stmt->execute(array(':profileID' => $profileID));
        while ($row = $stmt->fetch(PDO::FETCH_NUM, PDO::FETCH_ORI_NEXT)) {
                $ret = $row[0];
        }
        $stmt = null;
        return $ret;
}

function pdo_add_profileID_to_database($memberID, $profileID){
        global $db;
        $stmt = $db->prepare('INSERT INTO profiles (memberID, profileID) VALUES ( :memberID , :profileID ) '.
                        'ON DUPLICATE KEY UPDATE profileID = :profileID1;'); 
        $stmt->execute(array(':memberID' => $memberID, ':profileID' => $profileID, ':profileID1' => $profileID));
}

function pdo_get_memberID_from_profileID($profileID){
        global $db;
        $ret = false;
        $stmt = $db->prepare('SELECT memberID FROM profiles WHERE profileID = :profileID LIMIT 1;', 
                        array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
        $stmt->execute(array(':profileID' => $profileID));
        while ($row = $stmt->fetch(PDO::FETCH_NUM, PDO::FETCH_ORI_NEXT)) {
                $ret = $row[0];
        }
        $stmt = null;
        return $ret;
}

function pdo_get_profileID_from_memberID($memberID){
        global $db;
        $ret = false;
        $stmt = $db->prepare('SELECT profileID FROM profiles WHERE memberID = :memberID LIMIT 1;', 
                        array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
        $stmt->execute(array(':memberID' => $memberID));
        while ($row = $stmt->fetch(PDO::FETCH_NUM, PDO::FETCH_ORI_NEXT)) {
                $ret = $row[0];
        }
        $stmt = null;
        return $ret;
}

function pdo_does_username_have_profileID($username){
        global $db;
        $ret = 0;
        $memberID = pdo_get_memberID_from_username($username);
        if($memberID !== false){
	        $stmt = $db->prepare('SELECT count(*) FROM profiles WHERE memberID = :memberID;', 
	                        array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
	        $stmt->execute(array(':memberID' => $memberID));
	        while ($row = $stmt->fetch(PDO::FETCH_NUM, PDO::FETCH_ORI_NEXT)) {
	                $ret = $row[0];
	        }
	        $stmt = null;
        }
        return $ret;
}

function pdo_get_background_from_database($backgroundID){
        global $db;
        $ret = false;
        $stmt = $db->prepare('SELECT imgdata FROM backgrounds WHERE backgroundID = :backgroundID LIMIT 1;', 
                        array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
        $stmt->execute(array(':backgroundID' => $backgroundID));
        while ($row = $stmt->fetch(PDO::FETCH_NUM, PDO::FETCH_ORI_NEXT)) {
                $ret = $row[0];
        }
        $stmt = null;
        return $ret;
}

function pdo_add_background_to_database($memberID, $backgroundID, $imgdata){
        global $db;
        $stmt = $db->prepare('INSERT INTO backgrounds (memberID, backgroundID, imgdata) VALUES ( :memberID , :backgroundID , :imgdata ) '.
                        'ON DUPLICATE KEY UPDATE backgroundID = :backgroundID1, imgdata = :imgdata1;'); 
        $stmt->execute(array(':memberID' => $memberID, ':backgroundID' => $backgroundID, ':imgdata' => $imgdata,
                ':backgroundID1' => $backgroundID, ':imgdata1' => $imgdata));
}

function pdo_get_backgroundID_from_memberID($memberID){
        global $db;
        $ret = false;
        $stmt = $db->prepare('SELECT backgroundID FROM backgrounds WHERE memberID = :memberID LIMIT 1;', 
                        array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
        $stmt->execute(array(':memberID' => $memberID));
        while ($row = $stmt->fetch(PDO::FETCH_NUM, PDO::FETCH_ORI_NEXT)) {
                $ret = $row[0];
        }
        $stmt = null;
        return $ret;
}

function pdo_count_backgroundID($backgroundID){
        global $db;
        $ret = 0;
        $stmt = $db->prepare('SELECT count(*) FROM backgrounds WHERE backgroundID = :backgroundID;', 
                        array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
        $stmt->execute(array(':backgroundID' => $backgroundID));
        while ($row = $stmt->fetch(PDO::FETCH_NUM, PDO::FETCH_ORI_NEXT)) {
                $ret = $row[0];
        }
        $stmt = null;
        return $ret;
}

function pdo_get_backgroundID_from_username($username){
        $ret = false;
        $memberID = pdo_get_memberID_from_username($username);
        if($memberID !== false){
                $ret = pdo_get_backgroundID_from_memberID($memberID);
        }
        return $ret;
}

function pdo_search_friends_request($username){
	global $db;
        $ret = array();
        $stmt = $db->prepare('SELECT username FROM members WHERE username LIKE :username;', 
                        array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
        $stmt->execute(array(':username' => '%'.$username.'%'));
        while ($row = $stmt->fetch(PDO::FETCH_NUM, PDO::FETCH_ORI_NEXT)) {
                $ret[] = $row[0];
        }
        $stmt = null;
        if(count($ret) == 0)
        	$ret = false;
        return $ret;
}

function pdo_add_new_friend($friender, $friendee){
	global $db;
	if($friender === $friendee)
		return false;
	if(pdo_count_memberID($friender) < 1)
		return false;
	if(pdo_count_memberID($friendee) < 1)
		return false;
        $stmt = $db->prepare('INSERT INTO friends (friender, friendee) VALUES ( :friender , :friendee ) '.
                        'ON DUPLICATE KEY UPDATE friender = :friender1, friendee = :friendee1;', 
                        array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
        $stmt->execute(array(':friender' => $friender, ':friendee' => $friendee, ':friender1' => $friender, ':friendee1' => $friendee ));
        return true;
}

function pdo_del_friend($friender, $friendee){
	global $db;
	if($friender === $friendee)
		return false;
	if(pdo_count_memberID($friender) < 1)
		return false;
	if(pdo_count_memberID($friendee) < 1)
		return false;
        $stmt = $db->prepare('DELETE FROM friends WHERE friender = :friender AND friendee = :friendee ;', 
                        array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
        $stmt->execute(array(':friender' => $friender, ':friendee' => $friendee ));
        return true;
}

function pdo_decline_friend($friender, $friendee){
	global $db;
	if($friender === $friendee)
		return false;
	if(pdo_count_memberID($friender) < 1)
		return false;
	if(pdo_count_memberID($friendee) < 1)
		return false;
        $stmt = $db->prepare('DELETE FROM friends WHERE friender = :friendee AND friendee = :friender ;', 
                        array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
        $stmt->execute(array(':friender' => $friender, ':friendee' => $friendee ));
        return true;
}

function pdo_del_from_friends_bad_memberID($memberID){
	global $db;
	$c = pdo_count_memberID($memberID);
	if($c < 1){
	        $stmt = $db->prepare('DELETE FROM friends WHERE friender = :memberID ;', 
	                        array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
	        $stmt->execute(array(':memberID' => $memberID ));
	        $stmt = $db->prepare('DELETE FROM friends WHERE friendee = :memberID ;', 
	                        array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
	        $stmt->execute(array(':memberID' => $memberID ));
	}
	$stmt = null;
}

function pdo_get_all_friends_array($memberID){
	global $db;
        $ret = array();
        $stmt = $db->prepare('SELECT DISTINCT friends.friendee FROM friends INNER JOIN friends as friends1 WHERE ( friends.friender = friends1.friendee AND friends.friendee = friends1.friender AND ( friends.friender = :memberID ) )',
                        array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
        $stmt->execute(array(':memberID' => $memberID));
        while ($row = $stmt->fetch(PDO::FETCH_NUM, PDO::FETCH_ORI_NEXT)) {
                $ret[$row[0]] = true;
        }
        $stmt = null;
        if($ret !== false)
	        $ret = array_keys($ret);
        if(count($ret) == 0)
        	$ret = false;
	
        return $ret;
}

function pdo_friends_is_user_my_friend($memberID){
  return in_array($memberID, pdo_get_all_friends_array($_SESSION['memberID']));
}

function pdo_get_friend_incomming_requests_array($memberID){
	global $db;
        $ret = array();
        $all_friends = pdo_get_all_friends_array($memberID);
        $stmt = $db->prepare('SELECT DISTINCT friender FROM friends WHERE friendee = :memberID ; ',
                        array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
        $stmt->execute(array(':memberID' => $memberID));
        while ($row = $stmt->fetch(PDO::FETCH_NUM, PDO::FETCH_ORI_NEXT)) {
        	if(in_array($row[0], $all_friends))
        		continue;
                $ret[] = $row[0];
        }
        $stmt = null;
        if(count($ret) == 0)
        	$ret = false;
        return $ret;
}

function pdo_get_friend_outgoing_requests_array($memberID){
	global $db;
        $ret = array();
        $all_friends = pdo_get_all_friends_array($memberID);
        $stmt = $db->prepare('SELECT DISTINCT friendee FROM friends WHERE friender = :memberID ; ',
                        array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
        $stmt->execute(array(':memberID' => $memberID));
        while ($row = $stmt->fetch(PDO::FETCH_NUM, PDO::FETCH_ORI_NEXT)) {
        	if(in_array($row[0], $all_friends))
        		continue;
                $ret[] = $row[0];
        }
        $stmt = null;
        if(count($ret) == 0)
        	$ret = false;
        return $ret;
}

/////////////

function pdo_open_chat_with_user($chatterID, $chateeProID){
	global $db;
	$chateeID = pdo_get_memberID_from_profileID($chateeProID);
	if($chateeID === false)
	    return false;
        $ret = array();
        $stmt = $db->prepare('SELECT * from chat WHERE ( chatter = :chatter AND chatee = :chatee ) OR ( chatee = :chatter1 AND chatter = :chatee1 )  ORDER BY timestamp ASC;',
                        array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
        $stmt->execute(array(':chatter' => $chatterID, ':chatee' => $chateeID, ':chatter1' => $chatterID, ':chatee1' => $chateeID));
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC, PDO::FETCH_ORI_NEXT)) {
        	$row['user'] =  pdo_get_username_from_memberID($row['chatter']);
        	$row['usee'] =  pdo_get_username_from_memberID($row['chatee']);
        	$row['chatter'] = pdo_get_profileID_from_memberID($row['chatter']);
        	$row['chatee'] = pdo_get_profileID_from_memberID($row['chatee']);
        	$row['a1'] = pdo_get_avatarID_from_username($row['user']);
        	$row['a2'] = pdo_get_avatarID_from_username($row['usee']);
        	if($row['a1'] === false)
        	  $row['a1'] = '';
        	if($row['a2'] === false)
        	  $row['a2'] = '';
              	$ret[] = (array)$row;
        }
        $stmt = null;
        return $ret;
}

function pdo_send_chat_to_user($chatterID, $chateeProID, $message){
	global $db;
	$chateeID = pdo_get_memberID_from_profileID($chateeProID);
	if($chateeID === false)
	    return false;
        $ret = array();
        $t = time();
        $stmt = $db->prepare('INSERT INTO chat (chatter, chatee, message, isRead, timestamp) VALUES ( :chatter , :chatee , :message , 0, :timestamp ) ;',
                        array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
        $stmt->execute(array(':chatter' => $chatterID, ':chatee' => $chateeID, ':message' => $message, ':timestamp' => $t));
        return true;
}

function pdo_set_chat_read_with_user($chatterID, $chateeProID){
	global $db;
	$chateeID = pdo_get_memberID_from_profileID($chateeProID);
	if($chateeID === false)
	    return false;
        $stmt = $db->prepare('UPDATE chat SET isRead = 1 WHERE chatee = :chatter AND chatter = :chatee;',
                        array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
        $stmt->execute(array( ':chatter' => $chatterID, ':chatee' => $chateeID ));
        return true;
}

function pdo_clear_chat_to_user($chatterID, $chateeProID){
	global $db;
	$chateeID = pdo_get_memberID_from_profileID($chateeProID);
	if($chateeID === false)
	    return false;
        $ret = array();
        $t = time();
        $stmt = $db->prepare('DELETE FROM chat WHERE ( chatter = :chatter AND chatee = :chatee ) OR ( chatter = :chatee1 AND chatee = :chatter1 ) ;',
                        array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
        $stmt->execute(array(':chatter' => $chatterID, ':chatee' => $chateeID, ':chatter1' => $chatterID, ':chatee1' => $chateeID ));
        return true;
}

function pdo_chat_set_isread($memberID, $chat_id){
	global $db;
        $stmt = $db->prepare('UPDATE isRead = 1 WHERE chat_id = :chat_id AND chatter = :chatter;',
                        array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
        $stmt->execute(array(':chat_id' => $chat_id, ':chatter' => $memberID));
}

function pdo_have_unread_chats_with_who($memberID){
	global $db;
        $ret = array();
        $stmt = $db->prepare('SELECT chatter from chat WHERE chatee = :memberID AND isRead = 0 ;',
                        array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
        $stmt->execute(array(':memberID' => $memberID));
        while ($row = $stmt->fetch(PDO::FETCH_NUM, PDO::FETCH_ORI_NEXT)) {
              	$ret[] = pdo_get_profileID_from_memberID($row[0]);
        }
        $stmt = null;
        if(count($ret) == 0)
            $ret = false;
        return $ret;
}

function pdo_have_chats_with_who($memberID){
	global $db;
        $ret = array();
        $stmt = $db->prepare('SELECT chatter from chat WHERE chatee = :memberID ;',
                        array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
        $stmt->execute(array(':memberID' => $memberID));
        while ($row = $stmt->fetch(PDO::FETCH_NUM, PDO::FETCH_ORI_NEXT)) {
              	$ret[] = pdo_get_profileID_from_memberID($row[0]);
        }
        $stmt = null;
        if(count($ret) == 0)
            $ret = false;
        return $ret;
}

function pdo_have_unread_chats($memberID){
	global $db;
        $ret = 0;
        $stmt = $db->prepare('SELECT count(*) from chat WHERE chatee = :memberID AND isRead = 0 ;',
                        array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
        $stmt->execute(array(':memberID' => $memberID));
        while ($row = $stmt->fetch(PDO::FETCH_NUM, PDO::FETCH_ORI_NEXT)) {
              	$ret = intval($row[0]);
        }
        $stmt = null;
        return $ret;
}

///////////

function pdo_get_profile_info($memberID){
	global $db;
        $ret = array();
        $ret['username'] = '';
        $ret['fullname'] = '';
        $ret['location'] = '';
        $ret['schooling'] = '';
        $ret['profession'] = '';
        $ret['company'] = '';
        $ret['hobbies'] = '';
        $ret['aboutme'] = '';
        $ret['relationshipstatus'] = '';
        $ret['acctCreate'] = '';
        $stmt = $db->prepare('SELECT * FROM profile_info WHERE memberID = :memberID ; ',
                        array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
        $stmt->execute(array(':memberID' => $memberID));
        //while ($row = $stmt->fetch(PDO::FETCH_NUM, PDO::FETCH_ORI_NEXT)) {
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC, PDO::FETCH_ORI_NEXT)) {
        	if(isset($row['fullname']))
	        $ret['fullname'] = $row['fullname'];
        	if(isset($row['location']))
	        $ret['location'] = $row['location'];
        	if(isset($row['schooling']))
	        $ret['schooling'] = $row['schooling'];
        	if(isset($row['profession']))
	        $ret['profession'] = $row['profession'];
        	if(isset($row['company']))
	        $ret['company'] = $row['company'];
        	if(isset($row['hobbies']))
	        $ret['hobbies'] = $row['hobbies'];
        	if(isset($row['aboutme']))
	        $ret['aboutme'] = $row['aboutme'];
        	if(isset($row['relationshipstatus']))
	        $ret['relationshipstatus'] = $row['relationshipstatus'];
        }
        $stmt = null;
        $stmt = $db->prepare('SELECT acctCreate,username FROM members WHERE memberID = :memberID ; ',
                        array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
        $stmt->execute(array(':memberID' => $memberID));
        while ($row = $stmt->fetch(PDO::FETCH_NUM, PDO::FETCH_ORI_NEXT)) {
		$ret['acctCreate'] = $row[0];
        	$ret['username'] = $row[1];
        }
        $stmt = null;
        return $ret;
}

function pdo_set_profile_info_fullname($memberID, $fullname){
	global $db;
        $ret = false;
        $stmt = $db->prepare('INSERT INTO profile_info (memberID, fullname) VALUES ( :memberID , :fullname ) ON DUPLICATE KEY UPDATE memberID = :memberID1, fullname = :fullname1;',
                        array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
        $stmt->execute(array(':memberID' => $memberID, ':fullname' => $fullname, ':memberID1' => $memberID, ':fullname1' => $fullname));
}

function pdo_set_profile_info_location($memberID, $location){
	global $db;
        $ret = false;
        $stmt = $db->prepare('INSERT INTO profile_info (memberID, location) VALUES ( :memberID , :location ) ON DUPLICATE KEY UPDATE memberID = :memberID1, location = :location1;',
                        array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
        $stmt->execute(array(':memberID' => $memberID, ':location' => $location, ':memberID1' => $memberID, ':location1' => $location));
}

function pdo_set_profile_info_schooling($memberID, $schooling){
	global $db;
        $ret = false;
        $stmt = $db->prepare('INSERT INTO profile_info (memberID, schooling) VALUES ( :memberID , :schooling ) ON DUPLICATE KEY UPDATE memberID = :memberID1, schooling = :schooling1;',
                        array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
        $stmt->execute(array(':memberID' => $memberID, ':schooling' => $schooling, ':memberID1' => $memberID, ':schooling1' => $schooling));
}

function pdo_set_profile_info_profession($memberID, $profession){
	global $db;
        $ret = false;
        $stmt = $db->prepare('INSERT INTO profile_info (memberID, profession) VALUES ( :memberID , :profession ) ON DUPLICATE KEY UPDATE memberID = :memberID1, profession = :profession1;',
                        array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
        $stmt->execute(array(':memberID' => $memberID, ':profession' => $profession, ':memberID1' => $memberID, ':profession1' => $profession));
}

function pdo_set_profile_info_company($memberID, $company){
	global $db;
        $ret = false;
        $stmt = $db->prepare('INSERT INTO profile_info (memberID, company) VALUES ( :memberID , :company ) ON DUPLICATE KEY UPDATE memberID = :memberID1, company = :company1;',
                        array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
        $stmt->execute(array(':memberID' => $memberID, ':company' => $company, ':memberID1' => $memberID, ':company1' => $company));
}

function pdo_set_profile_info_hobbies($memberID, $hobbies){
	global $db;
        $ret = false;
        $stmt = $db->prepare('INSERT INTO profile_info (memberID, hobbies) VALUES ( :memberID , :hobbies ) ON DUPLICATE KEY UPDATE memberID = :memberID1, hobbies = :hobbies1;',
                        array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
        $stmt->execute(array(':memberID' => $memberID, ':hobbies' => $hobbies, ':memberID1' => $memberID, ':hobbies1' => $hobbies));
}

function pdo_set_profile_info_aboutme($memberID, $aboutme){
	global $db;
        $ret = false;
        $stmt = $db->prepare('INSERT INTO profile_info (memberID, aboutme) VALUES ( :memberID , :aboutme ) ON DUPLICATE KEY UPDATE memberID = :memberID1, aboutme = :aboutme1;',
                        array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
        $stmt->execute(array(':memberID' => $memberID, ':aboutme' => $aboutme, ':memberID1' => $memberID, ':aboutme1' => $aboutme));
}

function pdo_set_profile_info_relationshipstatus($memberID, $relationshipstatus){
	global $db;
        $ret = false;
        $stmt = $db->prepare('INSERT INTO profile_info (memberID, relationshipstatus) VALUES ( :memberID , :relationshipstatus ) ON DUPLICATE KEY UPDATE memberID = :memberID1, relationshipstatus = :relationshipstatus1;',
                        array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
        $stmt->execute(array(':memberID' => $memberID, ':relationshipstatus' => $relationshipstatus, ':memberID1' => $memberID, ':relationshipstatus1' => $relationshipstatus));
}

function pdo_get_theme($memberID){
	global $db;
        $ret = false;
        $stmt = $db->prepare('SELECT theme FROM themes WHERE memberID = :memberID ; ',
                        array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
        $stmt->execute(array(':memberID' => $memberID));
        while ($row = $stmt->fetch(PDO::FETCH_NUM, PDO::FETCH_ORI_NEXT)) {
        	$ret = $row[0];
        }
        $stmt = null;
        return $ret;
}

function pdo_set_theme($memberID, $theme){
	global $db;
        $ret = false;
        $stmt = $db->prepare('INSERT INTO themes (memberID, theme) VALUES ( :memberID , :theme ) ON DUPLICATE KEY UPDATE memberID = :memberID1, theme = :theme1;',
                        array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
        $stmt->execute(array(':memberID' => $memberID, ':theme' => $theme, ':memberID1' => $memberID, ':theme1' => $theme));
}

function pdo_set_ping($memberID){
	global $db;
        $ret = false;
        $time = time();
        $stmt = $db->prepare('INSERT INTO pings (memberID, time) VALUES ( :memberID , :time ) ON DUPLICATE KEY UPDATE memberID = :memberID1, time = :time1;',
                        array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
        $stmt->execute(array(':memberID' => $memberID, ':time' => $time, ':memberID1' => $memberID, ':time1' => $time));
}

function pdo_get_single_ping($memberID){
	global $db;
        $ret = false;
        $stmt = $db->prepare('SELECT time FROM pings WHERE memberID = :memberID ; ',
                        array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
        $stmt->execute(array(':memberID' => $memberID));
        while ($row = $stmt->fetch(PDO::FETCH_NUM, PDO::FETCH_ORI_NEXT)) {
        	$ret = $row[0];
        }
        $stmt = null;
        return $ret;
}

function pdo_get_online_friends($memberID){
	global $db, $pinger_delay;
       	$ret = array();
	$db->beginTransaction();
	$friends_ary = pdo_get_all_friends_array($memberID);
	if(!is_array($friends_ary))
		return $ret;
	foreach($friends_ary as $friend){
	        $stmt = $db->prepare('SELECT time FROM pings WHERE memberID = :friend ; ',
	               	        array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
	       	$stmt->execute(array(':friend' => $friend));
	        while ($row = $stmt->fetch(PDO::FETCH_NUM, PDO::FETCH_ORI_NEXT)) {
	        	if(time() - $row[0] < 2*$pinger_delay + 1){
		       		$ret[] = array('u' => pdo_get_username_from_memberID($friend), 'p' => pdo_get_profileID_from_memberID($friend) , 'av' => pdo_get_avatarID_from_memberID($friend));
	        	}
	        }
	        $stmt = null;
	}
        $db->commit();
        return $ret;
}

function pdo_is_media_exist_db($url){
        global $db;
        $ret = 0;
        $stmt = $db->prepare('SELECT count(*) FROM media WHERE url = :url ;', 
                        array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
        $stmt->execute(array(':url' => $url));
        while ($row = $stmt->fetch(PDO::FETCH_NUM, PDO::FETCH_ORI_NEXT)) {
                $ret = $row[0];
        }
        $stmt = null;
        return $ret;

}

function pdo_add_media_link_to_database($owner, $target, $url, $typ, $ts, $filename, $level, $cksum){
	global $db;
	if($target === false)
		return false;
        $ret = false;
        $stmt = $db->prepare('INSERT INTO media (owner, target, url, type, timestamp, filename, level, cksum) VALUES ( :owner , :target , :url , :type , :timestamp, :filename, :level, :cksum );',
                        array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
        $stmt->execute(array(':owner' => $owner, ':target' => $target, ':url' => $url, ':type' => $typ, ':timestamp' => $ts, ':filename' => $filename, ':level' => $level, ':cksum' => $cksum ));
	return true;
}

function pdo_get_all_media($owner, $target){
	global $db;
        $ret = array();
        $stmt = $db->prepare('SELECT url,filename,cksum FROM media WHERE owner = :owner AND target = :target ; ',
                        array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
        $stmt->execute(array(':owner' => $owner, ':target' => $target));
        while ($row = $stmt->fetch(PDO::FETCH_NUM, PDO::FETCH_ORI_NEXT)) {
        	$ret[] = array('url' =>$row[0], 'filename' => htmlentities($row[1], ENT_QUOTES), 'cksum' => $row[2]);
        }
        $stmt = null;
        return $ret;
}

function pdo_get_all_target_media($target){
	global $db;
        $ret = array();
        $stmt = $db->prepare('SELECT url,filename,cksum FROM media WHERE target = :target ; ',
                        array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
        $stmt->execute(array(':target' => $target));
        while ($row = $stmt->fetch(PDO::FETCH_NUM, PDO::FETCH_ORI_NEXT)) {
        	$ret[] = array('url' =>$row[0], 'filename' => htmlentities($row[1], ENT_QUOTES), 'cksum' => $row[2]);
        }
        $stmt = null;
        return $ret;

}

function pdo_media_get_level($url){
	global $db;
        $ret = false;
        $stmt = $db->prepare('SELECT level FROM media WHERE url = :url ; ',
                        array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
        $stmt->execute(array(':url' => $url));
        while ($row = $stmt->fetch(PDO::FETCH_NUM, PDO::FETCH_ORI_NEXT)) {
        	$ret = $row[0];
        }
        $stmt = null;
        return $ret;
}

function pdo_media_get_owner_from_url($url){
	global $db;
        $ret = false;
        $stmt = $db->prepare('SELECT owner FROM media WHERE url = :url ; ',
                        array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
        $stmt->execute(array(':url' => $url));
        while ($row = $stmt->fetch(PDO::FETCH_NUM, PDO::FETCH_ORI_NEXT)) {
        	$ret = $row[0];
        }
        $stmt = null;
        return $ret;
}

function pdo_media_get_target_from_url($url){
	global $db;
        $ret = false;
        $stmt = $db->prepare('SELECT target FROM media WHERE url = :url ; ',
                        array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
        $stmt->execute(array(':url' => $url));
        while ($row = $stmt->fetch(PDO::FETCH_NUM, PDO::FETCH_ORI_NEXT)) {
        	$ret = $row[0];
        }
        $stmt = null;
        return $ret;
}

function pdo_media_delete_url($url){
	global $db;
        $ret = false;
        $stmt = $db->prepare('DELETE FROM media WHERE url = :url;',
                        array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
        $stmt->execute(array(':url' => $url));
	return true;
}

function pdo_get_recent_media($target){
	global $db;
        $ret = array();
        $stmt = $db->prepare('SELECT url,filename,cksum FROM media WHERE target = :target ORDER BY timestamp DESC LIMIT 6 OFFSET 0 ; ',
                        array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
        $stmt->execute(array(':target' => $target));
        while ($row = $stmt->fetch(PDO::FETCH_NUM, PDO::FETCH_ORI_NEXT)) {
        	$ret[] = array('url' =>$row[0], 'filename' => htmlentities($row[1], ENT_QUOTES), 'cksum' => $row[2]);
        }
        $stmt = null;
        return $ret;
}

function pdo_notifications_get_post($memberID){
	global $db;
        $ret = false;
        $stmt = $db->prepare('SELECT post FROM notifications WHERE memberID = :memberID ; ',
                        array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
        $stmt->execute(array(':memberID' => $memberID));
        while ($row = $stmt->fetch(PDO::FETCH_NUM, PDO::FETCH_ORI_NEXT)) {
        	$ret = $row[0];
        }
        $stmt = null;
        if($ret === false){
	        pdo_notifications_set_post($memberID, 0);
	        return 0;
	}
        return $ret;
}

function pdo_notifications_set_post($memberID, $post){
	global $db;
        $stmt = $db->prepare('INSERT INTO notifications (memberID, post) VALUES ( :memberID, :post ) ON DUPLICATE KEY UPDATE memberID = :memberID1, post = :post1; ', array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
        $stmt->execute(array(':memberID' => $memberID, ':post' => $post, ':memberID1' => $memberID, ':post1' => $post ));
	return true;
}

function pdo_get_notifications_menu_list($memberID){
  global $db;
  $ret = array();
  $db->beginTransaction();
  $friends_ary = pdo_get_all_friends_array($memberID);
  if(!is_array($friends_ary))
    return $ret;
  foreach($friends_ary as $friend){
    $stmt = $db->prepare('SELECT message,timestamp FROM chat WHERE chatter = :chatter AND chatee = :chatee ORDER BY timestamp DESC LIMIT 1;', array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
    $stmt->execute(array(':chatter' => $friend, ':chatee' => $memberID));
    while ($row = $stmt->fetch(PDO::FETCH_NUM, PDO::FETCH_ORI_NEXT))
      $ret[] = array('u' => pdo_get_username_from_memberID($friend), 'p' => pdo_get_profileID_from_memberID($friend) , 'av' => pdo_get_avatarID_from_memberID($friend), 'msg' => $row[0], 't' => $row[1]);
    $stmt = null;
  }
  $db->commit();
  return $ret;
}

function pdo_likes_get_count($ref, $type, $src){
  global $db;
  $ret = 0;
  $stmt = $db->prepare('SELECT count(*) FROM likes WHERE ref = :ref AND type = :type AND src = :src ; ',
    array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
  $stmt->execute(array(':ref' => $ref, ':type' => $type, ':src' => $src));
  while ($row = $stmt->fetch(PDO::FETCH_NUM, PDO::FETCH_ORI_NEXT)) {
    $ret = $row[0];
  }
  $stmt = null;
  return $ret;
}

function pdo_likes_like($memberID, $ref, $type, $src){
  global $db;
  $timestamp = time();
  $stmt = $db->prepare('INSERT INTO likes (memberID, ref, type, src, timestamp) VALUES ( :memberID, :ref, :type, :src, :timestamp ) ON DUPLICATE KEY UPDATE memberID = :memberID1, ref = :ref1, type = :type1, src = :src1, timestamp = :timestamp1 ;', 
    array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
  $stmt->execute(array(':memberID' => $memberID, ':ref' => $ref, ':type' => $type, ':src' => $src, ':timestamp' => $timestamp, ':memberID1' => $memberID, ':ref1' => $ref, ':type1' => $type, ':src1' => $src, ':timestamp1' => $timestamp ));
  return true;
}

function pdo_likes_like_exist($memberID, $ref, $type, $src){
  global $db;
  $ret = 0;
  $stmt = $db->prepare('SELECT count(*) FROM likes WHERE memberID = :memberID AND ref = :ref AND type = :type AND src = :src ;', 
    array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
  $stmt->execute(array(':memberID' => $memberID, ':ref' => $ref, ':type' => $type, ':src' => $src ));
  while ($row = $stmt->fetch(PDO::FETCH_NUM, PDO::FETCH_ORI_NEXT)) {
    $ret = $row[0];
  }
  $stmt = null;
  return $ret;
}

function pdo_likes_unlike($memberID, $ref, $type, $src){
  global $db;
  $stmt = $db->prepare('DELETE FROM likes WHERE memberID = :memberID AND ref = :ref AND type = :type AND src = :src ;', 
    array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
  $stmt->execute(array(':memberID' => $memberID, ':ref' => $ref, ':type' => $type, ':src' => $src));
  return true;
}
?>