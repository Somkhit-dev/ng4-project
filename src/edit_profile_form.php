<?php
session_start();
require_once 'config.php';

// ตรวจสอบล็อกอิน
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// ดึงข้อมูลผู้ใช้
$sql = "SELECT user_id, prename, firstname, lastname, email, agency, phone FROM users WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

// อัปเดตข้อมูลเมื่อฟอร์มถูกส่ง
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $prename = $_POST['prename'];
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $email = $_POST['email'];
    $agency = $_POST['agency'];
    $phone = $_POST['phone'];

    $update_sql = "UPDATE users SET prename = ?, firstname = ?, lastname = ?, email = ?, agency = ?, phone = ? WHERE user_id = ?";
    $update_stmt = $conn->prepare($update_sql);
    $update_stmt->bind_param('ssssssi', $prename, $firstname, $lastname, $email, $agency, $phone, $user_id);

    if ($update_stmt->execute()) {
        echo "<script>
            alert('อัปเดตข้อมูลสำเร็จ');
            window.location.href = 'profile.php';
        </script>";
        exit();
    } else {
        $error = "เกิดข้อผิดพลาดในการอัปเดตข้อมูล: " . $conn->error;
    }
}
$conn->close();
?>
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>แก้ไขข้อมูลส่วนตัว - My Profile</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Sarabun:wght@300;400;600;700&display=swap');
        body { font-family: 'Sarabun', sans-serif; }
    </style>
</head>
<body class="bg-slate-50 text-slate-800 antialiased">

    <header class="bg-white border-b border-slate-200 sticky top-0 z-50">
        <div class="container mx-auto px-4 py-4 flex flex-col md:flex-row justify-between items-center gap-4">
            <div class="flex items-center gap-2">
                <div class="bg-blue-600 p-2 rounded-lg text-white">
                    <i class="fas fa-user-edit text-xl"></i>
                </div>
                <h1 class="text-xl font-bold tracking-tight text-slate-900 uppercase">Edit Profile</h1>
            </div>
            
            <nav class="flex items-center gap-4 text-sm font-medium">
                <a href="user_dashboard.php" class="px-4 py-2 text-slate-600 hover:bg-slate-100 rounded-xl transition">หน้าหลัก</a>
                <a href="profile.php" class="px-4 py-2 text-blue-600 bg-blue-50 rounded-xl transition">ข้อมูลส่วนตัว</a>
                <a href="logout.php" class="px-4 py-2 bg-red-50 text-red-600 hover:bg-red-100 rounded-xl transition flex items-center gap-2">
                    <i class="fas fa-sign-out-alt"></i> ออกจากระบบ
                </a>
            </nav>
        </div>
    </header>

    <div class="min-h-[calc(100-80px)] flex items-center justify-center py-12 px-4">
        <div class="bg-white shadow-xl shadow-slate-200/60 rounded-[2rem] overflow-hidden max-w-2xl w-full border border-slate-100">
            
            <div class="bg-gradient-to-r from-blue-700 to-blue-500 p-8 text-white">
                <h2 class="text-2xl md:text-3xl font-bold flex items-center gap-3">
                    <i class="fas fa-user-circle"></i> แก้ไขข้อมูลส่วนตัว
                </h2>
                <p class="text-blue-100 mt-2 font-light italic">จัดการข้อมูลบัญชีผู้ใช้งานของคุณให้เป็นปัจจุบัน</p>
            </div>

            <div class="p-8 md:p-12">
                <?php if (!empty($error)): ?>
                    <div class="bg-red-50 border-l-4 border-red-500 text-red-700 p-4 mb-8 rounded-r-xl flex items-center gap-3">
                        <i class="fas fa-exclamation-circle text-xl"></i>
                        <p><?= htmlspecialchars($error) ?></p>
                    </div>
                <?php endif; ?>

                <form method="POST" class="space-y-6">
                    <div class="space-y-2">
                        <label class="text-sm font-bold text-slate-600 ml-1">คำนำหน้า</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-slate-400">
                                <i class="fas fa-id-card"></i>
                            </span>
                            <input type="text" name="prename" value="<?= htmlspecialchars($user['prename']); ?>" required
                                class="w-full pl-11 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none transition shadow-sm">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-2">
                            <label class="text-sm font-bold text-slate-600 ml-1">ชื่อ</label>
                            <input type="text" name="firstname" value="<?= htmlspecialchars($user['firstname']); ?>" required
                                class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none transition shadow-sm">
                        </div>
                        <div class="space-y-2">
                            <label class="text-sm font-bold text-slate-600 ml-1">นามสกุล</label>
                            <input type="text" name="lastname" value="<?= htmlspecialchars($user['lastname']); ?>" required
                                class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none transition shadow-sm">
                        </div>
                    </div>

                    <div class="space-y-2">
                        <label class="text-sm font-bold text-slate-600 ml-1">อีเมล</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-slate-400">
                                <i class="fas fa-envelope"></i>
                            </span>
                            <input type="email" name="email" value="<?= htmlspecialchars($user['email']); ?>" required
                                class="w-full pl-11 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none transition shadow-sm">
                        </div>
                    </div>

                    <div class="space-y-2">
                        <label class="text-sm font-bold text-slate-600 ml-1">หน่วยงาน</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-slate-400">
                                <i class="fas fa-building"></i>
                            </span>
                            <input type="text" name="agency" value="<?= htmlspecialchars($user['agency']); ?>" required
                                class="w-full pl-11 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none transition shadow-sm">
                        </div>
                    </div>

                    <div class="space-y-2">
                        <label class="text-sm font-bold text-slate-600 ml-1">เบอร์โทรศัพท์</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-slate-400">
                                <i class="fas fa-phone"></i>
                            </span>
                            <input type="text" name="phone" value="<?= htmlspecialchars($user['phone']); ?>" required
                                class="w-full pl-11 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none transition shadow-sm">
                        </div>
                    </div>

                    <div class="flex flex-col sm:flex-row justify-center gap-4 mt-10 pt-6 border-t border-slate-100">
                        <button type="submit" class="w-full sm:w-48 px-8 py-4 bg-blue-600 text-white rounded-2xl hover:bg-blue-700 shadow-lg shadow-blue-200 transition font-bold flex items-center justify-center gap-2">
                            <i class="fas fa-save"></i> บันทึกข้อมูล
                        </button>
                        <a href="profile.php" class="w-full sm:w-48 px-8 py-4 bg-slate-100 text-slate-600 rounded-2xl hover:bg-slate-200 transition font-bold flex items-center justify-center gap-2">
                            <i class="fas fa-arrow-left"></i> ย้อนกลับ
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <footer class="py-8 bg-slate-900 text-slate-500 text-center text-xs">
        <p>&copy; <?= date("Y") ?> มทร.อีสาน. ระบบเสนอรายละเอียดคำชี้แจงรายการครุภัณฑ์.</p>
    </footer>

</body>
</html>