<?php require_once($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/includes/AntiXSS.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/includes/xss_filter.class.php');

//if logged in redirect to members page
if ($user->is_logged_in()) {header('Location: memberpage.php');exit();}

//echo htmlentities(preg_replace("/\n/", "<br />\n", var_export($_POST, true)), ENT_QUOTES);

//if form has been submitted process it
if(isset($_POST['signup'])) {
  $username = '';
  
  if (!isset($_POST['username'])) {
    $error[] = "Please fill out all fields";
  }else{
    $username = $_POST['username'];
  }

  if (!isset($_POST['email'])) {
    $error[] = "Please fill out all fields";
  }

  if (!isset($_POST['password'])) {
    $error[] = "Please fill out all fields";
  }

  //very basic validation
  if (!$user->isValidUsername($username)) {
    $error[] = 'Usernames must be at least 3 Alphanumeric characters';
  } else {
    $stmt = $db->prepare('SELECT username FROM members WHERE username = :username');
    $stmt->execute(array(':username' => $username));
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!empty($row['username'])) {
      $error[] = 'Username provided is already in use.';
    }
  }

  if(isset($_POST['password']) && strlen($_POST['password']) < 3) {
    $error[] = 'Password is too short.';
  }

  if(isset($_POST['passwordConfirm']) && strlen($_POST['passwordConfirm']) < 3) {
    $error[] = 'Confirm password is too short.';
  }

  if(isset($_POST['password']) && isset($_POST['passwordConfirm']) && $_POST['password'] != $_POST['passwordConfirm']) {
    $error[] = 'Passwords do not match.';
  }

  //email validation
  $email = htmlspecialchars_decode((isset($_POST['email']))?$_POST['email']:'noemail', ENT_QUOTES);
  if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $error[] = 'Please enter a valid email address';
  } else {
    $stmt = $db->prepare('SELECT email FROM members WHERE email = :email');
    $stmt->execute(array(':email' => $email));
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!empty($row['email'])) {
      $error[] = 'Email provided is already in use.';
    }
  }

  //if no errors have been created carry on
  if (!isset($error)) {

    //hash the password
    $hashedpassword = $user->password_hash($_POST['password'], PASSWORD_BCRYPT);

    //create the activasion code
    $activasion = md5(uniqid(rand(), true));

    try {

      //insert into database with a prepared statement
      $acctCreate = time();
      $stmt = $db->prepare('INSERT INTO members (username,password,email,active,acctCreate) VALUES (:username, :password, :email, :active, :acctCreate)');
      $stmt->execute(array(
          ':username' => $username,
          ':password' => $hashedpassword,
          ':email'    => $email,
          ':active'   => $activasion,
          ':acctCreate' => $acctCreate,        
        ));
      $id = $db->lastInsertId('memberID');

      do {
        $proid = bin2hex(openssl_random_pseudo_bytes(8));
        //uniqid();
      } while (pdo_count_profileID($proid));
      pdo_add_profileID_to_database($id, $proid);

      //send email
      $to      = $_POST['email'];
      $subject = "Registration Confirmation";
      $body    = "<p>Thank you for registering at Signature Web Design.</p>
      <p>To activate your account, please click on this link: <a href='".DIR."activate.php?x=$id&y=$activasion'>" .DIR."activate.php?x=$id&y=$activasion</a></p>
      <p>Regards Site Admin</p>";

      $mail = new Mail();
      $mail->setFrom(SITEEMAIL);
      $mail->addAddress($to);
      $mail->subject($subject);
      $mail->body($body);
      $mail->send();

      //redirect to index page
      header('Location: index.php?action=joined');
      exit();

      //else catch the exception and show the error.
    } catch (PDOException $e) {
      $error[] = $e->getMessage();
    }

  }
if(isset($error) && count($error) > 0)
  var_dump($error);
}else if(isset($_POST['login'])) {

	if (!isset($_POST['username'])) {
		$error[] = "Please fill out all fields";
	}

	if (!isset($_POST['password'])) {
		$error[] = "Please fill out all fields";
	}

	$username = $_POST['username'];
	if ($user->isValidUsername($username)) {
		if (!isset($_POST['password'])) {
			$error[] = 'A password must be entered';
		}
		$password = $_POST['password'];

		if ($user->login($username, $password)) {
			$_SESSION['username'] = $username;
			if (pdo_does_username_have_profileID($username) == 0) {
				do {
					$proid = bin2hex(openssl_random_pseudo_bytes(8));
				} while (pdo_count_profileID($proid));
				pdo_add_profileID_to_database($_SESSION['memberID'], $proid);

			}
			header('Location: memberpage.php');
			exit;

		} else {
			$error[] = 'Wrong username or password or your account has not been activated. Click <a href="/activate.php?x=-1&y=&resend='.htmlentities($_POST['username'], ENT_QUOTES).'">here</a> to re-email the link.';
		}
	} else {
		$error[] = 'Usernames are required to be Alphanumeric, and between 3-16 characters long';
	}

}//end if submit


