<?php
	// if($_POST) {
	// 	if(isset($_POST['desc'])){
	// 		$select_all_links = "SELECT * FROM cms WHERE id!={$id} ORDER BY id DESC";
	// 	    $result_nav = $db->query($select_all_links);
	// 	    header('Location: admin.php');
	// 	}
	// 	echo "fail";
	// }
	return $select_all_except_1 = "SELECT * FROM cms WHERE title NOT LIKE 'Home%' ORDER BY id DESC";
	header('Location: admin.php');
	exit;
?>