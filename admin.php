<?php
	require('authenticate.php');    // require an authentication
    // contains the connection, and dynamic ordering of nav links
    require('cms.php');
    // query for all the links created
    $select_all = "SELECT * FROM cms ORDER BY id DESC";
    $result2 = $db->query($select_all);
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
        <?php if ($result->num_rows && $result2->num_rows): ?>
        <div id = "navigation">
            <nav>
                <ul>
                    <li><a href = "index.php">Home</a></li>
                    <?php while($row = $result->fetch_assoc()): ?>
                        <li><a href="./?id=<?= $row['id'] ?>&amp;p=<?= $row['permalink'] ?>"><?= $row['title'] ?></a></li>
                    <?php endwhile ?>
                </ul>
            </nav>
        </div>
        <?php endif ?>
        <br />
        <h2> Page Administration </h2>
        <a href="create.php" id="create_page">Create New Page</a>
        <?php if ($result2->num_rows): ?>
        <div>
            <ul>
                <?php while($row = $result2->fetch_assoc()): ?>
                    <li><a class="link" href="edit.php?id=<?= $row['id'] ?>"><?= $row['title'] ?></a>
                        <form class="delete" action="delete.php" method="post">
                            <div class="inline">
                                <input class="confirm" type="submit" name="command" value="delete" onclick="return confirm('Are you sure you wish to delete this post?')"/>
                                <input type="hidden" name="id" value="<?= $row['id'] ?>"/>
                            </div>
                        </form>
                    </li>
                <?php endwhile ?>
            </ul>
        </div>
        <div>
            <form action="cms.php" method="post">
                <div class="inline">
                    <input class="confirm" type="submit" name="command" value="Ascending" />
                    <input type="hidden" name="asc" value="ASC" />
                </div>
            </form>
            
            <form action="cms.php" method="post">
                <div class="inline">
                    <input class="confirm" type="submit" name="command" value="Descending" />
                    <input type="hidden" name="desc" value="DESC" />
                </div>
            </form>
        </div>
        <?php endif ?>
        <div id="footer">
            <h5 class="left">Copywrong <?= date('Y') ?> - Every Rights</h5>
        </div>
    </section>
</body>
</html>