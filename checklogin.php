<?php 
session_start();
require __DIR__.'/connection.php'; //DB connectivity
	
	$email= $_POST['email'];
	echo $password= $_POST['password'];
        echo "<script>alert(1);</script>";
	echo "$email=".$email;
	//convert string to md5
	//$password 	= md5($password);
	echo $shop_url = $_SESSION['shop'];
		echo "hello";
$query = "SELECT * FROM user_table";
echo $query;
$a = pg_query($dbconn4, $query);
print_r($a);
/* $select_store = mysqli_query($dbconn4,"SELECT email,password FROM user_table WHERE store_url = '$shop_url' and email = '$email' and password = '$password'");
print_r($select_store);
	if (mysqli_num_rows($select_store) > 0) {
		$data = mysqli_fetch_assoc($select_store);
		$_SESSION['email'] = $email;
		echo "cool";
			}*/
 $select_store2 = mysqli_query($dbconn4,"SELECT * FROM user_table");
print_r( $select_store2);
	/*$sql = "select email, password from user_table where email = '$email' and password = '$password'";
	$qry = mysql_query($sql);

	$numrows  = mysql_num_rows($qry);
	
	if($numrows > 0){
		
		//set seesion
		echo $_SESSION['email'] = $email;
		//print message for jquery
		echo "cool";
	}*/
	

?>
