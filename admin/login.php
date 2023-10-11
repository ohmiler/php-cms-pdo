<?php

    require_once "config.php";
    session_start();

    if (isset($_POST['login'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];

        try {
            $query = "SELECT * FROM admin WHERE username = :username AND password = :password";
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(':username', $username, PDO::PARAM_STR);
            $stmt->bindParam(':password', $password, PDO::PARAM_STR);
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                $_SESSION['username'] = $username;
                echo "<script>alert('Login Successfully');</script>";
                header("Location: index.php");
            } else {
                echo "<script>alert('Username or Password is incorrect');</script>";
            }
        } catch (PDOException $e) {
            die("Database error: " . $e->getMessage());
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login</title>
    <link rel="stylesheet" href="css/adminstyle.css">
</head>
<body>

    <center style="margin-top: 2rem;">
        <form method="post" action="login.php">
	
		<table width="400" border="1" align="center">
		
			<tr>
				<td bgcolor="yellow" colspan="4" align=
				"center"><h1>Admin Login form</h1></td>
			</tr>
			
			<tr>
				<td align="right">User Name:</td>
				<td><input type="text" name="username"></td>
			</tr>
			
			<tr>
				<td align="right">User Password:</td>
				<td><input type="password" name="password"></td>
			</tr>
			
			<tr>
				<td colspan="4" align="center"><input type="submit" name="login" value="Login"></td>
			</tr>
	
		</table>
	</form>
    </center>
    
</body>
</html>