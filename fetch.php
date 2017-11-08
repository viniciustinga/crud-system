<?php
include('database.php');
include('function.php');
$query = '';
$output = array();
$query .= "SELECT * FROM users ";

// search box query for first_name and last_name
if(isset($_POST["search"]["value"]))
{
	$query .= 'WHERE first_name LIKE "%'.$_POST["search"]["value"].'%" ';
	$query .= 'OR last_name LIKE "%'.$_POST["search"]["value"].'%" ';
}

// change the column order
if(isset($_POST["order"]))
{
	$query .= 'ORDER BY '.$_POST['order']['0']['column'].' '.$_POST['order']['0']['dir'].' ';
}
else
{
	$query .= 'ORDER BY id DESC ';
}

// limit data per page
if($_POST["length"] != -1)
{
	$query .= 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
}

// prepare, execute and fetch query
$statement = $connection->prepare($query);
$statement->execute();
$result = $statement->fetchAll();

$data = array(); // store user data

$filtered_rows = $statement->rowCount(); // return number of $result rows 

// fetch data from $result
foreach($result as $row)
{
	$image = '';
	if($row["image"] != '')
	{
		$image = '<img src="upload/'.$row["image"].'" class="img-thumbnail" width="50" height="35" />';
	}
	else
	{
		$image = '';
	}

	// put data into $sub_array
	$sub_array = array();
	$sub_array[] = $image;
	$sub_array[] = $row["first_name"];
	$sub_array[] = $row["last_name"];
	$sub_array[] = '<button type="button" name="update" id="'.$row["id"].'" class="btn btn-warning btn-xs update">Update</button>';
	$sub_array[] = '<button type="button" name="delete" id="'.$row["id"].'" class="btn btn-danger btn-xs delete">Delete</button>';

	// store $sub_array data into $data[]
	$data[] = $sub_array;
}

// store all data into $output
$output = array(
	"draw"				=>	intval($_POST["draw"]),
	"recordsTotal"		=> 	$filtered_rows,
	"recordsFiltered"	=>	get_total_all_records(),
	"data"				=>	$data
);

// convert $output array to json string and send to ajax request
echo json_encode($output);

?>