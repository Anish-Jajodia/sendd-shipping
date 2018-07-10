<?php
session_start();
require __DIR__.'/connection.php'; //DB connectivity
	$shop_url = $_POST['shop_url'];
	if(isset($_REQUEST['access_key']) || $_REQUEST['access_key']!=''){
			 $access_key= trim($_POST['access_key']);
			 $email= trim($_POST['email']);
			 $password= trim($_POST['password']);
	 $user_exist = pg_query($dbconn4, "SELECT * FROM user_table WHERE store_url = '{$shop_url}'");
		if(pg_num_rows($user_exist)){
			$user_exist = pg_query($dbconn4, "UPDATE user_table SET access_key ='{$access_key}' , email='{$email}' , password='{$password}'  WHERE store_url = '{$shop_url}'");
				if($user_exist){
					echo "login details update  sucessfully";

				}
		}
		else {
			$sql = "insert into user_table (access_key, store_url ,email,password) values ('$access_key', '$shop_url','$email','$password')";
			$qry = pg_query($sql);
			if($qry){
				echo "login  sucessfully";
			}
		}
	}

		if(isset($_REQUEST['getaccesstoken']) || $_REQUEST['getaccesstoken']!=''){
			$user_exist = pg_query($dbconn4, "SELECT * FROM user_table WHERE store_url = '{$shop_url}'");
			if(pg_num_rows($user_exist)){

				while ($row = pg_fetch_assoc($user_exist)) {
						 // echo $row['access_key'];
						 echo "<p id='access_key'>".$row['access_key']."</p>";
						 echo "<p id='ship_logo'>".$row['logo']."</p>";
						 echo "<p id='ship_preference_company'>".$row['ship_preference']."</p>";
					}
			}
	  	}



		if(isset($_REQUEST['saveaddress']) || $_REQUEST['saveaddress']!=''){

			$address_id=trim($_REQUEST['saveaddress']);
			 $name=trim($_REQUEST['username']);
			 $companyname=trim($_REQUEST['companyname']);
			 $address_line1=trim($_REQUEST['address_line1']);
			 $address_line2=trim($_REQUEST['address_line2']);
			 $city=trim($_REQUEST['city']);
			 $zipcode=trim($_REQUEST['zipcode']);
			 $phoneno=trim($_REQUEST['phoneno']);
			 $shop_url=trim($_REQUEST['shop_url']);
			//echo "SELECT id FROM pickup_address WHERE shop_url ='{$shop_url}' and id={$address_id}";
			 $pickup_address2 = pg_query($dbconn4, "SELECT id FROM pickup_address WHERE shop_url ='{$shop_url}' and id={$address_id}");
			//echo pg_num_rows($pickup_address2);
			if(pg_num_rows($pickup_address2)){
				//echo "UPDATE pickup_address SET name ='{$name}' , address_line1='{$address_line1}', address_line2='{$address_line2}', city='{$city}', zipcode='{$zipcode}', phoneno='{$phoneno}',companyname='{$companyname}' WHERE shop_url='{$shop_url}' and id={$address_id}";
		           $sql =   pg_query($dbconn4, "UPDATE pickup_address SET name ='{$name}' , address_line1='{$address_line1}', address_line2='{$address_line2}', city='{$city}', zipcode='{$zipcode}', phoneno='{$phoneno}',companyname='{$companyname}' WHERE shop_url='{$shop_url}' and id={$address_id}");
				echo "Address update  sucessfully";


			}
			else{
			 $sql = "insert into pickup_address (name,address_line1,address_line2,city ,zipcode,phoneno,shop_url,companyname) values ('$name','$address_line1','$address_line2','$city', '$zipcode','$phoneno','$shop_url','$companyname' )";
				$qry = pg_query($sql);
				if($qry){
				echo "Address save sucessfully";
				}
				else {
				echo "ERROR";
				}
			}
		}
?>
