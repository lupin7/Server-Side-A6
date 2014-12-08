<?php
	require('connect.php');				// connect to the database
	// start the session to persist the order of links
	session_start();
	// if session already set
    if ( isset($_SESSION['order']) ){
    	// persist with a variable
        $select_all_except_1 = $_SESSION['order'];
    } else {
    	// if not set, set it up
        $select_all_except_1 = "SELECT * FROM cms WHERE title NOT LIKE 'Home%'";    
    }

    // if either the desc or asc is posted here, change the query
    if ( isset($_POST['desc']) ){
        $select_all_except_1 = "SELECT * FROM cms WHERE title NOT LIKE 'Home%' ORDER BY id DESC";
        header('Location: admin.php');
    } elseif ( isset($_POST['asc']) ){
    	$select_all_except_1 = "SELECT * FROM cms WHERE title NOT LIKE 'Home%' ORDER BY id ASC";
    	header('Location: admin.php');
    }

    // session will be the variable used for the query, execute it
    $_SESSION['order'] = $select_all_except_1;
    $result = $db->query($select_all_except_1);
?>