<?php
	require('connect.php');				// connect to the database
	// declare an id variable
	$id = '';
	// if the id is posted, grab it's value
	if($_POST['id']) {
		$id = $_POST['id'];
	}
	// execute the query as the id identified to the specific link
	$delete_query = "DELETE FROM cms WHERE id={$id} ";
	$result_del = $db->query($delete_query);
	// redirect to the admin
	header('Location: admin.php');
?>