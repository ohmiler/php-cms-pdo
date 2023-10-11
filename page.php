<?php 

    require_once "config.php";

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Post Page</title>
    <link rel="stylesheet" href="css/main.css">
</head>
<body>

    <header>
        <div class="container">
            <div class="logo">
                <h1><a href="index.php">MilerCMS</a></h1>
            </div>
        </div>
    </header>

    <section class="content">
        <div class="container">
            <?php 

                try {
                    if (isset($_GET['id'])) {
                        $page_id = $_GET['id'];
                        
                        $select_posts = "SELECT * FROM posts WHERE post_id = :page_id";
                        $stmt = $pdo->prepare($select_posts);
                        $stmt->bindParam(':page_id', $page_id, PDO::PARAM_INT);
                        $stmt->execute();

                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                            $post_id = $row['post_id'];
                            $post_date = $row['post_date'];
                            $post_author = $row['post_author'];
                            $post_title = $row['post_title'];
                            $post_image = $row['post_image'];
                            $post_content = $row['post_content'];
            ?>

        <figure>
            <h1><?php echo $post_title; ?></h1>
            <img width="640" height="360" src="img/<?php echo $post_image; ?>" alt="">
            <figcaption>
                <p>Posted By <strong><?php echo $post_author; ?></strong> | Published on <strong><?php echo $post_date; ?></strong></p>
                <p><?php echo $post_content; ?></p>
            </figcaption>

            <hr>
            <a href="index.php">Go back</a>

        </figure>


        <?php 
                    }
                }
            } catch (PDOException $e) {
                die("Database error: " . $e->getMessage());
            }
        ?>



    </section>

    
</body>
</html>