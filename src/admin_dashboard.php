<?php
session_start();
require_once 'config.php'; 

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin System - Full Responsive</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Sarabun:wght@300;400;600;700&display=swap');
        body { font-family: 'Sarabun', sans-serif; }
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
                
                <a href="admin_dashboard.php" class="flex items-center space-x-3 bg-blue-600 p-3 rounded-lg transition text-white">
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

            <footer class="mt-8 text-[10px] text-center text-gray-600">
                <p>&copy; <?= date("Y"); ?> Admin Panel System</p>
            </footer>
        </aside>

        <div id="overlay" class="fixed inset-0 bg-black/60 z-40 hidden lg:hidden"></div>

        <main class="flex-1 p-4 md:p-8 lg:ml-64 transition-all">
            <div class="max-w-7xl mx-auto">

                <div class="mb-8 flex flex-col md:flex-row md:items-end md:justify-between gap-4">
                    <div>
                        <h2 class="text-2xl md:text-4xl font-extrabold text-gray-800 tracking-tight">DASHBOARD</h2>
                        <p class="text-gray-500 text-sm md:text-base">ยินดีต้อนรับ | ระบบจะแสดงรายชื่อผู้ใช้ที่นี่</p>
                    </div>
                    <div class="bg-white px-4 py-2 rounded-xl shadow-sm border border-gray-200 text-sm inline-flex items-center gap-2 self-start">
                        <span class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></span>
                        <span class="text-gray-600 font-medium">System Online:</span> <?= date("d M Y"); ?>
                    </div>
                </div>

                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
                    <div class="p-6 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
                        <h3 class="font-bold text-gray-700 text-lg flex items-center">
                            <i class="fas fa-users text-blue-600 mr-2"></i> สมาชิกทั้งหมด
                        </h3>
                    </div>

                    <?php
                    // SQL Query: ดึงเฉพาะ Role Member
                    $sql = "SELECT * FROM users WHERE role = 'member' ORDER BY user_id DESC";
                    $result = $conn->query($sql);

                    if ($result && $result->num_rows > 0): 
                        
                        // --- ส่วนที่ 1: การ์ดสำหรับมือถือ (Mobile Cards) ---
                        echo '<div class="grid grid-cols-1 md:grid-cols-2 gap-4 p-4 lg:hidden">';
                        $m_idx = 1;
                        while ($row = $result->fetch_assoc()): ?>
                            <div class="bg-white border-2 border-gray-50 rounded-2xl p-5 shadow-sm">
                                <div class="flex justify-between items-start mb-4">
                                    <div class="w-10 h-10 bg-blue-100 text-blue-700 rounded-xl flex items-center justify-center font-bold">
                                        <?= $m_idx++ ?>
                                    </div>
                                    <span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-[10px] font-bold uppercase tracking-wider">
                                        <?= htmlspecialchars($row["approve"]) ?>
                                    </span>
                                </div>
                                <h4 class="font-bold text-gray-800 text-lg"><?= htmlspecialchars($row["prename"].$row["firstname"].' '.$row["lastname"]) ?></h4>
                                <div class="mt-3 space-y-2 text-sm text-gray-600">
                                    <p class="flex items-center gap-2 truncate"><i class="far fa-envelope text-blue-400 w-4"></i> <?= htmlspecialchars($row["email"]) ?></p>
                                    <p class="flex items-center gap-2"><i class="fas fa-building text-blue-400 w-4"></i> <?= htmlspecialchars($row["agency"]) ?></p>
                                    <p class="flex items-center gap-2"><i class="fas fa-phone text-blue-400 w-4"></i> <?= htmlspecialchars($row["phone"]) ?></p>
                                </div>
                                <div class="mt-4 pt-4 border-t border-gray-50 text-[10px] text-gray-400 flex justify-between uppercase font-semibold">
                                    <span>Registered At:</span>
                                    <span><?= $row["created_at"] ?></span>
                                </div>
                            </div>
                        <?php endwhile;

                        echo '</div>'; // จบ Mobile Grid

                        // --- ส่วนที่ 2: ตารางสำหรับคอมพิวเตอร์ (Desktop Table) ---
                        echo '<div class="hidden lg:block overflow-x-auto">';
                        echo '<table class="w-full text-left border-collapse">';
                        echo '<thead class="bg-gray-50 text-gray-500 text-xs uppercase tracking-widest border-b border-gray-100">';
                        echo '<tr>';
                        echo '<th class="px-6 py-4">ลำดับ</th>';
                        echo '<th class="px-6 py-4">ชื่อ-สกุล</th>';
                        echo '<th class="px-6 py-4">รายละเอียด</th>';
                        echo '<th class="px-6 py-4">หน่วยงาน</th>';
                        echo '<th class="px-6 py-4 text-center">สถานะ</th>';
                        echo '</tr>';
                        echo '</thead>';
                        echo '<tbody class="divide-y divide-gray-50 bg-white">';
                        
                        $result->data_seek(0);
                        $d_idx = 1;
                        while ($row = $result->fetch_assoc()): ?>
                            <tr class="hover:bg-blue-50/30 transition">
                                <td class="px-6 py-4 text-gray-400 font-mono text-sm"><?= sprintf("%02d", $d_idx++) ?></td>
                                <td class="px-6 py-4">
                                    <div class="font-bold text-gray-800"><?= htmlspecialchars($row["prename"].$row["firstname"].' '.$row["lastname"]) ?></div>
                                    <div class="text-[10px] text-gray-400">ID: #USR-<?= $row["user_id"] ?></div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm text-blue-600 font-medium"><?= htmlspecialchars($row["email"]) ?></div>
                                    <div class="text-xs text-gray-500"><?= htmlspecialchars($row["phone"]) ?></div>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-600"><?= htmlspecialchars($row["agency"]) ?></td>
                                <td class="px-6 py-4 text-center">
                                    <span class="inline-block px-3 py-1 bg-green-50 text-green-600 rounded-lg text-xs font-bold border border-green-100">
                                        <?= htmlspecialchars($row["approve"]) ?>
                                    </span>
                                </td>
                            </tr>
                        <?php endwhile;
                        echo '</tbody></table></div>';

                    else: ?>
                        <div class="p-16 text-center">
                            <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                <i class="fas fa-search text-gray-300 text-3xl"></i>
                            </div>
                            <p class="text-gray-500 font-medium">ไม่พบข้อมูลสมาชิกในระบบ</p>
                        </div>
                    <?php endif; ?>
                </div>

            </div>
        </main>
    </div>

    <script>
        const menuBtn = document.getElementById('menuBtn');
        const closeBtn = document.getElementById('closeBtn');
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('overlay');

        function toggleSidebar() {
            // สลับสถานะ Sidebar (เลื่อนเข้า-ออก)
            sidebar.classList.toggle('-translate-x-full');
            // สลับสถานะ Overlay (แสดง-ซ่อน)
            overlay.classList.toggle('hidden');
            // ป้องกันการ Scroll หน้าจอเมื่อเปิดเมนูบนมือถือ
            document.body.classList.toggle('overflow-hidden');
        }

        menuBtn.addEventListener('click', toggleSidebar);
        closeBtn.addEventListener('click', toggleSidebar);
        overlay.addEventListener('click', toggleSidebar);

        // ปิด Sidebar เมื่อหน้าจอขยายกว้างขึ้น (เผื่อค้างไว้ตอนย่อจอ)
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