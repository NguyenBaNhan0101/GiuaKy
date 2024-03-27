<?php
    session_start();
    if (!isset($_SESSION['user_id'])) {
        header('Location: login.php');
        exit();
    }

    $username = $_SESSION['username'];
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Thông Tin Nhân Viên</title>
        <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
        }

        table {
            border-collapse: collapse;
            width: 100%;
        }

        th, td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        .thumbnail {
            width: 50px;
        }

        .logout-button, .add-button {
            display: inline-block;
            padding: 10px 20px;
            margin-bottom: 10px;
            border: none;
            border-radius: 3px;
            cursor: pointer;
            text-decoration: none;
            transition: background-color 0.3s ease;
        }

        .logout-button {
            background-color: #f44336;
            color: white;
            margin-right: 10px;
        }

        .logout-button:hover {
            background-color: #d32f2f;
        }

        .add-button {
            background-color: #4CAF50;
            color: white;
        }

        .add-button:hover {
            background-color: #45a049;
        }

        .action-links a {
            text-decoration: none;
            color: #007bff;
            margin-right: 10px;
        }

        .action-links a:hover {
            text-decoration: underline;
        }
    </style>

    </head>
    <body>
        <div class="container">
            <h2>Xin chào <?php echo $username; ?></h2>
            <?php
                $role = $_SESSION['role'];
                if ($role === 'admin') {
                    echo '<a href="add_NhanVien.php" class="add-button">Thêm nhân viên</a>';
                }
            ?>
            <a href="logout.php" class="logout-button">Thoát</a>
            <h1>THÔNG TIN NHÂN VIÊN</h1>
            <?php
                $connection = mysqli_connect('localhost', 'root', '', 'ql_nhansu');
                if (!$connection) {
                    die("Kết nối thất bại: " . mysqli_connect_error());
                }
                $page = isset($_GET['page']) ? $_GET['page'] : 1;
                $limit = 5;
                $start = ($page - 1) * $limit;
                $query = "SELECT Ma_NV, Ten_NV, Phai, Noi_Sinh, Ma_Phong, Luong FROM NHANVIEN LIMIT $start, $limit";
                $result = mysqli_query($connection, $query);

                if (!$result) {
                    die("Lỗi: " . mysqli_error($connection));
                }
            ?>

            <div id="data-container">
                <table>
                    <tr>
                        <th>Mã Nhân Viên</th>
                        <th>Tên Nhân Viên</th>
                        <th>Phái</th>
                        <th>Nơi Sinh</th>
                        <th>Mã Phòng</th>
                        <th>Lương</th>
                        <th>Action</th>
                    </tr>
                    <?php
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>";
                        echo "<td>" . $row['Ma_NV'] . "</td>";
                        echo "<td>" . $row['Ten_NV'] . "</td>";
                        echo "<td><img class='thumbnail' src='http://localhost/GiuaKy/images/" . ($row['Phai'] == 'NU' ? 'woman.jpg' : 'man.jpg') . "' alt='Hình ảnh'></td>";
                        echo "<td>" . $row['Noi_Sinh'] . "</td>";
                        echo "<td>" . $row['Ma_Phong'] . "</td>";
                        echo "<td>" . $row['Luong'] . "</td>";
                        if ($role === 'admin') {
                            echo "<td><a href='edit_NhanVien.php?id=" . $row['Ma_NV'] . "'>Sửa</a> | <a href='delete_NhanVien.php?id=" . $row['Ma_NV'] . "'>Xóa</a></td>";
                        }
                        echo "</tr>";
                    }
                    ?>
                </table>
            </div>
            <?php
                $totalQuery = "SELECT COUNT(*) AS total FROM NHANVIEN";
                $totalResult = mysqli_query($connection, $totalQuery);
                $totalRow = mysqli_fetch_assoc($totalResult);
                $totalEmployees = $totalRow['total'];

                $totalPages = ceil($totalEmployees / $limit);

                echo "<div>";
                for ($i = 1; $i <= $totalPages; $i++) {
                    echo "<a href='?page=$i' style='display: inline-block; padding: 8px 12px; margin-right: 5px; background-color: #007bff; color: #fff; text-decoration: none; border-radius: 3px;'>$i</a>
                    ";
                }
                echo "</div>";
            ?>
        </div>
    </body>
</html>

<?php
    mysqli_close($connection);
?>