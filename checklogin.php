<?php 
session_start();
require __DIR__.'/connection.php'; //DB connectivity
	
	 $email= $_POST['email'];
	 $password= $_POST['password'];
    
	//convert string to md5
	//$password 	= md5($password);
	$shop_url = $_SESSION['shop'];
	$user_exist = pg_query($dbconn4, "SELECT * FROM user_table WHERE store_url = '{$shop_url}' and  email = '{$email}' and password = '{$password}'");
	
if(pg_num_rows($user_exist)){
while($response = pg_fetch_assoc($user_exist)){
$_SESSION['email'] = $email;
pg_query($dbconn4, "INSERT INTO user_table (status) VALUES ('1')  WHERE store_url = '{$shop_url}' and  email = '{$email}' and password = '{$password}'");
echo "cool";
}
}
?>
