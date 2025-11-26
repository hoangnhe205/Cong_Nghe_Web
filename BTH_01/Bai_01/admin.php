<?php include 'data.php'; ?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Quản trị hoa</title>
<style>
    body{font-family:Arial;margin:30px;}
    table{border-collapse:collapse;width:100%;}
    th,td{border:1px solid #444;padding:8px;text-align:center;}
    .admin-img{width:120px;}
</style>
</head>
<body>

<h2>🌼 Quản lý danh sách hoa</h2>
<a href="add.php">➕ Thêm hoa mới</a>
<br><br>

<table>
    <tr>
        <th>STT</th>
        <th>Tên hoa</th>
        <th>Mô tả</th>
        <th>Ảnh</th>
        <th>Chức năng</th>
    </tr>

<?php foreach ($flowers as $i => $fl): ?>
<tr>
    <td><?= $i+1 ?></td>
    <td><?= $fl['name'] ?></td>
    <td><?= $fl['desc'] ?></td>
    <td><img class="admin-img" src="<?= $fl['img'] ?>"></td>
    <td>
        <a href="edit.php?id=<?= $i ?>">✏ Sửa</a> | 
        <a href="delete.php?id=<?= $i ?>" onclick="return confirm('Bạn có chắc muốn xóa?')">🗑 Xóa</a>
    </td>
</tr>
<?php endforeach; ?>

</table>

</body>
</html>
