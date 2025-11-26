<?php
include 'data.php';

$id = $_GET['id'];
unset($flowers[$id]);  
$flowers = array_values($flowers); // reset lại chỉ số

file_put_contents("data.php", "<?php\n$"."flowers = ".var_export($flowers, true).";\n?>");

echo "<script>alert('Đã xóa thành công!'); window.location='admin.php';</script>";
?>
