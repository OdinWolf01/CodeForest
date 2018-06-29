var pinger = {};
pinger['require_post_update'] = false;
function pingerLoop(){
  $.post('/ping.php', {'require_post_update': pinger['require_post_update']}, function(data){
    pinger = data;
  }, 'json');
  setTimeout('pingerLoop();', 5000);
};