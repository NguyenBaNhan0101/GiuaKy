<?php
    $connection = mysqli_connect('localhost', 'root', '', 'ql_nhansu');
    if (!$connection) {
        die("Kết nối thất bại: " . mysqli_connect_error());
    }
    $query = "SELECT Ma_Phong, Ten_Phong FROM PHONGBAN";
    $result = mysqli_query($connection, $query);
    if (mysqli_num_rows($result) > 0) {
        $phongBanOptions = '';
        while ($row = mysqli_fetch_assoc($result)) {
            $maPhong = $row['Ma_Phong'];
            $tenPhong = $row['Ten_Phong'];
            $phongBanOptions .= "<option value='$maPhong'>$tenPhong</option>";
        }
    } else {
        echo "Không có dữ liệu!";
    }
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $maNV = $_POST['maNV'];
        $tenNV = $_POST['tenNV'];
        $phai = $_POST['phai'];
        $noiSinh = $_POST['noiSinh'];
        $maPhong = $_POST['maPhong'];
        $luong = $_POST['luong'];

        $query = "INSERT INTO NHANVIEN (Ma_NV, Ten_NV, Phai, Noi_Sinh, Ma_Phong, Luong) VALUES ('$maNV', '$tenNV', '$phai', '$noiSinh', '$maPhong', '$luong')";
        $result = mysqli_query($connection, $query);

        if ($result) {
            header("Location: employee_list.php");
            exit();
        } else {
            echo "Lỗi: " . mysqli_error($connection);
        }
    }
    mysqli_close($connection);
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Thêm nhân viên</title>
        <link href="/GiuaKy/styles.css" rel="stylesheet"/>
    </head>
    <body>
        <div class="container">
            <h1>Thêm nhân viên</h1>
            <form method="POST" action="add_employee.php">
                <label for="maNV">Mã nhân viên:</label>
                <input type="text" id="maNV" name="maNV" required>

                <label for="tenNV">Tên nhân viên:</label>
                <input type="text" id="tenNV" name="tenNV" required>

                <label for="phai">Phái:</label>
                <select id="phai" name="phai">
                    <option value="NU">Nữ</option>
                    <option value="NAM">Nam</option>
                </select>

                <label for="noiSinh">Nơi sinh:</label>
                <input type="text" id="noiSinh" name="noiSinh" required>

                <label for="maPhong">Tên Phòng:</label>
                <select id="maPhong" name="maPhong">
                    <?php echo $phongBanOptions; ?>
                </select>

                <label for="luong">Lương:</label>
                <input type="text" id="luong" name="luong" required>

                <input type="submit" value="Thêm" class="btn-submit">
            </form>
            <a href="list_NhanVien.php" class="btn-back">Quay lại</a>
        </div>
    </body>
</html>
