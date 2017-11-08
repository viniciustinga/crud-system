<?php 
include("database.php");
include("function.php");

// delete user $_POST["user_id"]
if(isset($_POST["user_id"]))
{
	// prepare statement to delete user
	$statement = $connection->prepare(
		"DELETE FROM users WHERE id = :id"
	);

	// execute statement to delete user
	$result = $statement->execute(
		array(
			':id'	=>	$_POST["user_id"]
		)
	);

	echo 'Data Deleted';
}
	
?>