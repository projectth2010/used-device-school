<?php
require 'db_connect.php';  // Include database connection file
 

$id = $_POST['id'];  // รับค่า id ที่จะลบจาก POST

// เตรียมคำสั่ง SQL สำหรับลบข้อมูล
$sql = "DELETE FROM events WHERE id=?";

// เตรียม statement
$stmt = mysqli_prepare($con, $sql);

// ตรวจสอบว่า statement ถูกเตรียมสำเร็จ
if ($stmt) {
    // ผูกค่า id เข้าไปใน statement ('i' หมายถึงประเภท integer)
    mysqli_stmt_bind_param($stmt, 'i', $id);
    
    // ดำเนินการ query
    mysqli_stmt_execute($stmt);

    // ตรวจสอบผลลัพธ์
    if (mysqli_stmt_affected_rows($stmt) > 0) {
        echo "Event deleted successfully!";
    } else {
        echo "Failed to delete event or event not found.";
    }

    // ปิด statement
    mysqli_stmt_close($stmt);
} else {
    echo "Failed to prepare the statement: " . mysqli_error($conn);
}

// ปิดการเชื่อมต่อ
mysqli_close($con);

echo "Event deleted successfully!";
?>
