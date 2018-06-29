<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');
if (!$user->is_logged_in()) {header('Location: /');exit();}


function pdo_get_memberIDs_from_Members(){
  global $db;
  $ret = array();
  $stmt = $db->prepare('SELECT memberID FROM members;', array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
  $stmt->execute(array());
  while ($row = $stmt->fetch(PDO::FETCH_NUM, PDO::FETCH_ORI_NEXT)) {
    $ret[] = $row[0];
  }
  $stmt = null;
  return $ret;
}

function pdo_list_new_usernames_from_Members(){
  global $db;
  $ret = array();
  $stmt = $db->prepare("SELECT `username` FROM `members` WHERE 1 ORDER BY `memberID` DESC;", array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
  $stmt->execute(array());
  while ($row = $stmt->fetch(PDO::FETCH_NUM, PDO::FETCH_ORI_NEXT)) {
    $ret[] = $row[0];
  }
  $stmt = null;
  return $ret;
}

function pdo_get_memberIDs_from_Profiles(){
  global $db;
  $ret = array();
  $stmt = $db->prepare('SELECT memberID FROM profiles;', array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
  $stmt->execute(array());
  while ($row = $stmt->fetch(PDO::FETCH_NUM, PDO::FETCH_ORI_NEXT)) {
    $ret[] = $row[0];
  }
  $stmt = null;
  return $ret;
}

function pdo_get_memberIDs_from_Avatars(){
  global $db;
  $ret = array();
  $stmt = $db->prepare('SELECT memberID FROM avatars;', array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
  $stmt->execute(array());
  while ($row = $stmt->fetch(PDO::FETCH_NUM, PDO::FETCH_ORI_NEXT)) {
    $ret[] = $row[0];
  }
  $stmt = null;
  return $ret;
}

function pdo_get_memberIDs_from_Backgrounds(){
  global $db;
  $ret = array();
  $stmt = $db->prepare('SELECT memberID FROM backgrounds;', array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
  $stmt->execute(array());
  while ($row = $stmt->fetch(PDO::FETCH_NUM, PDO::FETCH_ORI_NEXT)) {
    $ret[] = $row[0];
  }
  $stmt = null;
  return $ret;
}

function pdo_remove_extras_from_Profiles($mems){
  global $db;
  $pros = pdo_get_memberIDs_from_Profiles();
  $removables = array_diff($pros, $mems);
  if(!is_array($removables) || count($removables)<1)
    return false;
  $db->beginTransaction();
  foreach($removables as $memberID){
    $stmt = $db->prepare('DELETE FROM profiles WHERE memberID = :memberID;', array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
    $stmt->execute(array(':memberID' => $memberID));
    $stmt = null;
  }
  $db->commit();
  return true;
}

function pdo_remove_extras_from_Avatars($mems){
  global $db;
  $avts = pdo_get_memberIDs_from_Avatars();
  $removables = array_diff($avts, $mems);
  if(!is_array($removables) || count($removables)<1)
    return false;
  $db->beginTransaction();
  foreach($removables as $memberID){
    $stmt = $db->prepare('DELETE FROM avatars WHERE memberID = :memberID;', array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
    $stmt->execute(array(':memberID' => $memberID));
    $stmt = null;
  }
  $db->commit();
  return true;
}

function pdo_remove_extras_from_Backgrounds($mems){
  global $db;
  $bkgs = pdo_get_memberIDs_from_Backgrounds();
  $removables = array_diff($bkgs, $mems);
  if(!is_array($removables) || count($removables)<1)
    return false;
  $db->beginTransaction();
  foreach($removables as $memberID){
    $stmt = $db->prepare('DELETE FROM backgrounds WHERE memberID = :memberID;', array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
    $stmt->execute(array(':memberID' => $memberID));
    $stmt = null;
  }
  $db->commit();
  return true;
}

if( $_SESSION['username'] === 'kdodge' ||  $_SESSION['username'] === 'littlebilly' ){
  echo '<form method=get action="/admin/"><input type=hidden name="l" value=""><input type=submit value="LIST MEMBERS"></input></form>'.PHP_EOL;
  if(isset($_GET['c']) ){
    $mems = pdo_get_memberIDs_from_Members();
    pdo_remove_extras_from_Profiles($mems);
    pdo_remove_extras_from_Avatars($mems);
    pdo_remove_extras_from_Backgrounds($mems);
  }else if(isset($_GET['l'])){
    var_dump(pdo_list_new_usernames_from_Members());
  }
}

?>