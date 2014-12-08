<?php
	require('authenticate.php');   // authenticate for required login
    // contains the connection, and the dynamic ordering of nav links
    require('cms.php');
    
    // use the get superglobal to get the id number
    $id_num = $_GET['id'];

    // Run the query
    $select_page  = "SELECT * FROM cms WHERE id='{$id_num}' ";
    $result_page = $db->query($select_page);
    // Grab the values from the table
    while($row = $result_page->fetch_assoc()){
        $id = $row['id'];
        $title = $row['title'];
        $content = $row['content'];
        $permalink = $row['permalink'];
    }

    // check if the id from the GET superglobal is numeric, direct to index if not
    if(!is_numeric($id_num)){
        header('Location: index.php');
    }

    // change the timezone to Canada/Pacific, contain today's date
    date_default_timezone_set("Canada/Pacific");
    $today = date('Y-m-d H:i:s');
    // set the starting flag to false, no errors yet
    $error = false;

    // If the update is invoked
    if (isset($_POST['update'])) {
        // and if title, permalink, and content are set
        if( (isset($_POST['title']) && isset($_POST['permalink']) && 
            isset($_POST['content_edit'])) ) {
            // contain them in a variable
            $title_new = $_POST['title'];
            $content_new = $_POST['content_edit'];
            // pre-process entered string from the new content to ensure all texts only
            $permalink_new = $_POST['permalink'];
            // pre-process all inputs
            $content_new = $db->real_escape_string($content_new);
            $title_new = $db->real_escape_string($title_new);
            $permalink_new = $db->real_escape_string($permalink_new);

            // update query
            $update = "UPDATE cms" . 
                      " SET title='{$title_new}', content='{$content_new}', permalink='{$permalink_new}'," . 
                      " updated_at='{$today}' WHERE id='{$id_num}'";

            // ensure the new title and new permalink is not empty
            if(strlen($title_new) > 0 && strlen($permalink_new) > 0){
                // execute the query
                $result_update = $db->query($update);
                // redirect to the index
                header('Location: admin.php');
                exit;
            }
            else {
                // if it fails, raise error flag
                $error = true;
            }
        }
    }
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8" />
        <link rel="stylesheet" type="text/css" href="styles.css" />
        <title>Editing: <?= $title ?></title>
        <script src="//tinymce.cachefly.net/4.1/tinymce.min.js"></script>
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
        <h2> Editing Page </h2>
        <?php if ($error): ?>
            <h4 style="color: red"><?= "The title and permalink cannot be blank!"; ?></h4>
        <?php endif ?>
        <form method="post" action="" enctype="multipart/form-data">
            <p>
                Page Title: 
                <br />
                <!-- input text box's value contains the row's title -->
                <input id="title" name="title" type="text" value='<?= $title ?>' size="70" style="background-color: white"/>
            </p>
            <p>
                Content: 
                <br />
                <!-- textarea's value contains the row's content -->
                <textarea id="content_edit" name="content_edit" rows="15" style="background-color: white"><?= $content ?></textarea>
            </p>
            <p>
                Permalink: 
                <br />
                <!-- input text box's value contains the row's title -->
                <input id="permalink" name="permalink" type="text" value='<?= $permalink ?>' size="70" style="background-color: white"/>
            </p>
            <p>
                Image (optional)
                <br/>
                <input type="file" name="image" id="image" />
            </p>
            <p> 
                <input type="submit" name="update" value="Update" style="background-color: white; width: 200px" />
            </p>
        </form>
        <p><a href="admin.php">Return to admin</a></p>
        <div id="footer">
            <h5>Copywrong <?= date('Y') ?> - Every Rights</h5>
        </div> 
	</section>
</body>
</html>