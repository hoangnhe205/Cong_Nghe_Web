<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Thêm hoa</title>
</head>
<body>

<h2>➕ Thêm loài hoa mới</h2>

<form action="add.php" method="post">
    Tên hoa: <br>
    <input type="text" name="name" required><br><br>

    Mô tả: <br>
    <textarea name="desc" required></textarea><br><br>

    Đường dẫn ảnh: <br>
    <input type="text" name="img" placeholder="images/ten_anh.jpg" required><br><br>

    <button type="submit" name="add">Thêm mới</button>
</form>

<?php
if (isset($_POST['add'])) {
    include 'data.php';

    $newFlower = [
        "name" => $_POST['name'],
        "desc" => $_POST['desc'],
        "img"  => $_POST['img']
    ];

    $flowers[] = $newFlower;

    // Ghi lại file data.php
    file_put_contents("data.php", "<?php\n$"."flowers = ".var_export($flowers, true).";\n?>");

    echo "<script>alert('Thêm thành công!'); window.location='admin.php';</script>";
}
?>

</body>
</html>
