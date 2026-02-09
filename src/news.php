<?php
session_start();
require_once 'config.php'; 

// ตรวจสอบสิทธิ์ Admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

$status = ""; // ไว้สำหรับเช็คสถานะเพื่อแสดง Alert

// ส่วนการบันทึกข้อมูลข่าวสาร
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_news'])) {
    $title = mysqli_real_escape_string($conn, $_POST['title']); 
    $content = mysqli_real_escape_string($conn, $_POST['content']);
    $category = mysqli_real_escape_string($conn, $_POST['category']);
    $is_pinned = isset($_POST['is_pinned']) ? 1 : 0;

    $sql = "INSERT INTO news_announcements (title, content, category, is_pinned) 
            VALUES ('$title', '$content', '$category', '$is_pinned')";
    
    if ($conn->query($sql)) {
        $status = "success_add";
    } else {
        $status = "error_add";
    }
}
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage News - Admin System</title>
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
                <a href="edit_users.php" class="flex items-center space-x-3 hover:bg-slate-800 p-3 rounded-lg transition text-gray-300 hover:text-white font-light">
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
                <a href="news.php" class="flex items-center space-x-3 bg-blue-600 p-3 rounded-lg transition text-white">
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
            <div class="max-w-7xl mx-auto">
                
                <div class="mb-8">
                    <h2 class="text-3xl font-extrabold text-gray-800 tracking-tight">จัดการข่าวสารและประกาศ</h2>
                    <p class="text-gray-500 italic">เผยแพร่ข้อมูลข่าวสารและประกาศสำคัญให้สมาชิกทราบ</p>
                </div>

                <section class="bg-white p-6 md:p-8 rounded-2xl shadow-sm border border-gray-200 mb-10">
                    <h3 class="text-xl font-bold mb-6 flex items-center gap-2 text-blue-600">
                        <i class="fas fa-plus-circle"></i> เพิ่มประกาศใหม่
                    </h3>
                    <form id="newsForm" method="POST" class="space-y-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-semibold text-gray-600 mb-2">หัวข้อข่าว</label>
                                <input type="text" name="title" required placeholder="ระบุหัวข้อที่น่าสนใจ..."
                                       class="w-full border border-gray-200 rounded-xl p-3 outline-none focus:ring-2 focus:ring-blue-500 transition">
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-600 mb-2">ประเภทประกาศ</label>
                                <select name="category" class="w-full border border-gray-200 rounded-xl p-3 outline-none focus:ring-2 focus:ring-blue-500 transition">
                                    <option value="general">📰 ข่าวทั่วไป </option>
                                    <option value="urgent">🚨 ประกาศด่วน </option>
                                </select>
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-600 mb-2">เนื้อหาข่าวสาร</label>
                            <textarea name="content" rows="4" placeholder="รายละเอียดประกาศของคุณ..."
                                      class="w-full border border-gray-200 rounded-xl p-3 outline-none focus:ring-2 focus:ring-blue-500 transition"></textarea>
                        </div>
                        <div class="flex items-center gap-2 p-3 bg-gray-50 rounded-xl border border-gray-100 w-fit">
                            <input type="checkbox" name="is_pinned" id="pin" class="w-5 h-5 rounded border-gray-300 text-blue-600 focus:ring-blue-500 transition cursor-pointer">
                            <label for="pin" class="text-sm font-medium text-gray-700 cursor-pointer">ปักหมุดประกาศนี้ไว้บนสุด</label>
                        </div>
                        <button type="button" onclick="confirmPost()" class="bg-blue-600 text-white px-8 py-3 rounded-xl font-bold hover:bg-blue-700 transition shadow-lg shadow-blue-100 flex items-center gap-2">
                            <i class="fas fa-paper-plane"></i> ลงประกาศทันที
                        </button>
                        <input type="hidden" name="add_news" value="1">
                    </form>
                </section>

                <section class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
                    <div class="p-6 border-b border-gray-100 bg-gray-50/50">
                        <h3 class="font-bold text-gray-700 flex items-center gap-2">
                            <i class="fas fa-history"></i> รายการประกาศล่าสุด
                        </h3>
                    </div>
                    
                    <div class="hidden lg:block overflow-x-auto">
                        <table class="w-full text-left">
                            <thead class="bg-gray-50 text-gray-500 text-xs uppercase tracking-widest font-bold border-b">
                                <tr>
                                    <th class="p-4 w-20">ลำดับ</th>
                                    <th class="p-4">หัวข้อและเนื้อหา</th>
                                    <th class="p-4 w-32">ประเภท</th>
                                    <th class="p-4 w-32 text-center">สถานะ</th>
                                    <th class="p-4 w-24 text-center">จัดการ</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-50">
                                <?php
                                $res = $conn->query("SELECT * FROM news_announcements ORDER BY is_pinned DESC, created_at DESC");
                                while($row = $res->fetch_assoc()):
                                ?>
                                <tr class="hover:bg-blue-50/30 transition">
                                    <td class="p-4 text-xs font-mono text-gray-400">#<?= $row['id'] ?></td>
                                    <td class="p-4">
                                        <div class="font-bold text-gray-800"><?= htmlspecialchars($row['title']) ?></div>
                                        <div class="text-xs text-gray-500 line-clamp-1 italic mt-1 font-light"><?= htmlspecialchars($row['content']) ?></div>
                                    </td>
                                    <td class="p-4">
                                        <span class="px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider <?= $row['category'] == 'urgent' ? 'bg-red-100 text-red-600 border border-red-200' : 'bg-blue-100 text-blue-600 border border-blue-200' ?>">
                                            <?= $row['category'] ?>
                                        </span>
                                    </td>
                                    <td class="p-4 text-center text-sm">
                                        <?= $row['is_pinned'] ? '<span class="text-orange-500"><i class="fas fa-thumbtack"></i> Pinned</span>' : '<span class="text-gray-300 italic">Normal</span>' ?>
                                    </td>
                                    <td class="p-4 text-center">
                                        <button onclick="confirmDelete(<?= $row['id'] ?>)" 
                                           class="text-red-500 hover:text-red-700 bg-red-50 p-2 rounded-lg transition inline-block">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </td>
                                </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    </div>

                    <div class="lg:hidden p-4 space-y-4 bg-gray-50">
                        <?php 
                        $res->data_seek(0);
                        while($row = $res->fetch_assoc()): ?>
                            <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100 relative">
                                <?php if($row['is_pinned']): ?>
                                    <div class="absolute top-4 right-4 text-orange-500"><i class="fas fa-thumbtack"></i></div>
                                <?php endif; ?>
                                <div class="flex items-center gap-2 mb-3">
                                    <span class="px-2 py-1 rounded-md text-[10px] font-bold uppercase <?= $row['category'] == 'urgent' ? 'bg-red-100 text-red-600' : 'bg-blue-100 text-blue-600' ?>">
                                        <?= $row['category'] ?>
                                    </span>
                                </div>
                                <h4 class="font-bold text-gray-800 mb-2 leading-tight"><?= htmlspecialchars($row['title']) ?></h4>
                                <p class="text-sm text-gray-500 line-clamp-2 mb-4 font-light italic leading-relaxed"><?= htmlspecialchars($row['content']) ?></p>
                                <div class="flex justify-between items-center border-t border-gray-50 pt-4">
                                    <span class="text-[10px] text-gray-300 font-mono">ID: #<?= $row['id'] ?></span>
                                    <button onclick="confirmDelete(<?= $row['id'] ?>)" class="text-red-500 font-bold text-xs flex items-center gap-1">
                                        <i class="fas fa-trash-alt"></i> ลบประกาศ
                                    </button>
                                </div>
                            </div>
                        <?php endwhile; ?>
                    </div>
                </section>
            </div>
        </main>
    </div>

    <script>

        const menuBtn = document.getElementById('menuBtn');
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('overlay');
        const closeBtn = document.getElementById('closeBtn');

        function toggleSidebar() {
            sidebar.classList.toggle('-translate-x-full');
            overlay.classList.toggle('hidden');
            document.body.classList.toggle('overflow-hidden');
        }

        menuBtn.addEventListener('click', toggleSidebar);
        closeBtn.addEventListener('click', toggleSidebar);
        overlay.addEventListener('click', toggleSidebar);

        function confirmPost() {
            Swal.fire({
                title: 'ยืนยันการลงประกาศ?',
                text: "ข่าวสารนี้จะถูกเผยแพร่ไปยังหน้าแรกของสมาชิก",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#2563eb', 
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'ใช่, ลงประกาศเลย',
                cancelButtonText: 'ยกเลิก',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: 'กำลังบันทึกข้อมูล...',
                        allowOutsideClick: false,
                        didOpen: () => { Swal.showLoading(); }
                    });
                    document.getElementById('newsForm').submit();
                }
            });
        }

        function confirmDelete(id) {
            Swal.fire({
                title: 'คุณแน่ใจหรือไม่?',
                text: "หากลบแล้วข้อมูลประกาศนี้จะหายไปอย่างถาวร!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ef4444', 
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'ใช่, ลบออกทันที',
                cancelButtonText: 'ยกเลิก',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = `delete_news.php?id=${id}`;
                }
            });
        }

        const currentStatus = "<?= $status ?>";
        const urlParams = new URLSearchParams(window.location.search);
        
        if (currentStatus === 'success_add') {
            Swal.fire({
                icon: 'success',
                title: 'สำเร็จ!',
                text: 'บันทึกข่าวสารเรียบร้อยแล้ว',
                confirmButtonColor: '#2563eb'
            });
        } else if (urlParams.get('status') === 'deleted') {
            Swal.fire({
                icon: 'success',
                title: 'ลบเรียบร้อย!',
                text: 'ลบข่าวประกาศออกจากระบบแล้ว',
                confirmButtonColor: '#2563eb'
            });
        }
    </script>
</body>
</html>