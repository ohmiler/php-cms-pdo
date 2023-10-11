<?php 

    require_once "config.php";


    try {
        if (isset($_GET['del'])) {
            $delete_id = $_GET['del'];

            $delete_query = "DELETE FROM posts WHERE post_id = :delete_id";
            $stmt = $pdo->prepare($delete_query);
            $stmt->bindParam(':delete_id', $delete_id, PDO::PARAM_INT);

            if ($stmt->execute()) {
                echo "<script>alert('Post Has been Deleted')</script>";
                header("location: view_posts.php");
            } else {
                echo "<script>alert('Failed to delete the post')</script>";
            }
        }
    } catch (PDOException $e) {
        die("Database error: " . $e->getMessage());
    }


?>