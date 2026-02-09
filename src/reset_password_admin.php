<?php
session_start();
require_once 'config.php'; // เชื่อมต่อฐานข้อมูล

// ตรวจสอบว่าเข้าสู่ระบบแล้วและมี role เป็น admin หรือไม่
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

// ดึง user_id จาก URL
$user_id_from_url = $_GET['user_id'] ?? null;
$status_success = false;
$message = "";

// ตรวจสอบว่า user_id จาก URL มีหรือไม่
if ($user_id_from_url) {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $new_password = $_POST['new_password'] ?? '';

        if (!empty($new_password)) {
            $hashed_password = password_hash($new_password, PASSWORD_BCRYPT);

            // อัปเดตรหัสผ่าน
            $stmt = $conn->prepare("UPDATE users SET password = ? WHERE user_id = ?");
            $stmt->bind_param("si", $hashed_password, $user_id_from_url);

            if ($stmt->execute()) {
                $status_success = true;
                $message = "เปลี่ยนรหัสผ่านสำเร็จ!";
            } else {
                $message = "เกิดข้อผิดพลาดในการบันทึกข้อมูล!";
            }
            $stmt->close();
        } else {
            $message = "กรุณากรอกรหัสผ่านใหม่!";
        }
    }

    // ดึงข้อมูลผู้ใช้ที่ตรงกับ user_id จาก URL
    $stmt = $conn->prepare("SELECT user_id, firstname, lastname FROM users WHERE user_id = ?");
    $stmt->bind_param("i", $user_id_from_url);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
    $stmt->close();

    if (!$user) {
        die("ไม่พบข้อมูลผู้ใช้");
    }
} else {
    die("ไม่พบ user_id ใน URL");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password - Admin System</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Sarabun:wght@300;400;600;700&display=swap');
        body { font-family: 'Sarabun', sans-serif; }
        .swal2-popup { border-radius: 1.5rem !important; font-family: 'Sarabun', sans-serif !important; }
    </style>
</head>
<body class="bg-gray-100 text-gray-800 antialiased">

    <header class="lg:hidden bg-blue-700 text-white p-4 flex justify-between items-center shadow-lg sticky top-0 z-50">
        <h1 class="text-xl font-bold uppercase tracking-wider">Admin Panel</h1>
        <button id="menuBtn" class="p-2 hover:bg-blue-600 rounded-lg transition">
            <i class="fas fa-bars text-2xl"></i>
        </button>
    </header>

    <div class="flex min-h-screen">
        <aside id="sidebar" class="fixed inset-y-0 left-0 w-64 bg-slate-900 text-white p-5 flex flex-col shadow-2xl transform -translate-x-full lg:translate-x-0 transition-transform duration-300 ease-in-out z-50">
            <div class="flex justify-between items-center mb-10">
                <h1 class="text-2xl font-extrabold text-blue-400 w-full text-center lg:text-left">ADMIN</h1>
                <button id="closeBtn" class="lg:hidden text-2xl text-gray-400 hover:text-white">&times;</button>
            </div>
            
                        <nav class="flex-1 space-y-1 overflow-y-auto">
                <p class="text-xs text-gray-500 uppercase font-bold mb-2 px-3">Main Menu</p>
                
                <a href="admin_dashboard.php" class="flex items-center space-x-3 hover:bg-slate-800 p-3 rounded-lg transition text-gray-300 hover:text-white font-light">
                    <i class="fas fa-chart-pie w-5"></i> <span>Dashboard</span>
                </a>
                
                <a href="approve_users.php" class="flex items-center space-x-3 hover:bg-slate-800 p-3 rounded-lg transition text-gray-300 hover:text-white font-light">
                    <i class="fas fa-user-check w-5"></i> <span>Approve Users</span>
                </a>

                <a href="edit_users.php" class="flex items-center space-x-3 bg-blue-600 p-3 rounded-lg transition text-white">
                    <i class="fas fa-user-edit w-5"></i> <span>Edit User</span>
                </a>

                <a href="delete_user.php" class="flex items-center space-x-3 hover:bg-slate-800 p-3 rounded-lg transition text-gray-300 hover:text-white font-light">
                    <i class="fas fa-user-times w-5 text-red-400"></i> <span>Delete User</span>
                </a>

                <div class="pt-4 pb-2 px-3 uppercase text-[10px] font-bold text-gray-500">Forms & Content</div>

                <a href="list_form.php" class="flex items-center space-x-3 hover:bg-slate-800 p-3 rounded-lg transition text-gray-300 hover:text-white font-light">
                    <i class="fas fa-list w-5"></i> <span>List Form</span>
                </a>

                <a href="admin_form.php" class="flex items-center space-x-3 hover:bg-slate-800 p-3 rounded-lg transition text-gray-300 hover:text-white font-light">
                    <i class="fas fa-file-alt w-5"></i> <span>Admin Form</span>
                </a>

                <a href="news.php" class="flex items-center space-x-3 hover:bg-slate-800 p-3 rounded-lg transition text-gray-300 hover:text-white font-light">
                    <i class="fas fa-newspaper w-5 text-yellow-500"></i> <span>จัดการข่าวสาร</span>
                </a>

                <div class="pt-6 mt-6 border-t border-slate-800">
                    <a href="logout.php" class="flex items-center space-x-3 bg-red-500/10 text-red-500 p-3 rounded-lg hover:bg-red-500 hover:text-white transition group">
                        <i class="fas fa-sign-out-alt w-5 group-hover:translate-x-1 transition-transform"></i> 
                        <span class="font-bold">Logout</span>
                    </a>
                </div>
            </nav>
        </aside>

        <div id="overlay" class="fixed inset-0 bg-black/60 z-40 hidden lg:hidden"></div>

        <main class="flex-1 p-4 md:p-8 lg:ml-64 transition-all flex items-center justify-center">
            <div class="max-w-md w-full">
                
                <div class="mb-6">
                    <button onclick="history.back()" class="text-gray-500 hover:text-blue-600 transition flex items-center gap-2 font-bold text-sm">
                        <i class="fas fa-arrow-left"></i> กลับไปก่อนหน้า
                    </button>
                </div>

                <div class="bg-white rounded-3xl shadow-xl border border-gray-100 overflow-hidden">
                    <div class="bg-slate-900 p-8 text-center">
                        <div class="w-16 h-16 bg-blue-500 rounded-2xl flex items-center justify-center mx-auto mb-4 shadow-lg shadow-blue-500/30">
                            <i class="fas fa-key text-white text-2xl"></i>
                        </div>
                        <h2 class="text-xl font-bold text-white tracking-tight">เปลี่ยนรหัสผ่าน</h2>
                        <p class="text-blue-300 text-sm mt-1">สำหรับ: <?= htmlspecialchars($user['firstname'] . " " . $user['lastname']) ?></p>
                    </div>

                    <form id="resetForm" method="POST" class="p-8 space-y-6">
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase mb-2 tracking-wider">รหัสผ่านใหม่ (New Password)</label>
                            <div class="relative group">
                                <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400 group-focus-within:text-blue-500 transition-colors">
                                    <i class="fas fa-lock"></i>
                                </span>
                                <input type="password" name="new_password" id="new_password" required minlength="6"
                                    class="w-full pl-10 pr-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 outline-none transition"
                                    placeholder="อย่างน้อย 6 ตัวอักษร">
                            </div>
                        </div>

                        <button type="button" onclick="confirmReset()" class="w-full bg-blue-600 text-white py-4 rounded-xl font-bold hover:bg-blue-700 transition shadow-lg shadow-blue-200 flex items-center justify-center gap-2 transform active:scale-[0.98]">
                            <i class="fas fa-save"></i> อัปเดตรหัสผ่านใหม่
                        </button>
                    </form>
                </div>

                <p class="text-center text-gray-400 text-xs mt-8 italic">
                    <i class="fas fa-shield-alt mr-1"></i> รหัสผ่านจะถูกเข้ารหัสด้วยระบบ PASSWORD_BCRYPT
                </p>
            </div>
        </main>
    </div>

    <script>
        // Sidebar Toggle
        const menuBtn = document.getElementById('menuBtn');
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('overlay');

        function toggleSidebar() {
            sidebar.classList.toggle('-translate-x-full');
            overlay.classList.toggle('hidden');
        }
        menuBtn?.addEventListener('click', toggleSidebar);
        overlay?.addEventListener('click', toggleSidebar);

        // Confirm Logic
        function confirmReset() {
            const pass = document.getElementById('new_password').value;
            if(pass.length < 6) {
                Swal.fire({
                    icon: 'error',
                    title: 'รหัสผ่านสั้นเกินไป',
                    text: 'กรุณาระบุรหัสผ่านอย่างน้อย 6 ตัวอักษร',
                    confirmButtonColor: '#3b82f6'
                });
                return;
            }

            Swal.fire({
                title: 'ยืนยันการเปลี่ยนรหัสผ่าน?',
                text: "รหัสผ่านใหม่จะถูกใช้งานทันที",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#2563eb',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'ยืนยัน',
                cancelButtonText: 'ยกเลิก',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('resetForm').submit();
                }
            });
        }

        // Handle PHP Result Messages
        <?php if ($status_success): ?>
            Swal.fire({
                icon: 'success',
                title: 'สำเร็จ!',
                text: 'เปลี่ยนรหัสผ่านเรียบร้อยแล้ว',
                confirmButtonColor: '#2563eb'
            }).then(() => {
                window.location.href = 'edit_users.php'; // หรือหน้าที่คุณต้องการให้ไป
            });
        <?php elseif (!empty($message)): ?>
            Swal.fire({
                icon: 'error',
                title: 'เกิดข้อผิดพลาด',
                text: '<?= $message ?>',
                confirmButtonColor: '#ef4444'
            });
        <?php endif; ?>
    </script>
</body>
</html>