//define page title
$title = 'DATA403';

//include header template

?>


<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">




<style>
html, body {
  margin: 0;
  background: url('vendor/images/giphy.gif');
  background-size: cover;
  overflow: hidden;
}


    .login-box{
        position:relative;
        margin: 10px auto;
        width: 500px;
        height: 380px;
        opacity: 90%;
       background-color: white;
        border: 1px solid black;
        padding: 10px;
       border-radius: 3px;
        -webkit-box-shadow: 0px 2px 3px 0px rgba(0,0,0,0.33);
        -moz-box-shadow: 0px 2px 3px 0px rgba(0,0,0,0.33);
        box-shadow: 0px 2px 3px 0px rgba(0,0,0,0.33);
    }
    .lb-header{
        position:relative;
        color: #00415d;
        margin: 5px 5px 10px 5px;
        padding-bottom:10px;
        border-bottom: 1px solid #eee;
        text-align:center;
        height:28px;
    }
    .lb-header a{
        margin: 0 25px;
        padding: 0 20px;
        text-decoration: none;
        color: #666;
        font-weight: bold;
        font-size: 15px;
        -webkit-transition: all 0.1s linear;
        -moz-transition: all 0.1s linear;
        transition: all 0.1s linear;
    }
    .lb-header .active{
        color: #029f5b;
        font-size: 18px;
    }


    .email-login,.email-signup{
        position:relative;
        float: left;
        width: 100%;
        height:auto;
        margin-top: 20px;
        text-align:center;
    }



</style>

<br>
<br>
<br>
<br>






<div class="login-box">
    <div class="lb-header">
        <a href="#" class="active" id="login-box-link">Login</a>
        <a href="#" id="signup-box-link">Sign Up</a>
    </div>


    <form method="post" action="/" class="email-login">
        <input type="hidden" name="login" value="">
        <div class="form-group">
            <input type="text" name="username" id="username" class="form-control input-md" placeholder="User Name" value="<? if(isset($_POST['username'])) echo htmlentities($_POST['username'], ENT_QUOTES); ?>" tabindex="1">
        </div>
        <div class="form-group">
            <input  type="password" name="password" id="password" class="form-control input-lg" placeholder="Password" tabindex="3">
        </div>



        <div class="form-group">
            <button class="btn btn-primary">Log in</button>
        </div>
        <div class="form-group">
            <a href="#" class="forgot-password">Forgot password?</a>
        </div>
        <div class="form-group">
<?
if (isset($_GET['action'])) {
  switch ($_GET['action']) {
    case 'joined':
      echo "<h2 class='bg-success'>Please check your inbox for a activation link.</h2>";
      break;
    case 'active':
      echo "<h2 class='bg-success'>Your account is now active you may now log in.</h2>";
      break;
    case 'reset':
      echo "<h2 class='bg-success'>Please check your inbox for a reset link.</h2>";
      break;
    case 'resetAccount':
      echo "<h2 class='bg-success'>Password changed, you may now login.</h2>";
      break;
  }
}
if (isset($error)) {
  foreach ($error as $error) {
    echo '<p class="bg-danger">'.$error.'</p>';
  }
}

?>
        </div>

    </form>
    <form method="post" action="/" class="email-signup" style="display: none;">
       <input type="hidden" name="signup" value="">
       <div class="form-group">
            <input class="form-control" type="text" name="username" placeholder="Username"/>
        </div>
       <div class="form-group">
            <input class="form-control" type="email" name="email" placeholder="Email"/>
        </div>
        <div class="form-group">
            <input class="form-control" type="password" name="password" placeholder="Password"/>
        </div>
        <div class="form-group">
            <input class="form-control" type="password" name="passwordConfirm" placeholder="Confirm Password"/>
        </div>
        <div class="form-group">
            <input  type="submit" class="btn btn-primary" value="Sign Up" />
        </div>
    </form>
</div>














<script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>




<script>

    $(".email-signup").hide();
    $("#signup-box-link").click(function(){
        $(".email-login").fadeOut(100);
        $(".email-signup").delay(100).fadeIn(100);
        $("#login-box-link").removeClass("active");
        $("#signup-box-link").addClass("active");
    });
    $("#login-box-link").click(function(){
        $(".email-login").delay(100).fadeIn(100);;
        $(".email-signup").fadeOut(100);
        $("#login-box-link").addClass("active");
        $("#signup-box-link").removeClass("active");
    });
</script>






<script>
    var canvas    = document.getElementById('canvas'),
    ctx       = canvas.getContext('2d'),
	  perlin    = new ClassicalNoise(),
    variation = .003,
    amp       = 200,
    variators = [],
    max_lines = (navigator.userAgent.toLowerCase().indexOf('firefox') > -1) ? 25 : 30,
    canvasWidth,
    canvasHeight,
    start_y;

