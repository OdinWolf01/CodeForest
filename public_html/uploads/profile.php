<?php
require_once('includes/config.php'); 

if(!isset($_GET['id'])){
        header('Location: /');
        exit();
}

if(!$user->is_logged_in()){ header('Location: login.php'); exit(); }

$other_memberID = pdo_get_memberID_from_profileID($_GET['id']);
if($other_memberID === false){
        header('Location: /');
        echo "Error: memberID";
        exit();
}
$other_username = pdo_get_username_from_memberID($other_memberID);
if($other_username === false){
        header('Location: /');
        echo "Error: username";
        exit();
}
$other_avatarID = pdo_get_avatarID_from_memberID($other_memberID);
$other_profileID = $_GET['id'];


//include header template
require_once('layout/header.php'); 
?>

<!--  **************************  Session/Username echo Begin *************************  -->
<div class="container">
Viewing <? echo $other_username; ?>
<br>
<!--  **************************  Session/Username echo End *************************  -->


<main class="container-fluid">
<div class="row">
      <div class="col-md-3">
      
        <div class="panel panel-default">
          <div class="panel-body">
          
           <img style="margin: 20px 70px 40px;" class="img-circle" src="avatar.php?pic=<? echo ($other_avatarID !== false)?$other_avatarID:''; ?>" alt="avatar" width="250px" height="250px" >
  <br><br>

  
          </div>
        </div>

        
        <div class="panel panel-default">
          <div style="border: 1px solid #c0c0c0;width: 300px;left: 35px;top: 0px;" class="card card-block bg-faded">
            <h2 style="left: 20px;"><?php echo htmlspecialchars($other_username, ENT_QUOTES); ?>&apos;s</h2>


            <h5>Profile info</h5>
            
                <p>
                    <td>
                        <h6><label for="profileinfofullname">Full Name: </label></h6>
                        <div style="width: 200px;border: 1px solid #c0c0c0;left: 20px;height: 40px;" class="card card-block bg-faded" >
                          <h6  id="profileinfofullnamex" name="profileinfofullname"></h6>
                        </div>
                        
                        <h6><label for="profileinfolocation">Location: </label></h6>
                        <div style="width: 200px;border: 1px solid #c0c0c0;left: 20px;height: 40px;" class="card card-block bg-faded">
                          <h6 id="profileinfolocationx" name="profileinfolocation"></h6>
                        </div>

                        <h6><label for="profileinfoschooling">Schooling: </label></h6>
                        <div style="width: 200px;border: 1px solid #c0c0c0;left: 20px;height: 40px;" class="card card-block bg-faded">
                          <h6 id="profileinfoschoolingx" name="profileinfoschooling"></h6>
                        </div>

                        <h6><label for="profileinfoprofession">Profession: </label></h6>
                        <div style="width: 200px;border: 1px solid #c0c0c0;left: 20px;height: 40px;" class="card card-block bg-faded">
                          <h6 id="profileinfoprofessionx" name="profileinfoprofession"></h6>
                        </div>

                        <h6><label for="profileinfocompany">Company: </label></h6>
                        <div style="width: 200px;border: 1px solid #c0c0c0;left: 20px;height: 40px;" class="card card-block bg-faded">
                          <h6 id="profileinfocompanyx" name="profileinfocompany"></h6>
                        </div>

                        <h6><label for="profileinfohobbies">Hobbies: </label></h6>
                        <div style="width: 200px;border: 1px solid #c0c0c0;left: 20px;height: 40px;" class="card card-block bg-faded">
                          <h6 id="profileinfohobbiesx" name="profileinfohobbies"></h6>
                        </div>

                        <h6><label for="profileinfoaboutme">About Me: </label></h6>
                        <div style="width: 200px;border: 1px solid #c0c0c0;left: 20px;height: 40px;" class="card card-block bg-faded">
                          <h6 id="profileinfoaboutmex" name="profileinfoaboutme"></h6>
                        </div>

                        <h6><label for="profileinforelationshipstatus">Relationship Status: </label></h6>
                        <select id="profileinforelationshipstatus" name="profileinforelationshipstatus" disabled>
                          <option value="a">None</option>
                          <option value="b">Single And Looking</option>
                          <option value="c">Single And Not Looking</option>
                          <option value="d">In A Relationship</option>
                          <option value="e">Married</option>
                          <option value="f">Divorced</option>
                          <option value="g">It&apos;s Complicated</option>
                          <option value="h">It&apos;s Really Complicated</option>
                          <option value="i">It&apos;s Really, Really Complicated</option>
                          <option value="j">It&apos;s Really, Really, Really Complicated</option>
                        </select>
                    </td>
                    


                </p>
              </li>
            </ul>
          </div>
        </div>
        
      </div>


