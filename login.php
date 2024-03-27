<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Login</title>
        <style>
            form {
            width: 300px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #f9f9f9;
        }

        label {
            display: block;
            margin-bottom: 10px;
            font-weight: bold;
        }

        input[type="text"],
        input[type="password"] {
            width: calc(100% - 20px);
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 3px;
            box-sizing: border-box;
        }

        input[type="submit"] {
            width: 100%;
            padding: 10px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 3px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }
        h1{
            text-align: center;
        }
        </style>
    </head>
    <body>
        <h1>Đăng nhập</h1>
        <?php
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'];
            $password = $_POST['password'];
            $connection = mysqli_connect('localhost', 'root', '', 'ql_nhansu');
            if (!$connection) {
                die("Kết nối thất bại: " . mysqli_connect_error());
            }
            $query = "SELECT * FROM user WHERE username = '$username' AND password = '$password'";
            $res = mysqli_query($connection, $query);
            if (!$res) {
                die("Lỗi: " . mysqli_error($connection));
            }
            if (mysqli_num_rows($res) == 1) {
                $user = mysqli_fetch_assoc($res);
                session_start();
                $_SESSION['user_id'] = $user['ID'];
                $_SESSION['username'] = $user['Username'];
                $_SESSION['fullname'] = $user['Fullname'];
                $_SESSION['email'] = $user['Email'];
                $_SESSION['role'] = $user['Role'];
                mysqli_close($connection);
                header('Location: list_NhanVien.php');
                exit();
            } else {
                echo "<p>Tên đăng nhập hoặc mật khẩu không đúng!</p>";
            }
            mysqli_close($connection);
        }
        ?>
        <form method="POST" action="login.php">
            <label for="username">Tên đăng nhập:</label>
            <input type="text" id="username" name="username" required><br><br>
            <label for="password">Mật khẩu:</label>
            <input type="password" id="password" name="password" required><br><br>
            <input type="submit" value="Đăng nhập">
        </form>
    </body>
</html>