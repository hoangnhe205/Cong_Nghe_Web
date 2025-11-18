<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHT Chương 2 - PHP Căn Bản</title>
</head>
<body>
    <h1>Kết quả PHP Căn Bản</h1> 
    <?php
        // BẮT ĐẦU CODE PHP CỦA BẠN TẠI ĐÂY
        // TODO 1: Khai báo 3 biến
        $ho_ten = "Nguyễn Việt Hoàng";
        $diem_tb =  7.5;
        $co_di_hoc_chuyen_can = true;

        // TODO 2: In ra thông tin sinh viên 
        echo "Họ và tên: " .$ho_ten ."<br>";
        // echo "<br>;
        echo "Điểm trung bình: " .$diem_tb ."<br>";

        // TODO 3: Viết cấu trúc IF/ELSE IF/ELSE (2.2)
        // Dựa vào $diem_tb, in ra xếp loại:
        // Gợi ý: Dùng toán tử && (AND) 
        if ($diem_tb >= 8.5 && $co_di_hoc_chuyen_can == true)
        {
            echo "Xếp loại: Giỏi"."<br>";
        }   
        else if ($diem_tb >= 6.5 && $co_di_hoc_chuyen_can == true)
        {
            echo "Xếp loại : Khá"."<br>";
        }
        else if ($diem_tb >= 5 && $co_di_hoc_chuyen_can == true)
        {
            echo "Xếp loại : Trung bình"."<br>";
        }
        else{
            echo "Xếp loại: Yếu (Cần cố gắng thêm!)"."<br>";
        }
        // TODO 4: Viết 1 hàm đơn giản (2.3)
        // Tên hàm: chaoMung()
        // Hàm này không có tham số, chỉ cần `echo "Chúc mừng bạn đã hoàn thành PHP Chương 2!"
        function chaoMung()
        {
            echo "Chúc mừng bạn đã hoàn thành PHT Chương 2!";
        }
        // TODO 5: Gọi hàm bạn vừa tạo 
        chaoMung();
        // KẾT THÚC CODE PHP CỦA BẠN TẠI ĐÂY 
    ?>
</body>
</html>
