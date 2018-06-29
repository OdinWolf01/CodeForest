<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');
if (!$user->is_logged_in()) {echo 'Not Logged In'; exit();}
$test_req = require_once($_SERVER['DOCUMENT_ROOT'].'/layout/head_min.php');


if( $test_req === 1){
echo '</head>'.PHP_EOL;
}
?>




<style type="text/css">
    

    .chat-main{
    position: absolute;
    width: 270px;
    bottom: 0;
    right: 200px;
}
.chat-header{
    background: #4267B2;
    padding-top: 1px;
    padding-bottom: 1px;
}
.username i{
    font-size: 9px;
}
.username h6{
    display: inline-block;
    font-size: 12px;
    font-weight: 600;
}
.options i{
    font-size: 14px;
    font-weight: normal;
    opacity: 0.7;
}
.options .live-video{
    font-size: 6px;
}
.chats{
    height: 260px;
    overflow-x: scroll;
    overflow-x: hidden;
}
.chats ul li{
    list-style: none;
    clear: both;
    font-size: 13px;
}
.chats .send-msg{
    float: right;
}
.receive-msg img{
    border-radius: 100%;
    height: 30px;
    width: 12%;
}
.receive-msg-img{
    display: inline;
}
.receive-msg .receive-msg-desc{
    display: inline-block;
}
.receive-msg .receive-msg-desc p{
    background: #c1c1c1;
}
.message-box input{
    border: none;
    font-size: 13px;
    opacity: 0.7;
}
.message-box input:focus{
    outline: none;
}
.tools i{
    color: #a1a1a1;
    cursor: pointer;
    font-size: 20px;
    margin-right: 6px;
}



@media only (max-width: 450px) {
    .chat-main {
        position: absolute;
       width: 200px;
    }
}
</style>



 <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">


<h6><p><strong>its not perfect but maybe we can work together on this  maybe add the jquery ui theme  and maybe this  can be more responsive idk lol  we shall see  hahahaha srry i keep reverting back to bootstrap i know you dont like it but it works for me usually lol </strong></p></h6>

<div  class="container-fluid">
        <div class="row pt-3">
            <div class="chat-main">
                <div class="col-sm chat-header rounded-top ui-widget  text-white  hide-chat-box">
                    <div class="row">
                        <div class="col-sm username pl-2">
                            <i class="fa fa-circle text-success" aria-hidden="true"></i>
                            <h6 class="m-0"><? echo $_SESSION['username']; ?></h6>
                        </div>
                        <div class="col-sm options text-right pr-2">
                            <i class="fa fa-plus mr-2" aria-hidden="true"></i>
                            <i class="fa fa-video-camera" aria-hidden="true"></i>
                            <i class="fa fa-circle text-success live-video mr-1" aria-hidden="true"></i>
                            <i class="fa fa-phone mr-2" aria-hidden="true"></i>
                            <i class="fa fa-cog mr-2" aria-hidden="true"></i>
                            
                          </div>
                    </div>
                </div>
                <div class="chat-content">
                    <div class="col-sm chats border">
                        <ul class="p-0">
                            <li class="pl-2 pr-2 bg-primary rounded text-white text-center send-msg mb-1">
                               blah blah some text
                            </li>
                            <li class="p-1 rounded mb-1">
                                <div class="receive-msg">

                                     <img class="img-circle" alt="avatar" src="/avatar.php?pic=<? echo $_SESSION['avatarID']; ?>" width="40px" height="40px">

                                    <div class="receive-msg-desc  text-center mt-1 ml-1 pl-2 pr-2">
                                        <p class="pl-2 pr-2 rounded">testing</p>
                                    </div>
                                </div>
                            </li>
                            <li class="pl-2 pr-2 bg-primary rounded text-white text-center send-msg mb-1">
                               chat content here idk do your javascript magic lol
                            </li>
                            <li class="p-1 rounded mb-1">
                                <div class="receive-msg">
                                    <div class="receive-msg-img">

                                         <img class="img-circle" alt="avatar" src="/avatar.php?pic=<? echo $_SESSION['avatarID']; ?>" width="40px" height="40px">
                                       


                                    </div>
                                    <div class="receive-msg-desc rounded text-center mt-1 ml-1 pl-2 pr-2">
                                        <p class="mb-0 mt-1 pl-2 pr-2 rounded-top rounded-right">blah blah</p>
                                        <p class="mb-0 mt-1 pl-2 pr-2 rounded-bottom rounded-right">: ) blah</p>
                                    </div>
                                </div>
                            </li>
                            <li class="pl-2 pr-2 bg-primary text-white text-center send-msg mb-1 rounded-top rounded-left">
                               hahahaha
                            </li>
                            <li class="pl-2 pr-2 bg-primary text-white text-center send-msg mb-1 rounded-bottom rounded-left">
                                weeee
                            </li>
                            <li class="p-1 rounded  mb-1">
                                <div class="receive-msg">

                                     <img class="img-circle" alt="avatar" src="/avatar.php?pic=<? echo $_SESSION['avatarID']; ?>" width="40px" height="40px">

                                    <div class="receive-msg-desc rounded text-center mt-1 ml-1 pl-2 pr-2">
                                        <p class="pl-2 pr-2 rounded">we probably dont need all of this but its just an example </p>
                                    </div>
                                </div>
                            </li>
                            <li class="pl-2 pr-2 bg-primary rounded text-white text-center send-msg mb-1">
                                blah blah  more text 
                            </li>
                        </ul>
                    </div>
                    <div class="col-sm message-box border pl-2 pr-2 border-top-0">
                        <input type="text" class="pl-0 pr-0 w-100" placeholder="Type a message..." />
                        <div class="tools">
                            <i class="fa fa-picture-o" aria-hidden="true"></i>
                            
                            <i class="fa fa-meh-o" aria-hidden="true"></i>
                            <i class="fa fa-paperclip" aria-hidden="true"></i>
                            
                            <i class="fa fa-camera" aria-hidden="true"></i>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<!-- //////////////////////////  -->
<div class="container">
<div style="width: 300px;" class="card rounded-top ui-widget hide-chat-box">
    <div class="card-header">
        
        <h6 class="m-0"><? echo $_SESSION['username']; ?></h6>
    </div>
    <div class="card-body">
   



</div>

<div class="card-footer">
    <input style="line-height: 2px;" type="" name="">
</div>
</div>


</div>

  <script type="text/javascript">
      

       $('.hide-chat-box').click(function(){
        $('.chat-content').slideToggle();
        $('.chat-main').draggable();
    });
  </script>











  