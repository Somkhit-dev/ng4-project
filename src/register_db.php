<?php
ob_start();
session_start();
require_once 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $prename = trim($_POST['prename']);
    
    if ($prename === "อื่น ๆ" && !empty($_POST['other_prename'])) {
        $prename = trim($_POST['other_prename']);
    }
    $firstname = trim($_POST['firstname']);
    $lastname = trim($_POST['lastname']);
    $agency = trim($_POST['agency']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $password = $_POST['password'];
    $c_password = $_POST['c_password'];

    $_SESSION['old_input'] = array_map('htmlspecialchars', $_POST);
    $errors = [];

    if (!preg_match("/^[ก-๙a-zA-Z]+$/u", $firstname)) {
        $errors[] = "กรุณากรอกชื่อเป็นตัวอักษรเท่านั้น";
    }
    if (!preg_match("/^[ก-๙a-zA-Z]+$/u", $lastname)) {
        $errors[] = "กรุณากรอกนามสกุลเป็นตัวอักษรเท่านั้น";
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "อีเมลไม่ถูกต้อง!";
    }
    if (!preg_match("/^[0-9]{10}$/", $phone)) {
        $errors[] = "เบอร์โทรศัพท์ต้องเป็นตัวเลข 10 หลัก!";
    }
    if (strlen($password) < 6) {
        $errors[] = "รหัสผ่านต้องมีอย่างน้อย 6 ตัว!";
    }
    if ($password !== $c_password) {
        $errors[] = "รหัสผ่านไม่ตรงกัน!";
    }

    if (!empty($errors)) {
        $_SESSION['error'] = implode("<br>", $errors);
        header("Location: register.php");
        exit();
    }

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    $stmt = $conn->prepare("SELECT email FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $_SESSION['error'] = "อีเมลนี้ถูกใช้งานแล้ว!";
        header("Location: register.php");
        exit();
    }

    $role = 'member'; 
    $approve = 'รออนุมัติ'; 
    $stmt = $conn->prepare("INSERT INTO users (prename, firstname, lastname, agency, email, phone, password, role, approve) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssssss", $prename, $firstname, $lastname, $agency, $email, $phone, $hashed_password, $role, $approve);

    if ($stmt->execute()) {
        $_SESSION['success'] = "สมัครสมาชิกสำเร็จ! กรุณาเข้าสู่ระบบ";
        unset($_SESSION['old_input']);
        header("Location: login.php");
        exit();
    } else {
        $_SESSION['error'] = "เกิดข้อผิดพลาด: " . $stmt->error;
        header("Location: register.php");
        exit();
    }
}

ob_end_flush();
?>
