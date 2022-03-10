<!-- so this page should contain the user information etc -->

<?php
	require_once "includes/header.php";
?>


<main id="pg-main-content" class="container-fluid">




	<div class="row my-background">

	<?php
	
		if ($_SESSION['suspended'] == true){

			echo "<h4> Your account is suspended until further notice. </h4>";
		}
	
	?>

	<div class="col-sm-8 mx-auto background pt-5">

	<h4 class= "pt-5" > For updating any of your fields just change: the new email or first name or last name, and press submit, without changing any of the other fields, that you do not wish to be changed</h4>

	<img src="img/user-profile.png" alt="User Image" width="150" height="150">

<form method="post" action="profile.php">
  <div class="form-row">
    <div class="col-md-4 mb-3">
      <label for="validationDefault01">First name</label>
      <input type="text" class="form-control" id="validationDefault01" name ="i-fname" placeholder="First name" value="<?php echo $_SESSION['firstname'];?>" required>
    </div>
    <div class="col-md-4 mb-3">
      <label for="validationDefault02">Last name</label>
      <input type="text" class="form-control" id="validationDefault02" name ="i-lname" placeholder="Last name" value="<?php echo $_SESSION['lastname'];?>" required>
    </div>
    <div class="col-md-4 mb-3">
      <label for="validationDefaultUsername">Username</label>
      <div class="input-group">
        <div class="input-group-prepend">
          <span class="input-group-text" id="inputGroupPrepend2">@</span>
        </div>
        <input type="text" name ="i-email" class="form-control" id="validationDefaultUsername" placeholder="Username" aria-describedby="inputGroupPrepend2" value="<?php echo $_SESSION['email'];?>" required>
      </div>

			<!-- this is for the password -->
			<div class="col-md-4 mb-3">
      <label for="validationDefault02">Password</label>
			<!-- password is disabled, and not shown -->
      <input type="password" class="form-control" id="validationDefault02" placeholder="Last name" value="<?php echo $_SESSION['password'];?>" disabled>
    </div>
    </div>

  </div>
  <button class="btn btn-primary" name="update" type="submit" >Submit form</button>
</form>

</div>
		</div>

		</main>

<?php

//here is the form processing for updating the fields of the user

if (isset($_REQUEST['update'])){

	echo "hellooo";
	
	$id = $_SESSION['userID'];
	$loginID = $_SESSION['login_id'];

	$email = sanitizeData($_REQUEST['i-email']);
  $lname = sanitizeData($_REQUEST['i-lname']);
	$fname = sanitizeData($_REQUEST['i-fname']);

	//checking which fields changed 

	if (!(strcmp($email, $_SESSION['email']) == 0)){

		$sql = "UPDATE `cb_login` SET cb_login_email = '$email' WHERE cb_login_id= '$loginID'";
		$result1 = $db->query($sql);
	}

	if (!(strcmp($fname, $_SESSION['firstname']) == 0)){

		$sql = "UPDATE `cb_users` SET cb_user_firstname = '$fname' WHERE cb_user_id= '$id'";
		$result2 = $db->query($sql);

	}

	if (!(strcmp($lname, $_SESSION['lastname']) == 0)){

		$sql = "UPDATE `cb_users` SET cb_user_lastname = '$lname' WHERE cb_user_id= '$id'";
		$result3 = $db->query($sql);
	}

	//after we updated it in the database we need to update the session variables as well

	$_SESSION['email'] = $email;
	$_SESSION['firstname'] = $fname;
	$_SESSION['lastname'] = $lname;

	/*

	1. check which fields are actually set using if else statments, aka (if email, not equal to the session variable then.. execute an update statement) [done]

	2. don't forget to update the session variable as well [Done]

	3. then after you do this we will check the part of deleting the user account, and make sure that it is deleted from all the tables in the database, (aka from login, all their posts are deleted all if they had reported posts those are deleted too, etc, and finally we will need to redirect them to logout.php to delete the session (because we don't need to do so on our own))

	/////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	-- Everything seems to be working fine, but there seems to be a glitch when updating everything, I think it will go away when we implement the asynchronous communication

	*/

	//next we work on deleting the user from all the tables

}
?>


<?php
require_once "includes/footer.php";
?>
