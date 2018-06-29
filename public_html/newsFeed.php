<?php
require('includes/config.php');

if(isset($_POST['addnews'])){
	$news = filter_input(INPUT_POST, 'news', FILTER_SANITIZE_SPECIAL_CHARS);
	$name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_SPECIAL_CHARS);
	$sql = "INSERT INTO news (description, name, date) VALUES ('".$news."', '".$name."', '".date('Y-m-d H:i:s')."')";
	mysql_query($sql);
}
/**
* Preparing and getting response for latest feed items.
**/
if(isset($_POST['latest_news_time'])){
	$sql = "SELECT * FROM news ";  
	$sql .= "WHERE date > '".$_POST['latest_news_time']."' ";
	$sql .= "ORDER BY date DESC";
	$resource = mysql_query($sql);
	$current_time = $_POST['latest_news_time'];
	$item = mysql_fetch_assoc($resource);
	$last_news_time = $item['date'];
	while ($last_news_time < $current_time) {
		usleep(1000); //giving some rest to CPU
		$resource = mysql_query($sql);
		$item = mysql_fetch_assoc($resource);
		$last_news_time = $item['date'];
		if(!$item['date']){
			$last_news_time = -1;
		}
	}
	?>
	<li class="response" id="<?php echo $item['date'] ?>">
		<span class="feedtext"><?php echo $item['description'] ?> was added by <b><?php echo $item['name'] ?></b></span>
	</li>
	<?php
	exit;
}

$sql = "SELECT * FROM news ORDER BY date DESC LIMIT 0, 10";
if(isset($_POST['last_time'])){
	$sql = "SELECT * FROM news WHERE date < '".$_POST['last_time']."' ORDER BY date DESC LIMIT 0, 10";
}
$resource = mysql_query($sql);
$news = array();
while($row = mysql_fetch_assoc($resource)){
	$news[] = $row;
}

?>


