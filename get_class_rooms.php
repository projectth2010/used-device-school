<?php
require 'db.php';  // รวมไฟล์ที่เชื่อมต่อกับฐานข้อมูล

$school_id = $_POST['school_id'];

// ดึงข้อมูลห้องเรียนที่สังกัดกับโรงเรียนนั้นๆ
$sql = "SELECT id, room_name FROM class_rooms WHERE school_id = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, 'i', $school_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

$options = '';
while ($row = mysqli_fetch_assoc($result)) {
    $options .= "<option value='" . $row['id'] . "'>" . $row['room_name'] . "</option>";
}

// ส่งผลลัพธ์กลับไปในรูปแบบ HTML
echo $options;

mysqli_stmt_close($stmt);
mysqli_close($conn);
?>