for (var i = 0, u = 0; i < max_lines; i++, u+=.02) {
  variators[i] = u;
}

function draw(){
  ctx.shadowColor = "rgba(43, 205, 255, 1)";
  ctx.shadowBlur = 0;
  
  for (var i = 0; i <= max_lines; i++){
    ctx.beginPath();
    ctx.moveTo(0, start_y);
    for (var x = 0; x <= canvasWidth; x++) {
      var y = perlin.noise(x*variation+variators[i], x*variation, 0);
      ctx.lineTo(x, start_y + amp*y);
    }
    var color = Math.floor(150*Math.abs(y));
    var alpha = Math.min(Math.abs(y), .8)+.1;
    ctx.strokeStyle = "rgba(80,210,240,"+alpha+")";
    ctx.stroke();
    ctx.closePath();

    variators[i] += .005;
  }
}

(function init() {
	resizeCanvas();
	animate();
	window.addEventListener('resize', resizeCanvas);
})();

function animate() {
  ctx.clearRect(0, 0, canvasWidth, canvasHeight);
  draw();
  requestAnimationFrame(animate);
}

function resizeCanvas(){
	canvasWidth = document.documentElement.clientWidth,
	canvasHeight = document.documentElement.clientHeight; 

	canvas.setAttribute("width", canvasWidth);
	canvas.setAttribute("height", canvasHeight);

	start_y = canvasHeight/2;
}
</script>






<canvas id="canvas"></canvas>









<!--


<div class="row">
    <div class="col-md-3">
        <form role="form" method="post" action="" autocomplete="off">
            <h2>Please Sign Up</h2>
            <input type="hidden" name="signup" value="">
            <p>Already a member? <a href='login.php'>Login</a></p>
            <hr>

            <?php /*
            //check for any errors
            if (isset($error)) {
                foreach ($error as $error) {
                    echo '<p class="bg-danger">'.$error.'</p>';
                }
            }

            //if action is joined show sucess
            if (isset($_GET['action']) && $_GET['action'] == 'joined') {
                echo "<h2 class='bg-success'>Registration successful, please check your email to activate your account.</h2>";
            }
            */?>

            <div class="form-group">
                <input type="text" name="username" id="username" class="form-control input-lg" placeholder="User Name" value="<?php //if (isset($error)) {echo htmlspecialchars($_POST['username'], ENT_QUOTES);}?>" tabindex="1">
            </div>
            <div class="form-group">
                <input type="email" name="email" id="email" class="form-control input-lg" placeholder="Email Address" value="<? if(!isset($error) && isset($_POST['email'])) echo htmlentities($_POST['email'], ENT_QUOTES); ?>" tabindex="2">
            </div>
            <div class="row">

                <div class="form-group">
                    <input type="password" name="password" id="password" class="form-control input-lg" placeholder="Password" tabindex="3">
                </div>
            </div>

            <div class="form-group">
                <input type="password" name="passwordConfirm" id="passwordConfirm" class="form-control input-lg" placeholder="Confirm Password" tabindex="4">
            </div>
    </div>
</div>

<div class="row">

    <div ><input type="submit" name="submit" value="Register" class="btn btn-primary btn-block btn-lg" tabindex="5"></div>
</div>
</form>

</div>


<div  class="row">
    <div class="col-md-3">


        <form role="form" method="post" action="" autocomplete="off">
            <h2>Please Login</h2>
            <input type="hidden" name="login" value="">
            <p><a href='./'>Back to home page</a></p>
            <hr>
            <?php /*
            //check for any errors
            if (isset($error)) {
                foreach ($error as $error) {
                    echo '<p class="bg-danger">'.$error.'</p>';
                }
            }

            if (isset($_GET['action'])) {
                //check the action
                switch ($_GET['action']) {
                    case 'active':
                        echo "<h2 class='bg-success'>Your account is now active you may now log in.</h2>";
                        break;
                    case 'reset':
                        echo "<h2 class='bg-success'>Please check your inbox for a reset link.</h2>";
                        break;
                    case 'resetAccount':
                        echo "<h2 class='bg-success'>Password changed, you may now login.</h2>";
                        break;
                }
            }*/
            ?>
            <div style="text-align: center;" class="form-group">
                <input type="text" name="username" id="username" class="form-control input-lg" placeholder="User Name" value="<?php //if (isset($error)) {echo htmlspecialchars($_POST['username'], ENT_QUOTES);}?>" tabindex="1">
            </div>
            <div class="form-group">
                <input type="password" name="password" id="password" class="form-control input-lg" placeholder="Password" tabindex="3">
            </div>
            <div class="row">

                <a href='reset.php'>Forgot your Password?</a>
            </div>
    </div>
    <hr>
    <div class="row">
        <input="submit" name="submit" value="Login" class="btn btn-primary btn-block btn-lg" tabindex="5">
    </div>
    </form>
</div>
</div>

</div>





-->














































<?php
//include header template
require 'layout/footer.php';
?>
