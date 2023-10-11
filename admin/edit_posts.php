<?php 

    session_start();

    require_once "config.php";

    if (!isset($_SESSION['username'])) {
        header("location: login.php");
    }


    try {
        if (isset($_GET['edit'])) {
            $edit_id = $_GET['edit'];
    
            $edit_query = "SELECT * FROM posts WHERE post_id = :edit_id";
            $stmt = $pdo->prepare($edit_query);
            $stmt->bindParam(':edit_id', $edit_id, PDO::PARAM_INT);
            $stmt->execute();
    
            if ($stmt->rowCount() > 0) {
                $edit_row = $stmt->fetch(PDO::FETCH_ASSOC);
    
                $post_id = $edit_row['post_id'];
                $post_title = $edit_row['post_title'];
                $post_author = $edit_row['post_author'];
                $post_date = date('y-m-d');
                $post_keywords = $edit_row['post_keywords'];
                $post_image = $edit_row['post_image'];
                $post_content = $edit_row['post_content'];
            }
        }
    
        if (isset($_POST['submit'])) {
            $update_id = $_GET['edit_form'];
            $post_title = $_POST['title'];
            $post_date = date('m-d-y');
            $post_author = $_POST['author'];
            $post_keywords = $_POST['keywords'];
            $post_content = $_POST['content'];
            $post_image = $_FILES['image']['name'];
            $image_tmp = $_FILES['image']['tmp_name'];
            $image_path = "../img/$post_image";
    
            if (move_uploaded_file($image_tmp, $image_path)) {
                $update_query = "UPDATE posts SET post_title = :post_title, post_date = :post_date, post_author = :post_author,
                                post_image = :post_image, post_keywords = :post_keywords, post_content = :post_content WHERE post_id = :update_id";
    
                $stmt = $pdo->prepare($update_query);
                $stmt->bindParam(':post_title', $post_title, PDO::PARAM_STR);
                $stmt->bindParam(':post_date', $post_date, PDO::PARAM_STR);
                $stmt->bindParam(':post_author', $post_author, PDO::PARAM_STR);
                $stmt->bindParam(':post_image', $post_image, PDO::PARAM_STR);
                $stmt->bindParam(':post_keywords', $post_keywords, PDO::PARAM_STR);
                $stmt->bindParam(':post_content', $post_content, PDO::PARAM_STR);
                $stmt->bindParam(':update_id', $update_id, PDO::PARAM_INT);
    
                if ($stmt->execute()) {
                    echo "<script>alert('Post has been updated');</script>";
                    header("location: view_posts.php");
                } else {
                    echo "<script>alert('Something went wrong!');</script>";
                }
            } else {
                echo "<script>alert('Failed to upload the image');</script>";
            }
        }
    } catch (PDOException $e) {
        die("Database error: " . $e->getMessage());
    }


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Insert Post</title>
    <link rel="stylesheet" href="css/adminstyle.css">
</head>
<body>
    
    <header>
        <div class="container">
            <h1>Welcome to Admin Page Mr. <?php echo $_SESSION['username']; ?> </h1>
        </div>
    </header>

    <section class="content">
        <div class="content__grid">
            <div class="sidebar">
                <h1>Welcome : </h1>
                <h3><a href="index.php">Home</a></h3>
                <h3><a href="view_posts.php">View Posts</a></h3>
                <h3><a href="insert_post.php">Insert Post</a></h3>
                <h3><a href="logout.php">Log out</a></h3>
            </div>
            <div class="showinfo">
                <h1>Edit Post</h1>

                <form method="post" action="edit_posts.php?edit_form=<?php echo $post_id; ?>" enctype="multipart/form-data">

                <table width="100%" align="center" border="1">
                    
                    <tr>
                        <td align="center" colspan="6">
                        <h1>Edit The Post Here</h1></td>
                    </tr>
                    
                    <tr>
                        <td align="right">Post Title:</td>
                        <td><input type="text" name="title" size="50" value="<?php echo $post_title; ?>"></td>
                    </tr>
                    
                    <tr>
                        <td align="right">Post Author :</td>
                        <td><input type="text" name="author" size="50" value="<?php echo $post_author; ?>"></td>
                    </tr>
                    
                    <tr>
                        <td align="right">Post Keywords:</td>
                        <td><input type="text" name="keywords" size="50" value="<?php echo $post_keywords; ?>"></td>
                    </tr>
                    
                    <tr>
                        <td align="right">Post Image:</td>
                        <td><input type="file" name="image"><img src="../img/<?php echo $post_image; ?>" width="100" height="100" alt=""></td>
                    </tr>
                    
                    <tr>
                        <td align="right">Post Content:</td>
                        <td><textarea name="content" cols="50" rows="15"><?php echo $post_content; ?>"</textarea></td>
                    </tr>
                    
                    <tr>
                        <td align="center" colspan="6"><input type="submit" name="submit" value="Update Now"></td>
                    </tr>

                </table>
            </form>

            </div>
        </div>
    </section>

</body>
</html>