<input type=hidden id="postformview" value="<? echo $other_profileID; ?>">

      <!--<div class="col-md-6">-->



        <div class="col-lg-6 col-md-6 mx-auto">



        <img style="border: 2px solid #c0c0c0" class="image1" src="background.php?pic=<? $bid = pdo_get_backgroundID_from_username($other_username); echo ($bid !== false)?$bid:''; ?>"  alt="pdo_get_backgroundID_from_usernamend" width="755px" height="300px" >

       <br><br>
       
<div id="tabs">
  <ul>
    <li><a href="#fragment-1"><span>One</span></a></li>
    <li><a href="#fragment-2"><span>Two</span></a></li>
    <li><a href="#fragment-3"><span>Three</span></a></li>
  </ul>
  <div id="fragment-1">
    <p>First tab is active by default:</p>
    <pre><code>and ofc if you like this we will seperate the css snd js :) </code></pre>
  </div>
  <div id="fragment-2">
    Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.
    Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.
  </div>
  <div id="fragment-3">
    Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.
    Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.
    Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.
  </div>
</div>
 
<script>
$('#tabs').tabs();
</script>










<style>



*{
  box-sizing: border-box;
  margin: 0;
  padding: 0;
  list-style-type: none;
}

#pagewrap{
  max-width: 360px;
  margin: 3vh auto;
  box-shadow: 0 10px 20px rgba(0,0,0,0.19), 0 6px 6px rgba(0,0,0,0.23);
}

header{
  width: 100%;
  display: flex;
  justify-content: space-between;
  padding: 20px 15px;
  color: #666;
  background-color: #f5f8f9;
}

header a{color: inherit; text-decoration: none; font-size: 1.5em; vertical-align: middle;}
header h3{font-weight: 400;}

.chatbox{
  background-color: #f5f8f9;
  padding: 10px 20px;
  width: 100%;
  height: 350px;
  overflow-y: scroll;
}

.time{
  text-align: center;
  font-size: .70em;
  color: #666;
  margin-top: 30%;
  letter-spacing: 1.2px;
  word-spacing: 2px;
}

#message{
  width: 100%;
}






#message:before, #message:after{
  content: "";
  display: block;
  clear: both;
}

#message li{
  background-color: #e5eaec;
  color: #222;
  font-size: .85em;
  border-radius: 10px;
  position: relative;
  padding: 10px;
  margin: 1% 0;
  max-width: 70%;
  min-width: 10%;  
  float: right;
  word-wrap: break-word;
  clear: both;
  animation: scaler 150ms ease-out;
  font-weight: 500;
}

#message .first:after{
  content: "";/* we can add test content here kdodge :) */
  display: block;
  position: absolute;
  right: -10px;
  top: 0;
  width: 0;
  border-width: 10px 10px 0;
  border-style: solid;
  border-color: #e5eaec transparent;
}


.reply{
  padding: 15px 0;
  background-color: #f5f8f9;
  display: -webkit-box;
  display: -ms-flexbox;
  display: flex;
  -webkit-box-pack: justify;
  -ms-flex-pack: justify;
  justify-content: space-between;
}

