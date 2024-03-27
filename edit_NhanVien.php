<?php
if (isset($_GET['id'])) {

    $id = $_GET['id'];

    $connection = mysqli_connect('localhost', 'root', '', 'ql_nhansu');

    if (!$connection) {
        die("Kết nối cơ sở dữ liệu thất bại: " . mysqli_connect_error());
    }
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $tenNV = $_POST['tenNV'];
        $phai = $_POST['phai'];
        $noiSinh = $_POST['noiSinh'];
        $maPhong = $_POST['maPhong'];
        $luong = $_POST['luong'];

        $query = "UPDATE NHANVIEN SET TEN_NV = '$tenNV', Phai = '$phai', Noi_Sinh = '$noiSinh', Ma_Phong = '$maPhong', Luong = '$luong' WHERE Ma_NV = '$id'";
        $result = mysqli_query($connection, $query);

        if ($result) {
            echo "Cập nhật thành công!";
        } else {
            echo "Lỗi: " . mysqli_error($connection);
        }
    }

    // Truy vấn thông tin nhân viên cần sửa
    $query = "SELECT * FROM NHANVIEN WHERE Ma_NV = '$id'";
    $result = mysqli_query($connection, $query);

    if (!$result) {
        die("Lỗi: " . mysqli_error($connection));
    }

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        ?>
        <!DOCTYPE html>
        <html>
        <head>
            <meta charset="UTF-8">
            <title>Sửa thông tin nhân viên</title>
            <link href="/GiuaKy/styles.css" rel="stylesheet"/>
        </head>
        <body>
            <h1>Sửa thông tin nhân viên</h1>
            <form method="POST" action="">
                <label for="tenNV">Tên nhân viên:</label>
                <input type="text" id="tenNV" name="tenNV" value="<?php echo $row['Ten_NV']; ?>"><br>

                <label for="phai">Phái:</label>
                <input type="text" id="phai" name="phai" value="<?php echo $row['Phai']; ?>"><br>

                <label for="noiSinh">Nơi sinh:</label>
                <input type="text" id="noiSinh" name="noiSinh" value="<?php echo $row['Noi_Sinh']; ?>"><br>

                <label for="maPhong">Mã phòng:</label>
                <input type="text" id="maPhong" name="maPhong" value="<?php echo $row['Ma_Phong']; ?>"><br>

                <label for="luong">Lương:</label>
                <input type="text" id="luong" name="luong" value="<?php echo $row['Luong']; ?>"><br>

                <input type="submit" value="Lưu" class="btn-save">
                <a href="list_NhanVien.php" class="btn-back">Quay lại</a>
            </form>
        </body>
        </html>
        <?php
    } else {
        echo "Không tìm thấy nhân viên!";
    }
    mysqli_close($connection);
} else {
    echo "Không tìm thấy nhân viên!";
}
?>