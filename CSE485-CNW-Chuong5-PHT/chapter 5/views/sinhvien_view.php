<?php
// views/sinhvien_view.php
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>PHT Chương 5 - MVC</title>
</head>
<body>
    <h1>PHT Chương 5 - MVC</h1>

    <h2>Thêm Sinh Viên Mới (Kiến trúc MVC)</h2>
    <form action="index.php" method="post">
        <label>Tên sinh viên:</label>
        <input type="text" name="ten_sinh_vien" required>
        <br>
        <label>Email:</label>
        <input type="email" name="email" required>
        <br>
        <button type="submit">Thêm</button>
    </form>

    <h2>Danh Sách Sinh Viên (Kiến trúc MVC)</h2>

    <table border="1" cellpadding="5" cellspacing="0">
        <thead>
            <tr>
                <th>ID</th>
                <th>Tên Sinh Viên</th>
                <th>Email</th>
                <th>Ngày Tạo</th>
            </tr>
        </thead>
        <tbody>
        <?php
        // $danh_sach_sv được truyền từ Controller
        if (!empty($danh_sach_sv)) {
            foreach ($danh_sach_sv as $sv) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($sv['id']) . "</td>";
                echo "<td>" . htmlspecialchars($sv['ten_sinh_vien']) . "</td>";
                echo "<td>" . htmlspecialchars($sv['email']) . "</td>";
                echo "<td>" . htmlspecialchars($sv['ngay_tao']) . "</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='4'>Chưa có sinh viên nào.</td></tr>";
        }
        ?>
        </tbody>
    </table>
</body>
</html>