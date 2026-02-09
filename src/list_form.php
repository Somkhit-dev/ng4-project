<?php
session_start();
require_once 'config.php'; // เชื่อมต่อฐานข้อมูล

// ตรวจสอบสิทธิ์ admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

// ============================
// Pagination + Search
// ============================
$limit = 10;
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int) $_GET['page'] : 1;
$offset = ($page - 1) * $limit;

$search_term = isset($_GET['search']) ? trim($_GET['search']) : '';
$search_wildcard = "%" . $search_term . "%";

// นับจำนวนข้อมูลทั้งหมด
if ($search_term !== '') {
    $count_stmt = $conn->prepare("SELECT COUNT(*) AS total FROM form_fields 
        WHERE project_name LIKE ? OR responsible_person_name LIKE ?");
    $count_stmt->bind_param("ss", $search_wildcard, $search_wildcard);
} else {
    $count_stmt = $conn->prepare("SELECT COUNT(*) AS total FROM form_fields");
}
$count_stmt->execute();
$total_rows = $count_stmt->get_result()->fetch_assoc()['total'];
$count_stmt->close();

$total_pages = ceil($total_rows / $limit);

// ดึงข้อมูลจริง
if ($search_term !== '') {
    $stmt = $conn->prepare("SELECT * FROM form_fields 
        WHERE project_name LIKE ? OR responsible_person_name LIKE ? 
        ORDER BY id DESC LIMIT ? OFFSET ?");
    $stmt->bind_param("ssii", $search_wildcard, $search_wildcard, $limit, $offset);
} else {
    $stmt = $conn->prepare("SELECT * FROM form_fields 
        ORDER BY id DESC LIMIT ? OFFSET ?");
    $stmt->bind_param("ii", $limit, $offset);
}
$stmt->execute();
$result = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Index Page - Admin System</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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

                <a href="list_form.php" class="flex items-center space-x-3 bg-blue-600 p-3 rounded-lg transition text-white">
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
            <div class="max-w-7xl mx-auto">
                
                <div class="mb-8 flex flex-col md:flex-row md:items-end md:justify-between gap-4">
                    <div>
                        <h2 class="text-2xl md:text-4xl font-extrabold text-gray-800 tracking-tight">รายการฟอร์มทั้งหมด</h2>
                        <p class="text-gray-500 text-sm md:text-base italic">จัดการและแก้ไขข้อมูลโครงการในระบบ</p>
                    </div>
                </div>

                <?php if (isset($_GET['status'])): ?>
                    <script>
                        document.addEventListener("DOMContentLoaded", function() {
                            const Toast = Swal.mixin({
                                toast: true,
                                position: 'top-end',
                                showConfirmButton: false,
                                timer: 3000,
                                timerProgressBar: true
                            });
                            <?php if ($_GET['status'] === "success"): ?>
                                Toast.fire({ icon: "success", title: "ดำเนินการเรียบร้อยแล้ว" });
                            <?php elseif ($_GET['status'] === "error"): ?>
                                Swal.fire({ icon: "error", title: "เกิดข้อผิดพลาด", text: "ไม่สามารถดำเนินการได้" });
                            <?php endif; ?>
                        });
                    </script>
                <?php endif; ?>

                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-200 mb-6">
                    <form method="GET" id="searchForm" class="flex flex-col md:flex-row gap-4 items-center">
                        <div class="relative w-full md:w-96">
                            <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400">
                                <i class="fas fa-search"></i>
                            </span>
                            <input type="text" name="search" id="searchInput" value="<?= htmlspecialchars($search_term) ?>" 
                                   placeholder="ค้นหาชื่อโครงการ หรือ ผู้จัดทำ..."
                                   class="w-full pl-10 pr-4 py-2 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 outline-none transition">
                        </div>
                        <div class="flex gap-2 w-full md:w-auto">
                            <button type="submit" class="flex-1 md:flex-none bg-blue-600 text-white px-8 py-2 rounded-xl hover:bg-blue-700 transition font-bold shadow-md shadow-blue-100">ค้นหา</button>
                            <button type="button" onclick="window.location.href='list_form.php'" class="flex-1 md:flex-none text-center bg-gray-100 text-gray-600 px-8 py-3 rounded-xl hover:bg-gray-200 transition font-bold">รีเซ็ต</button>
                        </div>
                    </form>
                </div>

                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
                    <div class="p-6 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
                        <h3 class="font-bold text-gray-700 text-lg flex items-center">
                            <i class="fas fa-file-invoice text-blue-600 mr-2"></i> ข้อมูลโครงการ (<?= $total_rows ?> รายการ)
                        </h3>
                    </div>

                    <?php if ($result->num_rows > 0): ?>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 p-4 lg:hidden">
                            <?php $m_idx = $offset + 1; while ($row = $result->fetch_assoc()): ?>
                                <div class="bg-white border border-gray-100 rounded-2xl p-5 shadow-sm">
                                    <div class="flex justify-between items-start mb-3">
                                        <span class="text-xs font-mono font-bold text-blue-500 bg-blue-50 px-2 py-1 rounded"># <?= sprintf("%02d", $m_idx++) ?></span>
                                        <div class="flex gap-2">
                                            <a href="pdf/report.php?id=<?= $row['id'] ?>" target="_blank" class="p-2 bg-blue-50 text-blue-600 rounded-lg"><i class="fas fa-file-pdf"></i></a>
                                            <button onclick="confirmDelete(<?= $row['id'] ?>)" class="p-2 bg-red-50 text-red-600 rounded-lg"><i class="fas fa-trash"></i></button>
                                        </div>
                                    </div>
                                    <h4 class="font-bold text-gray-800 mb-2"><?= htmlspecialchars($row['project_name']) ?></h4>
                                    <p class="text-sm text-gray-500 italic flex items-center gap-2"><i class="fas fa-user-circle"></i> <?= htmlspecialchars($row['responsible_person_name']) ?></p>
                                </div>
                            <?php endwhile; $result->data_seek(0); ?>
                        </div>

                        <div class="hidden lg:block overflow-x-auto">
                            <table class="w-full text-left border-collapse">
                                <thead class="bg-gray-50 text-gray-500 text-xs uppercase tracking-widest border-b">
                                    <tr>
                                        <th class="px-6 py-4 w-20">ลำดับ</th>
                                        <th class="px-6 py-4">ชื่อโครงการ</th>
                                        <th class="px-6 py-4">ผู้จัดทำ</th>
                                        <th class="px-6 py-4 text-center">การดำเนินการ</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-50 bg-white">
                                    <?php $d_idx = $offset + 1; while ($row = $result->fetch_assoc()): ?>
                                        <tr class="hover:bg-blue-50/30 transition group">
                                            <td class="px-6 py-4 text-gray-400 font-mono text-sm"><?= sprintf("%02d", $d_idx++) ?></td>
                                            <td class="px-6 py-4 font-bold text-gray-800"><?= htmlspecialchars($row['project_name']) ?></td>
                                            <td class="px-6 py-4 text-gray-600 italic"><?= htmlspecialchars($row['responsible_person_name']) ?></td>
                                            <td class="px-6 py-4">
                                                <div class="flex justify-center gap-2">
                                                    <a href="pdf/report.php?id=<?= $row['id'] ?>" target="_blank"
                                                       class="bg-blue-100 text-blue-700 px-4 py-2 rounded-xl text-xs font-bold hover:bg-blue-600 hover:text-white transition flex items-center gap-2">
                                                        <i class="fas fa-file-pdf"></i> PDF
                                                    </a>
                                                    <button onclick="confirmDelete(<?= $row['id'] ?>)"
                                                        class="bg-red-50 text-red-600 px-4 py-2 rounded-xl text-xs font-bold hover:bg-red-600 hover:text-white transition flex items-center gap-2 border border-red-100">
                                                        <i class="fas fa-trash"></i> ลบ
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endwhile; ?>
                                </tbody>
                            </table>
                        </div>

                    <?php else: ?>
                        <div class="p-20 text-center">
                            <i class="fas fa-search text-6xl text-gray-200 mb-4"></i>
                            <p class="text-gray-500 font-medium">ไม่พบข้อมูลที่ค้นหา</p>
                        </div>
                    <?php endif; ?>
                </div>

                <?php if ($total_pages > 1): ?>
                    <div class="mt-8 flex justify-center items-center gap-2 pb-10">
                        <?php if ($page > 1): ?>
                            <a href="?page=<?= $page - 1 ?>&search=<?= urlencode($search_term) ?>"
                               class="p-2 px-6 bg-white border border-gray-200 text-gray-600 rounded-xl hover:bg-blue-600 hover:text-white transition font-bold shadow-sm">
                                <i class="fas fa-arrow-left mr-2"></i> ก่อนหน้า
                            </a>
                        <?php endif; ?>

                        <span class="px-5 py-2 bg-gray-200 text-gray-700 font-bold rounded-xl text-sm">หน้า <?= $page ?> / <?= $total_pages ?></span>

                        <?php if ($page < $total_pages): ?>
                            <a href="?page=<?= $page + 1 ?>&search=<?= urlencode($search_term) ?>"
                               class="p-2 px-6 bg-white border border-gray-200 text-gray-600 rounded-xl hover:bg-blue-600 hover:text-white transition font-bold shadow-sm">
                                ถัดไป <i class="fas fa-arrow-right ml-2"></i>
                            </a>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>

            </div>
        </main>
    </div>

    <footer class="bg-gray-900 text-gray-500 py-6 text-center text-xs lg:ml-64 transition-all">
        &copy; <?= date("Y") ?> แบบเสนอรายละเอียดคำชี้แจงรายการครุภัณฑ์ มทร.อีสาน. สงวนลิขสิทธิ์.
    </footer>

    <script>
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('overlay');

        function toggleSidebar() {
            sidebar.classList.toggle('-translate-x-full');
            overlay.classList.toggle('hidden');
            document.body.classList.toggle('overflow-hidden');
        }

        document.getElementById('menuBtn').addEventListener('click', toggleSidebar);
        document.getElementById('closeBtn').addEventListener('click', toggleSidebar);
        overlay.addEventListener('click', toggleSidebar);

        // ฟังก์ชัน Reset ค้นหา (แก้ปัญหาปุ่มใช้ไม่ได้)
        function resetSearch() {
            document.getElementById('searchInput').value = '';
            // ตรวจสอบชื่อไฟล์ให้ตรงกับไฟล์จริงของคุณ
            window.location.href = 'Edit_index.php'; 
        }

        function confirmDelete(id) {
            Swal.fire({
                title: 'คุณแน่ใจหรือไม่?',
                text: "หากลบแล้วจะไม่สามารถกู้คืนได้!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'ใช่, ลบเลย!',
                cancelButtonText: 'ยกเลิก',
                customClass: { confirmButton: 'rounded-xl px-6 py-2 font-bold', cancelButton: 'rounded-xl px-6 py-2 font-bold' }
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "form/delete_form_admin.php?id=" + id;
                }
            })
        }

        window.addEventListener('resize', () => {
            if (window.innerWidth >= 1024) {
                sidebar.classList.remove('-translate-x-full');
                overlay.classList.add('hidden');
                document.body.classList.remove('overflow-hidden');
            }
        });
    </script>
</body>
</html>