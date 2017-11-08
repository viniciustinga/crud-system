<?php 
include("database.php");
include("function.php");

// insert or update user data into users table
if(isset($_POST["operation"]))
{
	// "Add" operation
	if($_POST["operation"] == "Add")
	{
		// check and upload image
		$image = '';

		if($_FILES["user_image"]["name"] != '')
		{
			$image = upload_image();
		}

		// prepare statement to add user
		$statement = $connection->prepare("
			INSERT INTO users (first_name, last_name, image)
			VALUES (:first_name, :last_name, :image)
		");

		// execute statement to add user
		$result = $statement->execute(
			array(
				':first_name'	=>	$_POST["first_name"],
				':last_name'	=>	$_POST["last_name"],
				':image'		=>	$image
			)
		);

		// check if $result is not empty
		if(!empty($result))
		{
			echo 'Data Inserted';
		}
	}

	// "Edit" operation
	if($_POST["operation"] == "Edit")
	{
		// check and upload image
		$image = '';

		if($_FILES["user_image"]["name"] != '')
		{
			$image = upload_image();
		}

		else
		{
			$image = $_POST["hidden_user_image"];
		}

		// prepare statement to update user
		$statement = $connection->prepare("
			UPDATE users
			SET first_name = :first_name, last_name = :last_name, image = :image WHERE id = :id"
		);

		// execute statement to update
		$statement->execute(
			array(
				':first_name'	=>	$_POST["first_name"],
				':last_name'	=>	$_POST["last_name"],
				':image'		=>	$image,
				':id'	=>	$_POST["user_id"]
			)
		);
		echo 'Data Updated';	
	}	
}

?>