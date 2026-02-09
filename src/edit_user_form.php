<?php
session_start();
require_once 'config.php'; // เชื่อมต่อฐานข้อมูล

// ตรวจสอบว่าเข้าสู่ระบบแล้วและมี role เป็น admin หรือไม่
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

// ตรวจสอบว่ามี user_id ใน URL หรือไม่
if (isset($_GET['user_id'])) {
    $user_id = $_GET['user_id'];

    // ดึงข้อมูลผู้ใช้จากฐานข้อมูล
    $sql = "SELECT user_id, prename, firstname, lastname, email, agency, phone, approve, role FROM users WHERE user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
    } else {
        echo '<script>alert("ไม่พบข้อมูลผู้ใช้นี้"); window.location.href="edit_users.php";</script>';
        exit();
    }
} else {
    header("Location: edit_users.php");
    exit();
}

// จัดการการส่งฟอร์ม (POST)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $prename = $_POST['prename'];
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $email = $_POST['email'];
    $agency = $_POST['agency'];
    $phone = $_POST['phone'];
    $approve = $_POST['approve'];
    $role = $_POST['role'];

    $update_sql = "UPDATE users SET prename = ?, firstname = ?, lastname = ?, email = ?, agency = ?, phone = ?, approve = ?, role = ? WHERE user_id = ?";
    $update_stmt = $conn->prepare($update_sql);
    $update_stmt->bind_param('ssssssssi', $prename, $firstname, $lastname, $email, $agency, $phone, $approve, $role, $user_id);

    if ($update_stmt->execute()) {
        // ส่งกลับไปหน้าเดิมพร้อม Parameter เพื่อบอกว่าสำเร็จ
        header("Location: edit_users.php?status=updated");
        exit();
    } else {
        $error_msg = "เกิดข้อผิดพลาดในการอัปเดตข้อมูล: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User Details - Admin System</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Sarabun:wght@300;400;600;700&display=swap');
        body { font-family: 'Sarabun', sans-serif; }
        .swal2-popup { border-radius: 1.5rem !important; font-family: 'Sarabun', sans-serif !important; }
        .swal2-confirm, .swal2-cancel { border-radius: 0.75rem !important; font-weight: 700 !important; }
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

        <main class="flex-1 p-4 md:p-8 lg:ml-64 transition-all">
            <div class="max-w-4xl mx-auto">
                
                <div class="mb-8 flex justify-between items-center">
                    <div>
                        <h2 class="text-2xl md:text-3xl font-extrabold text-gray-800 tracking-tight">Edit User Details</h2>
                        <p class="text-gray-500 text-sm">แก้ไขข้อมูลสมาชิก ID: #USR-<?= $user['user_id'] ?></p>
                    </div>
                    <a href="edit_users.php" class="text-blue-600 hover:text-blue-800 text-sm font-bold">
                        <i class="fas fa-arrow-left"></i> กลับไปหน้ารายชื่อ
                    </a>
                </div>

                <?php if (isset($error_msg)): ?>
                    <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded shadow-sm flex items-center gap-3">
                        <i class="fas fa-exclamation-circle"></i>
                        <span><?= $error_msg ?></span>
                    </div>
                <?php endif; ?>

                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
                    <form id="editUserForm" method="POST" action="" class="p-6 md:p-10 space-y-6">
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="md:col-span-2">
                                <label class="block text-xs font-bold text-gray-500 uppercase mb-2">คำนำหน้า</label>
                                <input type="text" name="prename" value="<?= htmlspecialchars($user['prename']); ?>" required 
                                    class="w-full px-4 py-2 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition outline-none">
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-gray-500 uppercase mb-2">ชื่อ</label>
                                <input type="text" name="firstname" value="<?= htmlspecialchars($user['firstname']); ?>" required 
                                    class="w-full px-4 py-2 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 outline-none">
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-gray-500 uppercase mb-2">นามสกุล</label>
                                <input type="text" name="lastname" value="<?= htmlspecialchars($user['lastname']); ?>" required 
                                    class="w-full px-4 py-2 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 outline-none">
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-gray-500 uppercase mb-2">อีเมล</label>
                                <input type="email" name="email" value="<?= htmlspecialchars($user['email']); ?>" required 
                                    class="w-full px-4 py-2 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 outline-none">
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-gray-500 uppercase mb-2">เบอร์โทร</label>
                                <input type="text" name="phone" value="<?= htmlspecialchars($user['phone']); ?>" required 
                                    class="w-full px-4 py-2 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 outline-none">
                            </div>

                            <div class="md:col-span-2">
                                <label class="block text-xs font-bold text-gray-500 uppercase mb-2">หน่วยงาน</label>
                                <input type="text" name="agency" value="<?= htmlspecialchars($user['agency']); ?>" required 
                                    class="w-full px-4 py-2 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 outline-none">
                            </div>

                            <div class="md:col-span-2">
                                <label class="block text-xs font-bold text-gray-500 uppercase mb-2">สถานะการอนุมัติ</label>
                                <select name="approve" class="w-full px-4 py-2 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 outline-none bg-white cursor-pointer">
                                    <option value="อนุมัติแล้ว" <?= ($user['approve'] == 'อนุมัติแล้ว') ? 'selected' : ''; ?>>อนุมัติแล้ว</option>
                                    <option value="รออนุมัติ" <?= ($user['approve'] == 'รออนุมัติ') ? 'selected' : ''; ?>>รออนุมัติ</option>
                                </select>
                            </div>
                            <div class="md:col-span-2">
                                <label class="block text-xs font-bold text-gray-500 uppercase mb-2">ระบบผู้ใช้</label>
                                <select name="role" class="w-full px-4 py-2 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 outline-none bg-white cursor-pointer">
                                    <option value="admin" <?= ($user['role'] == 'admin') ? 'selected' : ''; ?>>ผู้ดูแลระบบ</option>
                                    <option value="member" <?= ($user['role'] == 'member') ? 'selected' : ''; ?>>สมาชิก</option>
                                </select>
                            </div>
                        </div>

                        <div class="pt-6 border-t border-gray-100 flex flex-col md:flex-row gap-4">
                            <button type="button" onclick="confirmSave()" class="flex-1 bg-blue-600 text-white px-6 py-3 rounded-xl font-bold hover:bg-blue-700 transition shadow-lg shadow-blue-200 flex items-center justify-center gap-2">
                                <i class="fas fa-save"></i> บันทึกข้อมูล
                            </button>
                            <a href="reset_password_admin.php?user_id=<?= $user_id; ?>" class="flex-1 bg-slate-100 text-slate-700 px-6 py-3 rounded-xl font-bold hover:bg-slate-200 transition flex items-center justify-center gap-2">
                                <i class="fas fa-key"></i> เปลี่ยนรหัสผ่าน
                            </button>
                            <a href="edit_users.php" class="flex-1 bg-white text-gray-400 px-6 py-3 rounded-xl font-bold hover:text-gray-600 border border-gray-200 transition text-center flex items-center justify-center">
                                ยกเลิก
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </main>
    </div>

    <script>
        // Sidebar Control
        const menuBtn = document.getElementById('menuBtn');
        const closeBtn = document.getElementById('closeBtn');
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('overlay');

        function toggleSidebar() {
            sidebar.classList.toggle('-translate-x-full');
            overlay.classList.toggle('hidden');
            document.body.classList.toggle('overflow-hidden');
        }

        menuBtn.addEventListener('click', toggleSidebar);
        closeBtn.addEventListener('click', toggleSidebar);
        overlay.addEventListener('click', toggleSidebar);

        // Confirm Save with SweetAlert2
        function confirmSave() {
            Swal.fire({
                title: 'ยืนยันการแก้ไข?',
                text: "ข้อมูลผู้ใช้จะถูกเปลี่ยนแปลงในระบบ",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#2563eb', // blue-600
                cancelButtonColor: '#6b7280',  // gray-500
                confirmButtonText: 'ยืนยันการบันทึก',
                cancelButtonText: 'ยกเลิก',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: 'กำลังบันทึก...',
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });
                    document.getElementById('editUserForm').submit();
                }
            });
        }

        // Responsive Sidebar Adjustment
        window.addEventListener('resize', () => {
            if (window.innerWidth >= 1024) {
                sidebar.classList.remove('-translate-x-full');
                overlay.classList.add('hidden');
                document.body.classList.remove('overflow-hidden');
            } else {
                sidebar.classList.add('-translate-x-full');
            }
        });
    </script>
</body>
</html>