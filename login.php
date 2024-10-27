<?php include('server.php') ?>
<!DOCTYPE html>
<html>
<head>
  <title>Registration system PHP and MySQL</title>
  <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
  <div class="header">
  	<h2>Queen's Clinic Admin Login</h2>
  </div>
	 
  <form method="post" action="index.php">
  	<?php include('errors.php'); ?>
  	<div class="form-group">
  		<label for="username">Full Name</label>
  		<input type="text" id="username" class="form-control" name="username" required/>
  	</div>
  	<div class="form-group">
  		<label for="pw">Password</label>
  		<input type="password" id="pw" class="form-control" name="pw" required/>
  	</div>
  	<div>
  		<button type="submit" class="btn" name="login_user">Login</button>
  	</div>
  </form>
</body>
</html>