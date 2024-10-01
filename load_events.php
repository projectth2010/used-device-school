<?php
require 'db_connect.php';  // Include database connection file

// คำสั่ง SQL สำหรับดึงข้อมูลจากตาราง events
$sql = "SELECT * FROM events";

// ดำเนินการ query
$result = mysqli_query($con, $sql);

// ตรวจสอบว่ามีข้อมูลในผลลัพธ์หรือไม่
$events = array();

if ($result) {
    // วนลูปดึงข้อมูลแต่ละแถว
    while ($row = mysqli_fetch_assoc($result)) {
        $events[] = array(
            'id'    => $row['id'],
            'title' => $row['title'],
            'subtitle' => $row['subtitle'],
            'ta_name' => $row['ta_name'],
            'school_name' => $row['school_name'],
            'note' => $row['note'],
            'start' => $row['start_date'],
            'end'   => $row['end_date']
        );
    }
} else {
    echo "Error: " . mysqli_error($conn);
}

// ปิดการเชื่อมต่อ
mysqli_close($con);


echo json_encode($events);
?>
