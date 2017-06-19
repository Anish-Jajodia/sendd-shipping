<?php 
$shop_url =$_REQUEST['shop'];
require __DIR__.'/connection.php'; //DB connectivity
echo '<div class="pickupadreess">';
$pickup_address = pg_query($dbconn4, "SELECT * FROM pickup_address WHERE shop_url = '{$shop_url}'");
	if(pg_num_rows($pickup_address)){
		$i=1;
		
		while ($row = pg_fetch_assoc($pickup_address)) {?>
		<div class='formmain'>
			<h3>Pickup Address <?php echo $i; ?></h3>
  <form action="" method="POST" id="form_<?php echo $i; ?>">
    <input name="saveaddress" type="hidden" value="<?php echo $i; ?>"><input type="hidden" name="shop_url" value="<?php echo $shop_url; ?>">
	<input type="text" name="companyname" placeholder="Company Name" value="<?php echo trim($row['companyname'])?>" required>
    <input type="text" name="username" placeholder="Name" value="<?php echo trim($row['name'])?>" required>
    <textarea  name="address_line1" placeholder="Adrress 1" required maxlength="60"><?php echo trim($row['address_line1']);?></textarea>
    <textarea name="address_line2" placeholder="Adrress 2"  maxlength="60"><?php echo trim($row['address_line2']);?></textarea>
	<input value="<?php echo trim($row['city']);?>" type="text" name="city" placeholder="City" required>
    <input value="<?php echo trim($row['zipcode']);?>" type="text" name="zipcode" placeholder="Zip Code" required>
    <input value="<?php echo trim($row['phoneno']);?>" type="text" name="phoneno" placeholder="Phone no" required>
    <input value="Save Address" type="button" id="<?php echo $i ?>" class="savebtn" name="saveaddress" value="Save Address">
			</form></div>
		<?php
		$i++;
		}
	}
	
	?>
		<div class="addnewaddress"></div>
  
	<br/>
	<input type="button" id="add_new_address" value="Add New Address" /><br/> 
</div>
<script>
$("#add_new_address").click(function() {
var address_id = parseInt($('body .formmain').length+1);	
	var planDiv = '<div class="formmain"><h3>Pickup Address '+address_id+'</h3> <form action="" method="POST" id="form_'+address_id+'"><input type="hidden" name="shop_url" value="<?php echo $shop_url; ?>"><input type="hidden" value="'+address_id+'" name="saveaddress" ><input type="text" placeholder="Company Name" name="companyname" value="" required><input type="text" placeholder="Name" name="username" value="" required><textarea name="address_line1"  required maxlength="60" placeholder="Address 1"></textarea><textarea name="address_line2"  maxlength="60" placeholder="Adrress 2"></textarea><input type="text" name="city" value="" required placeholder="city"><input type="text" name="zipcode" placeholder="Zip Code" value="" required><input type="text" name="phoneno" placeholder="Phone No" value="" required> <input type="button" name="saveaddress"  id="'+address_id+'" class="savebtn" value="Save Address"></form></div>'; 
		$("div[class^=addnewaddress]:last").after(planDiv);
	});

	$('body').on('click', '.savebtn', function(e) {
	   e.preventDefault();
	   var get_id = $(this).attr('id');
	   
		if(($("body #form_"+get_id+" input[name=username]").val()!='') && ($("body #form_"+get_id+" input[name=address_line1]").text()!='')&& ($("body #form_"+get_id+" input[name=companyname]").text()!='')&& ($("body #form_"+get_id+ "input[name=city]").val()!='')&& ($("body #form_"+get_id+" input[name=zipcode]").val()!='')&& ($("body #form_"+get_id+" input[name=phoneno]").val()!='')){
		$(this).val('Adding...');
		var formdata = $('body #form_'+get_id).serialize();
		$.ajax({
			type: 'POST',
			url: '/checklogin.php',
			data: formdata,
			success: function(resp){
	        	alert(resp);
				$(this).val('Save Address');				
			}
		});
		}
		else{
		alert("Please fill the all fields");	
		}
	});
</script>

