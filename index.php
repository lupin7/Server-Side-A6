<?php
	// contains the connection, and the dynamic ordering of nav links
	require('cms.php');
	// the home will be any title with "Home" and anything after it
	// limit the search to 1
    $select_home = "SELECT * FROM cms WHERE title LIKE 'Home%' LIMIT 1";
	$home_page = $db->query($select_home);

	// get the id passed from the get, for later use
	if(isset($_GET['id'])) {
		$id_num = $_GET['id'];
		// a selected page query, to show later
		$select_page = "SELECT * FROM cms WHERE id='{$id_num}'";
		$page = $db->query($select_page);
	}
?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8" />
		<link rel="stylesheet" type="text/css" href="styles.css" />
		<title>Content Management System</title>
	</head>
<body>
	<section id="content">
		<header>
			<h1>Content Management System</h1>
			<p id="admin_link"><a href="admin.php">Admin</a></p>
		</header>
		<?php if ($result->num_rows): ?>
		<div id = "navigation">
			<nav>
				<ul>
					<li><a href = "index.php">Home</a></li>
					<?php while($row = $result->fetch_assoc()): ?>
						<li><a href="?id=<?= $row['id'] ?>&amp;p=<?= $row['permalink'] ?>"><?= $row['title'] ?></a></li>
					<?php endwhile ?>
				</ul>
			</nav>
		</div>
		<?php endif ?>
		<?php if (!isset($_GET['id'])): ?>
			<?php if ($home_page->num_rows): ?>
				<?php while($page_row = $home_page->fetch_assoc()): ?>
					<?php $content = $page_row['content']; ?>
					
					<h3><?= $page_row['title']?></h3>
					<?= $content ?>
			        <h5 class="right">Created: <?= $page_row['created_at'] ?> | Updated: <?= $page_row['updated_at'] ?></h5>
				<?php endwhile ?>
			<?php else: ?>
				<h3>No home page set</h3>
				<p>To set a home page, set the title and permalink to contain "Home" to start with</p>
			<?php endif ?>
		<?php else: ?>
			<?php while($page_show = $page->fetch_assoc()): ?>
				<?php $content = $page_show['content']; ?>
				
				<h3><?= $page_show['title']?></h3>
				<?= $content ?>
		        <h5 class="right">Created: <?= $page_show['created_at'] ?> | Updated: <?= $page_show['updated_at'] ?></h5>
			<?php endwhile ?>
		<?php endif ?>
		<div id="footer">
	        <h5 class="left">Copywrong <?= date('Y') ?> - Every Rights</h5>
	    </div>
	</section>
</body>

</html>