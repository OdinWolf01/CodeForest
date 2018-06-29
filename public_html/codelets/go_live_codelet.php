<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');
if (!$user->is_logged_in()) {echo 'Not Logged In'; exit();}
$test_req = require_once($_SERVER['DOCUMENT_ROOT'].'/layout/head_min.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/includes/pinger.php');

if( $test_req === 1){
echo '</head>'.PHP_EOL;
}
?>


<!--




<video autoplay></video>
<img src="">
<canvas style="display:none;"></canvas>








<script type="text/javascript">
	   var video = document.querySelector('video');
  var canvas = document.querySelector('canvas');
  var ctx = canvas.getContext('2d');
  var image = document.querySelector('img');
  navigator.getUserMedia = navigator.getUserMedia || navigator.webkitGetUserMedia || navigator.mozGetUserMedia;

  window.URL = window.URL || window.webkitURL;


  function snapshot() {
      var cw = video.clientWidth;
      var ch = video.clientHeight;
      ctx.drawImage(video, 0, 0, cw, ch, 0, 0, cw / 2, ch / 3);
      image.src = canvas.toDataURL();
      image.height = ch;
      image.width = cw;
  }

  video.addEventListener('click', snapshot, false);

if (navigator.getUserMedia) {
    navigator.getUserMedia({ video: true,audio:false},
      function(stream) {
         video.src = window.URL.createObjectURL(stream);
         video.onloadedmetadata = function(e) {
           video.play();
         };
      },
      function(err) {
         console.log("The following error occured: " + err.name);
      }
   );
} else {
   console.log("getUserMedia not supported");
}
</script>




-->





















<!--
	<style type="text/css">
          wrapper{
		display: grid;
		grid-template-columns: repeat(3,1fr);
		grid-gap:5px;
		}

		video, canvas, .image4vid {
			width: 400px;
			height: 400px;
			background-color: black;

		}

         
	</style>
<div class="wrapper">
  <div>
  <h1>Video from webCam</h1>
  <video ></video>

  </div>

  
  <div>
  <h1>Video on Canvas</h1>
  <canvas></canvas>
  </div>
  
  <div>
   <h1> Video from Server</h1>
  <img class="image4vid" alt="" />
  </div>
 </div>


 <script >
 
(function(){
	//var video = document.querySelector('video');
	//var canvas = document.querySelector('canvas');
	//var img = document.querySelector('img');
	var context=canvas.getContext('2d');
	var url = "ws://localhost:8080/WScams/wsServer";
	
	var socket = new WebSocket(url);
	
	socket.onopen=onOpen;
	function onOpen(event){
		
	}

	var constraints={
			video:true,
			audio:false //true
	};
	
	navigator.mediaDevices.getUserMedia(constraints).then(function(stream){
		video.srcObject=stream;
		video.play();
	}).catch(function(err){
		
	});

	 setInterval(main ,3000);
	
	
    function main(){
    	drawCanvas();
    	readCanvas();
    }
	
	function drawCanvas(){
		
		context.drawImage(video,0,0,canvas.width, canvas.height);
	}
	
	 console.log(canvas.toDataURL('image/jpeg',1));
	
	function readCanvas(){
		var canvasData = canvas.toDataURL('image/jpeg',1);
		var decodeAstring = atob(canvasData.split(',')[1]);
		
		var charArray =[];
		
		for(var i=0; i<decodeAstring.length;i++){
			
			charArray.push(decodeAstring.charCodeAt(i));
		}
		
       socket.send( new Blob([new Uint8Array(charArray)],{
    	   tpye:'image/jpeg'
       }));		
	
        socket.addEventListener('message',function(event){
        	img.src=window.URL.createObjectURL(event.data);
        });
		
	}
	
	
	
})();
 </script>




-->




<!--
<script type="text/javascript">
	

var  V = document.querySelector('#V');
V.onclick = function(e) {
	navigator.webkitGetUserMedia({video:true, audio: true},
	function(s){
	V.src = window.URL.createObjectURL
(s);
})
</script>

<br><br><br><br><br><br>
<br><br><br><br><br><br>
<br><br><br><br><br><br>
<br><br><br><br><br><br>
-->