<?php 
include("database.php");
include("function.php");

// fetch user with this $_POST["user_id"]
if(isset($_POST["user_id"]))
{
	$output = array();

	// prepare statement to fetch user
	$statement = $connection->prepare(
		"SELECT * FROM users 
		WHERE id = '".$_POST["user_id"]."'
		LIMIT 1"
	);

	// execute statement to fetch user
	$statement->execute();
	$result = $statement->fetchAll();

	// fetch data from $result
	foreach($result as $row)
	{
		$output["first_name"] = $row["first_name"];
		$output["last_name"] = $row["last_name"];

		// check if image is not equal to blank
		if($row["image"] != '')
		{
			$output["user_image"] = '
			<img src="upload/'.$row["image"].'" class="img-thumbnail" width="50" height="35" />
			<input type="hidden" name="hidden_user_image" value="'.$row["image"].'" />
			';
		}

		else
		{
			$output["user_image"] = '<input type="hidden" name="hidden_user_image" value="" /';
		} 	
	}

	// convert $output array to json string and send to ajax request
	echo json_encode($output);	
}

?>