.reply:before, .reply:after{
  content: "";
  display: block;
  clear: both;
}

.material-icons, input, button{
  float: left;
  margin: 3px;
  -webkit-box-flex: 1;
  -ms-flex: 1 1 0;
  flex: 1 1 0;
}


.material-icons{
  color: #444; 
  font-size: 1.8em; 
  padding-top: 10px; 
  transform: rotate(-60deg);
  cursor: pointer;
}

input{
  width: 72%;
  padding: 10px;
  border: none;
  font-size: 1.2em;
  background-color: inherit;
}

input:focus, button:focus{
  outline: 0;
}
/*
button{
  background-color: #222;
  color: #fff;
  padding: 15px 10px;
  width: 20%;
  vertical-align: middle;
  border: none;
  cursor: pointer;
  letter-spacing: 1.2px;
}
*/
.scroll{
  position: absolute;
  bottom: 0;
}




@keyframes scaler{
  0%{transform: scale(0)}
  100%{transform: scale(1)}
}
</style>
















<div id="pagewrap">
  <header>
    <div align="" class="btn btn-default">
    <h3 class="name">chat test </h3>
  </div>
    <!--  here maybe we could make a modal that will pop up  and show available 
      friends to chat with ?  idk just thinking idk if thats a good idea or not lol
    -->

    <a href="#"><i class="fa fa-ellipsis-h" aria-hidden="true"></i></a>
  </header>
  
  <section class="chatbox">
      <ul id="message">
        <div class="time"><p></p></div>
       <p>idk how to add your js to this and time stamps and all the goodies lol</p>
        <div id="chatresults"></div>

        <li class="first">other user here idk how to implement the other user maybe you can 
        tell me later lol </li>
      </ul>
  </section>
  
  <section class="reply" id="reply">
   
    <form>
      <input type="text" placeholder="Type something">

      <!--<input type="button" id=chatopenbtn value="Chat" placeholder="chat here ">-->
      <button  class="btn btn-primary">Send</button>

     

    </form>
  </section>

</div>

<button style="border: 3px solid black;padding: 20px;" class="btn-danger">
 <p style="font-size: 20px;">ok man i need you to add your js to this i tried i screwed it
      up and then i fixed it lol when i add your  input "" <!--<input type="button" id=chatopenbtn value="Chat" placeholder="chat here "> -->"" it shows your send 
      and clear buttons i hit send and it sends the username to the chat box
      and clear works  but i cant seem to get the right text field
      where you type your mssg lol  lets get together on this 
      it needs your magic i know this box isnt all that great 
      lol i can make it better later  np  we need to figure out what 
      we want it to look like later after its working :) </p></button>


      <br><br><br><br>
      <br><br><br><br>
      <br><br><br><br>
      <br><br><br><br>
      <br><br><br><br>
      <br><br><br><br>
      <br><br><br><br>
      <br><br><br><br>
      <br><br><br><br>



<input type=button id=chatopenbtn value="Chat">
<div id="chatresults"></div>


<script >
  

var main = function() {

    $('form').submit(function(event) {
        var $input = $(event.target).find('input');
        var message = $input.val();

        if (message != "") {
            var html = $('<li>').text(message);
            html.appendTo('#message');
            $input.val("");
            $('#message')[0].scrollIntoView(false);
        }
        return false;
    });

   
  var currentdate = new Date(); 
    var datetime =
        currentdate.getDate() + "/"
             +(currentdate.getMonth()+1)  + "/" 
             + currentdate.getFullYear() + " at "  
             + currentdate.getHours() + ":"  
             + currentdate.getMinutes() + ":" 
             + currentdate.getSeconds();

    $('.time').html(datetime);
}

$(document).ready(main);



</script>













<!-- kdodge save -

 
<input type=button id=chatopenbtn value="Chat">
<div id="chatresults"></div>
 -->