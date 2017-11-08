<?php 
// return total records of users table
function get_total_all_records()
{
	include("database.php");
	$statement = $connection->prepare("SELECT * FROM users");
	$statement->execute();
	$result = $statement->fetchAll();
	return $statement->rowCount();
}

// upload image to uploaded file destination and return image name
function upload_image()
{
	$extension = explode(".", $_FILES['user_image']['name']);
	$new_name = rand() . "." . $extension[1];
	$destination = './upload/' . $new_name;
	move_uploaded_file($_FILES['user_image']['tmp_name'], $destination);
	return $new_name;
}
?>