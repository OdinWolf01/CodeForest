<?php require_once 'includes/config.php';


if (!$user->is_logged_in()) {header('Location: /');exit();}

$title = 'Social :)';



require_once 'layout/header_min.php';
?>
   

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <!-- Custom fonts for this template -->
    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="vendor/simple-line-icons/css/simple-line-icons.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700,300italic,400italic,700italic" rel="stylesheet" type="text/css">
<style>



  body {
  font-family: 'Lato', 'Helvetica Neue', Helvetica, Arial, sans-serif;
}

h1,
h2,
h3,
h4,
h5,
h6 {
  font-family: 'Lato', 'Helvetica Neue', Helvetica, Arial, sans-serif;
  font-weight: 700;
}

header.masthead {
  position: relative;
  height: 400px;
  
}

header.masthead .overlay {
  position: absolute;
  
  height: 100%;
  width: 100%;
  top: 0;
  left: 0;
  
}

header.masthead h1 {
  font-size: 2rem;
}

@media (min-width: 768px) {
  header.masthead {
    padding-top: 0rem;
    padding-bottom: 0rem;
  }
  header.masthead h1 {
    font-size: 3rem;
  }
}



@media (min-width: 768px) {
  .section1 {
    display: flex;
    
    
    padding-top: 0rem;
    padding-bottom: 0rem;
  }
}


@media (min-width: 768px) {
  .one {
  flex:1;
  margin:5px;
  
  }
}


@media (min-width: 768px) {
  .two{
    flex: 3;
    margin:5px;
  
  }
}

@media (min-width: 768px) {
  .three{
   flex: 1;
   margin:5px;
  
   
  }
}

@media (min-width: 768px) {
  .four{
    position: absolute;
    top: 200%;
    flex: 1;
    width:19%;
    margin:5px;
  
  }
}


</style>





    <!-- Masthead -->
    <header class="masthead ">
      
      <? require_once($_SERVER['DOCUMENT_ROOT'].'/codelets/background_codelet.php');; ?>


          
<div  class="tab">
  <div style="text-align:center;">

  <button id="opentab1" style="color: white;" class="tablinks" onclick="openTab(event, 'Posts')">Posts</button>

  <button style="color: white;" class="tablinks" onclick="openTab(event, 'Friends')">Friends</button>
  <button style="color: white;" class="tablinks" onclick="openTab(event, 'Find_Friends')">Find Friends</button>
  <button style="color: white;" class="tablinks" onclick="openTab(event, 'Profile_settings')">Profile Settings</button>

  <button style="color: white;" class="tablinks" onclick="openTab(event, 'News_feeds')">News Feed</button>
  <button style="color: white;" class="tablinks" onclick="window.location.href = './my_desktop.php';"><a style="color: white;list-style: none;" href="my_desktop.php">Desktop</a></button>

</div>
</div>

<? require_once($_SERVER['DOCUMENT_ROOT'].'/codelets/avatar_codelet.php');; ?>
      
     <br><br>
     
<section class="section1">

<div class="one">
<div class="card">
  <div class="card-header"></div>

  <div class="card-body">
  <? require_once($_SERVER['DOCUMENT_ROOT'].'/codelets/profile_info_codelet.php');; ?>

  </div>
  </div>
</div>

<div class="two">
<div class="card">
  <div class="card-header"></div>

  <div class="card-body">
  <? require_once($_SERVER['DOCUMENT_ROOT'].'/codelets/post_list_codelet.php'); ?>

  </div>
  </div>
</div>

<div class="three">
<div class="card">
  <div class="card-header"></div>

  <div class="card-body">
  <? require_once($_SERVER['DOCUMENT_ROOT'].'/codelets/contacts_codelet.php'); ?>

  </div>
  </div>
</div>




<div class="four">
<div class="card">

<div style="border: 1px solid red;" class="card-header">
   <h5><i class="fa fa-image"></i>Recent Photos</h5>
</div>

<div class="card-body">
<? require_once($_SERVER['DOCUMENT_ROOT'].'/codelets/media_recent_codelet.php');; ?>
</div>
</div>
</div>

</section>
    
    <!-- Footer -->
   
    </footer>

    <!-- Bootstrap core JavaScript -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  </body>

</html>
