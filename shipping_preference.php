<?php
session_start();
require __DIR__.'/connection.php'; //DB connectivity
	 $shop_url = $_POST['shop_url'];
	 $ship_company = $_REQUEST['company_prefered'];
		$user_exist = pg_query($dbconn4, "SELECT * FROM user_table WHERE store_url = '{$shop_url}'");
		if(pg_num_rows($user_exist)){
			$user_exist = pg_query($dbconn4, "UPDATE user_table SET  ship_preference='$ship_company'  WHERE store_url = '{$shop_url}'");
				if($user_exist){
					echo "Shipping Preference set sucessfully";

				}
		}
		else {
			$sql = "insert into user_table (ship_preference) values ('$ship_company')";
			$qry = pg_query($sql);
			if($qry){
				echo "Shipping Preference set sucessfully";
			}
		}
?>
