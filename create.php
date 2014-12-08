<?php
	require('authenticate.php');       // require an authentication
    // contains the connection, and the dynamic ordering of nav links
    require('cms.php');
    
    // set starting error flag to false, no errors yet
    $error = false;
    // if the title, permalink, and content is posted
    if( (isset($_POST['title']) && isset($_POST['permalink']) && 
        isset($_POST['content_create']))  ){
        // store them in variables
        $title = $_POST['title'];
        $permalink = $_POST['permalink'];
        $content = $_POST['content_create'];
        // pre-process all inputs
        $title = $db->real_escape_string($title);
        $permalink = $db->real_escape_string($permalink);
        $content = $db->real_escape_string($content);
        
        // adjust the timezone, grab today's date in a variable
        date_default_timezone_set("Canada/Pacific");
        $today = date('Y-m-d H:i:s');
        // insert query
        $add_page  = "INSERT INTO cms (title, permalink, content, created_at, updated_at) VALUES ('{$title}', '{$permalink}', '{$content}', '{$today}', '{$today}')";
        
        // if the length of the string of both the title and content is greater than 0
        if( strlen($title) > 0 && strlen($permalink) > 0){
            // execute the query
            $result = $db->query($add_page);
            // redirect to the index
            header('Location: admin.php');
            exit;
        }
        else {
            // if condition fails, raise error flag
            $error = true;
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <link rel="stylesheet" type="text/css" href="styles.css" />
        <title>Content Management System</title>
        <script src="tinymce/js/tinymce/tinymce.min.js"></script>
        <script>tinymce.init({selector:'textarea'});</script>
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
                        <li><a href="./?id=<?= $row['id'] ?>&amp;p=<?= $row['permalink'] ?>"><?= $row['title'] ?></a></li>
                    <?php endwhile ?>
                </ul>
            </nav>
        </div>
        <?php endif ?>
        <br />
        <h2> New Page </h2>
        <?php if ($error): ?>
            <h4 style="color: red"><?= "The title and permalink cannot be blank!"; ?></h4>
        <?php endif ?>
        <form method="post" action="create.php">
            <p>
                Page Title: 
                <br />
                <!-- input text box's value contains the row's title -->
                <input id="title" name="title" type="text" size="70" style="background-color: white"/>
            </p>
            <p>
                Content: 
                <br />
                <!-- textarea's value contains the row's content -->
                <textarea id="content_create" name="content_create" rows="15" style="width: 200px"></textarea>
            </p>
            <p>
                Permalink: 
                <br />
                <!-- input text box's value contains the row's title -->
                <input id="permalink" name="permalink" type="text" size="70" style="background-color: white"/>
            </p>
            <p>
                Image (optional)
                <br/>
                <input type="file" name="image" id="image" />
            </p>
            <p> 
                <input type="submit" name="create" value="Create" style="background-color: white" />
            </p>
        </form>
        <p><a href="admin.php">Return to admin</a></p>
	    <div id="footer">
            <h5>Copywrong <?= date('Y') ?> - Every Rights</h5>
        </div> 
    </section>
</body>
</html>