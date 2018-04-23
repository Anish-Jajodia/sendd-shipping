<?php 
$shop_url =$_REQUEST['shop'];
require __DIR__.'/connection.php'; //DB connectivity
	$email='';$password='';
	$login_detail = pg_query($dbconn4, "SELECT * FROM user_table  WHERE store_url = '{$shop_url}'");
	if(pg_num_rows($login_detail)){
		while ($row = pg_fetch_assoc($login_detail)) {
		      $email=trim($row['email']);
			  $password=trim($row['password']);
		}
	}
	?>
	<div id="login_form" class="loginform">
	<h3>Login with your Sendd shipping login credentials</h3>
	<form name="login_form" method="POST" action="#" id="login_form">
	<label>Email</label><input required type="text" value="<?php echo $email; ?>" name="email" id="email"/><br />
	<label>Password</label><input requried type="password" value="<?php echo $password; ?>" name="password" id="password"/><br/>
		<div class="msg">&nbsp;</div>
	<input type="submit" name="login" id="login" value="Login"/> 
	</form>
</div>
<script>

$('#login').click(function(e){
	e.preventDefault();
	//get the values
		var email = $('#email').val();
		var password = $('#password').val();
		//validate the form
		if(email == '' || password == ''){
			$('.msg').text('Please fill the form');
		}else{
				$('.msg').html("<img src='loading.gif' border='0' />");	
			var request = new XMLHttpRequest();

			//request.open('POST', 'https://api-staging.sendd.co/rest-auth/login/');
			request.open('POST', 'https://api.sendd.co/rest-auth/login/');	
			request.setRequestHeader('Content-Type', 'application/json');
			request.setRequestHeader('Access-Control-Allow-Origin', '*'); 	
			request.setRequestHeader('Access-Control-Allow-Methods', 'GET, POST, PATCH, PUT, DELETE, OPTIONS'); 
			request.setRequestHeader('Access-Control-Allow-Headers', 'Origin, Content-Type, X-Auth-Token');			
			request.onreadystatechange = function () {
			  if (this.readyState === 4) {
				console.log('Status:', this.status);
				console.log('Headers:', this.getAllResponseHeaders());
				console.log('Body:', this.responseText);
				
				if(this.responseText.indexOf('key')){
			      var access_key=JSON.parse(this.responseText);
				  access_key =access_key.key;
				  if(access_key && access_key!=''){
				  var shop_url = "<?php echo $_SESSION['shop'];?>";
				$.post('/checklogin.php', {access_key:access_key,shop_url:shop_url,email:email,password:password}, function(resp){
					console.log("resp="+resp);
					if(resp!=''){
					alert(resp);
						$('.msg').html(resp);		
					}else{
						$('.msg').html('error while saving data');			
					} 
				});
				}
				else{
					$('.msg').html("Unable to log in with provided credentials.");
				}
				}
				else{
					alert(this.responseText);
				}
			  }
			};

			var body = {
			  'email': email,
			  'password':password
			};

			request.send(JSON.stringify(body));
			console.log(request.send(JSON.stringify(body)));
		}
});
</script>

