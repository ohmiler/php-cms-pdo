<?php 

    require_once "config.php";


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Search Page</title>
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

            <h1>Search Result : </h1>

            <?php 

                try {
                    if (isset($_GET['search'])) {
                        $search_value = $_REQUEST['value'];
                    }

                    if (empty($search_value)) {
                        echo "<h3 style='margin-top:2rem; text-align: center; color:red;'>Oops!!, can not find any data type something</h3>";
                    } else {
                        $search_query = "SELECT * FROM posts WHERE post_title LIKE :search_value";
                        $stmt = $pdo->prepare($search_query);
                        $stmt->bindValue(':search_value', '%' . $search_value . '%', PDO::PARAM_STR);
                        $stmt->execute();

                        while ($search_row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                            $post_id = $search_row['post_id'];
                            $post_author = $search_row['post_author'];
                            $post_date = date('y-m-d');
                            $post_title = $search_row['post_title'];
                            $post_image = $search_row['post_image'];
                            $post_content = substr($search_row['post_content'], 0, 150);

            ?>

            <figure>
                <h1><a href="pages.php?id=<?php echo $post_id; ?>"><?php echo $post_title; ?></a></h1>
                <img width="640" height="360" src="img/<?php echo $post_image; ?>" alt="">
                <figcaption>
                    <p>Posted By <strong><?php echo $post_author; ?></strong> | Published on <strong><?php echo $post_date; ?></strong></p>
                    <p><?php echo $post_content; ?></p>
                </figcaption>
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