<?php
$shop_url =$_REQUEST['shop'];
require __DIR__.'/connection.php'; //DB connectivity
	$login_detail = pg_query($dbconn4, "SELECT * FROM user_table  WHERE store_url = '{$shop_url}'");
	if(pg_num_rows($login_detail)){
		while ($row = pg_fetch_assoc($login_detail)) {
		      $email=trim($row['email']);
			  $password=trim($row['password']);
			  $profile_photo=trim($row['logo']);
				$ship_company =trim($row['ship_preference']);
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
	<!-- Upload logo for shipping label -->
	 <div class="logo_option">
	 <h3>Upload Logo for Shipping Label</h3>
		 <form name="upload_logo" action="#" method="post" enctype="multipart/form-data" id="logo_upload_form">
		 <label for="fileToUpload">Upload Logo</label>
		 <input type="file" name="fileToUpload" id="fileToUpload">
		 <input type="hidden" name="shop_url" id="shop_url"  value="<?php echo $_SESSION['shop'];?>">
		   <input type="submit" value="Upload Image" class="upload_logo" name="submit">
		   <div class="msg-upload">&nbsp;</div>
		   <?php if ($profile_photo != ''){ ?>
		    <img src="/images/<?php echo $profile_photo; ?>" class='preview db_preview'>
		   <?php }?>
		 </form>

	 </div>
	 <!-- Upload logo for shipping label -->
 <!-- Pickup address -->
	<div class="pickupaddress">
	<h3>Pickup Address</h3>
	<?php include 'Pickup_address.php';?>
	</div>
<!-- Pickup address -->


<!-- shipping company_preference -->

	<div class="ship_preference">
		<h3>Prefered Courier</h3>
		<form name="company_preference" action="#" method="post" id="set_company_preference">
			<select id="courier_company">
			    <option  value='FE'>Fedex</option>
			    <option  value='DH'>Delhivery</option>
			    <option  value='EE'>EcomExpress</option>
			    <option  value='DT'>DotZot</option>
			    <option  value='AX'>Aramex</option>
			    <option  value='BD'>Bluedart</option>
			</select>&emsp;&emsp;
			<input type="submit" value="Set Preference"><br><br>
	  </form>
	</div>
	<!-- shipping company_preference -->
</div>
<script>
$('#courier_company').val("<?php echo $ship_company; ?>");

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
			// request.open('POST', 'https://api-staging.sendd.co/rest-auth/login/'); //test Login api
			request.open('POST', 'https://api.sendd.co/rest-auth/login/');	//Live Login api
			request.setRequestHeader('Content-Type', 'application/json');

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
/* ****** Upload logo ****** */
$("#logo_upload_form").on('submit',(function(e){
	e.preventDefault();
	$('.upload_logo').val('Uploading...').attr('disabled',true);
		var shop_url = "<?php echo $_SESSION['shop'];?>";
		$.ajax({
				url: "uploadlogo.php?shop_url="+shop_url,
				type: "POST",
				data:  new FormData(this),
				contentType: false,
				cache: false,
				processData:false,
				success: function(data){
				$('.upload_logo').val('Uploaded!').attr('disabled',false);
				$(".msg-upload").html(data);
				$(".db_preview").hide();
				},
				error: function(){
				$('.upload_logo').val('Upload Logo').attr('disabled',true);
					alert("Error");
				}
			});
}));
/* ***** Set Shipping company Preference **** */
$('#set_company_preference').on('submit',function(e) {
    	e.preventDefault();
    	var courier = $('#courier_company').val();
    	var shop_url = "<?php echo $_SESSION['shop'];?>";
    	$.post('/shipping_preference.php', {shop_url:shop_url,company_prefered:courier}, function(resp){
					if(resp!=''){
					alert(resp);
						$('.msg').html(resp);
					}else{
						$('.msg').html('error while saving data');
					}
				});
})
</script>
