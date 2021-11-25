<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>FILE Management System</title>
 	

<?php include('./header.php'); ?>
<?php
    require('db_connect.php');
    // When form submitted, insert values into the database.
    if (isset($_REQUEST['username'])) {
        // removes backslashes
        $username = stripslashes($_REQUEST['username']);
        //escapes special characters in a string
        $username = mysqli_real_escape_string($con, $username);
        $email    = stripslashes($_REQUEST['email']);
        $email    = mysqli_real_escape_string($con, $email);
        $password = stripslashes($_REQUEST['password']);
        $password = mysqli_real_escape_string($con, $password);
        $create_datetime = date("Y-m-d H:i:s");
        $query    = "INSERT into `users` (username, password, email, create_datetime)
                     VALUES ('$username', '" . md5($password) . "', '$email', '$create_datetime')";
        $result   = mysqli_query($con, $query);
        if ($result) {
            echo "<div class='form'>
                  <h3>Hey there, you have sucessfully created an account.</h3><br/>
                  <p class='link'>Click here to <a href='login.php'>Login</a></p>
                  </div>";
        } else {
            echo "<div class='form'>
                  <h3>Required fields are missing.</h3><br/>
                  <p class='link'>Click here to <a href='registration.php'>registration</a> again.</p>
                  </div>";
        }
    } 
?>

</head>
<style>
	body{
		width: 100%;
	    height: calc(100%);
	    /*background: #007bff;*/
	}
	/* main#main{
		width:100%;
		height: calc(100%);
		background:white;
	} */
	#login-right{
		position: absolute;
		right:24%;
		width:50%;
		height: calc(100%);
		background:white;
		display: grid;
		align-items: center;
	}
	
	#login-right .card{
		margin: auto
	} 
	.logo {
    margin: auto;
    font-size: 8rem;
    padding: .5em 0.8em;
    color: #000000b3;
}
</style>

<body>


  <main id="main" class=" alert-info">
  		
  		<div id="login-right">
  			<div class="w-100">
  				<h4 class="text-success text-center"><b>File Management System <br>Sign Up </b></h4>
  				<br>
  			
  			<div class="card col-md-8">
  				<div class="card-body">
  					<form id="login-form" >
  						<div class="form-group">
  							<label for="username" class="control-label text-success">Username</label>
  							<input type="text" id="username" name="username" class="form-control">
  						</div>
  						<div class="form-group">
  							<label for="password" class="control-label text-success">Password</label>
  							<input type="password" id="password" name="password" class="form-control">
  						</div>
  						<center><button class="btn-sm btn-block btn-wave col-md-4 btn-success">Sign Up</button>
						  <p class="link"><a href="login.php">Click to Login</a></p>	
					</center>
  					</form>
  				</div>
  			</div>
  		</div>
   		</div>

  </main>

  <a href="#" class="back-to-top"><i class="icofont-simple-up"></i></a>


</body>
<script>
	$('#login-form').submit(function(e){
		e.preventDefault()
		$('#login-form button[type="button"]').attr('disabled',true).html('Logging in...');
		if($(this).find('.alert-danger').length > 0 )
			$(this).find('.alert-danger').remove();
		$.ajax({
			url:'ajax.php?action=login',
			method:'POST',
			data:$(this).serialize(),
			error:err=>{
				console.log(err)
		$('#login-form button[type="button"]').removeAttr('disabled').html('Login');

			},
			success:function(resp){
				if(resp == 1){
					location.reload('index.php?page=home');
				}else{
					$('#login-form').prepend('<div class="alert alert-danger">Username or password is incorrect.</div>')
					$('#login-form button[type="button"]').removeAttr('disabled').html('Login');
				}
			}
		})
	})
</script>	
</html>