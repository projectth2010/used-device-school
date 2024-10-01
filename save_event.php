<?php
error_reporting(E_ALL);
require 'db_connect.php'; // Assuming you have db.php which contains the MySQLi connection

$id = $_POST['id'];
$title = $_POST['title'];
$subtitle = $_POST['subtitle'];
$ta_name = $_POST['ta_name'];
$school_name = $_POST['school_name'];
$note = $_POST['note'];
$start_date = $_POST['start_date'];
$end_date = $_POST['end_date'];

$school_id = $_POST['school_id'];
$class_room_id = $_POST['class_room_id'];


// ตรวจสอบว่ากำลังสร้างกิจกรรมใหม่หรืออัปเดต
if ($id == '') {
    // Insert new event
    $sql = "INSERT INTO events (title, subtitle, ta_name, school_name, note, start_date, end_date)
            VALUES (?, ?, ?, ?, ?, ?, ?)";
    
    // เตรียม statement
    $stmt = mysqli_prepare($con, $sql);

    // ตรวจสอบว่า statement ถูกเตรียมสำเร็จ
    if ($stmt) {
        // ผูกค่าที่ต้องการเข้าไปใน statement
        mysqli_stmt_bind_param($stmt, 'sssssss', $title, $subtitle, $ta_name, $school_name, $note, $start_date, $end_date);
        
        // ดำเนินการ query
        mysqli_stmt_execute($stmt);

        // ตรวจสอบผลลัพธ์
        if (mysqli_stmt_affected_rows($stmt) > 0) {
            echo "Event added successfully!";
        } else {
            echo "Failed to add event.";
        }

        // ปิด statement
        mysqli_stmt_close($stmt);
    } else {
        echo "Failed to prepare the statement: " . mysqli_error($con);
    }

} else {
    // Update existing event
    $sql = "UPDATE events SET title=?, subtitle=?, ta_name=?, school_name=?, note=?, start_date=?, end_date=?
            WHERE id=?";
    
    // เตรียม statement
    $stmt = mysqli_prepare($con, $sql);

    // ตรวจสอบว่า statement ถูกเตรียมสำเร็จ
    if ($stmt) {
        // ผูกค่าที่ต้องการเข้าไปใน statement
        mysqli_stmt_bind_param($stmt, 'sssssssi', $title, $subtitle, $ta_name, $school_name, $note, $start_date, $end_date, $id);
        
        // ดำเนินการ query
        mysqli_stmt_execute($stmt);

        // ตรวจสอบผลลัพธ์
        if (mysqli_stmt_affected_rows($stmt) > 0) {
            echo "Event updated successfully!";
        } else {
            echo "Failed to update event.";
        }

        // ปิด statement
        mysqli_stmt_close($stmt);
    } else {
        echo "Failed to prepare the statement: " . mysqli_error($con);
    }
}

// ปิดการเชื่อมต่อ
mysqli_close($con);
?>
