<?php 

    require_once "config.php";

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Index</title>
    <link rel="stylesheet" href="css/main.css">
</head>
<body>
    

    <header>
        <div class="container">
            <div class="logo">
                <h1><a href="index.php">MilerCMS</a></h1>
            </div>

            <form action="search.php" method="get" enctype="multipart/form-data">
                <input type="text" name="value" placeholder="search topic" size="25">
                <input type="submit" name="search" value="search">
            </form>
            
        </div>
    </header>

    <section class="content">
        <div class="container">


            <?php 

            try {

                $select_posts = "SELECT * FROM posts";
                $stmt = $pdo->query($select_posts);

                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    $post_id = $row['post_id'];
                    $post_date = $row['post_date'];
                    $post_author = $row['post_author'];
                    $post_title = $row['post_title'];
                    $post_image = $row['post_image'];
                    $post_content = substr($row['post_content'], 0, 300);
            ?>

            <figure>
                <h1><a href="page.php?id=<?php echo $post_id; ?>"><?php echo $post_title; ?></a></h1>
                <img width="640" height="360" src="img/<?php echo $post_image; ?>" alt="">
                <figcaption>
                    <p>Posted By <strong><?php echo $post_author; ?></strong> | Published on <strong><?php echo $post_date; ?></strong></p>
                    <p><?php echo $post_content; ?></p>
                    <a href="page.php?id=<?php echo $post_id; ?>">Read More</a>
                </figcaption>
            </figure>

            <?php 

                }
            } catch (PDOException $e) {
                die("Failed to fetch posts: " . $e->getMessage());
            }
            
            ?>
        </div>
    </section>

</body>
</html>