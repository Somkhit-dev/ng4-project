<?php
session_start();
require_once 'config.php'; // เชื่อมต่อฐานข้อมูล

// ตรวจสอบสิทธิ์ admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

// ตรวจสอบว่าผู้ใช้ล็อกอินแล้ว
if (!isset($_SESSION['user_id'])) {
    die("กรุณาล็อกอินก่อนใช้งาน");
}

$user_id = $_SESSION['user_id'];

$limit = 10;
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int) $_GET['page'] : 1;
$offset = ($page - 1) * $limit;

// Search term
$search_term = isset($_GET['search']) ? trim($_GET['search']) : '';
$search_wildcard = "%" . $search_term . "%";

// Total row count
$count_stmt = $conn->prepare("SELECT COUNT(*) AS total FROM form_fields WHERE user_id = ? AND (project_name LIKE ? OR responsible_person_name LIKE ?)");
$count_stmt->bind_param("iss", $user_id, $search_wildcard, $search_wildcard);
$count_stmt->execute();
$total_rows = $count_stmt->get_result()->fetch_assoc()['total'];
$count_stmt->close();
$total_pages = ceil($total_rows / $limit);

// Get paginated result
$stmt = $conn->prepare("SELECT * FROM form_fields WHERE user_id = ? AND (project_name LIKE ? OR responsible_person_name LIKE ?) ORDER BY id DESC LIMIT ? OFFSET ?");
$stmt->bind_param("issii", $user_id, $search_wildcard, $search_wildcard, $limit, $offset);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>แบบฟอร์มของฉัน - Admin System</title>
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

                <a href="list_form.php" class="flex items-center space-x-3 hover:bg-slate-800 p-3 rounded-lg transition text-gray-300 hover:text-white font-light">
                    <i class="fas fa-list w-5"></i> <span>List Form</span>
                </a>

                <a href="admin_form.php" class="flex items-center space-x-3 bg-blue-600 p-3 rounded-lg transition text-white">
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

            <footer class="mt-8 text-[10px] text-center text-gray-600 font-sans">
                <p>&copy; <?= date("Y"); ?> Admin Panel System</p>
            </footer>
        </aside>

        <div id="overlay" class="fixed inset-0 bg-black/60 z-40 hidden lg:hidden"></div>

        <main class="flex-1 p-4 md:p-8 lg:ml-64 transition-all">
            <div class="max-w-7xl mx-auto">
                
                <div class="mb-8 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                    <div>
                        <h2 class="text-2xl md:text-3xl font-extrabold text-gray-800 tracking-tight flex items-center gap-2">
                             แบบฟอร์มของฉัน
                        </h2>
                        <p class="text-gray-500 text-sm md:text-base">แสดงรายการแบบเสนอที่คุณเป็นเจ้าของ</p>
                    </div>
                    <a href="form/form1.php" target="_blank"
                       class="bg-green-600 text-white px-6 py-3 rounded-xl hover:bg-green-700 transition font-bold shadow-lg shadow-green-100 flex items-center gap-2 self-start">
                        <i class="fas fa-plus-circle"></i> สร้างแบบฟอร์มใหม่
                    </a>
                </div>

                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-200 mb-6">
                    <form method="GET" class="flex flex-col md:flex-row gap-4 items-center">
                        <div class="relative w-full md:w-96">
                            <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400">
                                <i class="fas fa-search"></i>
                            </span>
                            <input type="text" name="search" id="searchInput" value="<?= htmlspecialchars($search_term) ?>" 
                                   placeholder="ค้นชื่อโครงการ..."
                                   class="w-full pl-10 pr-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 outline-none transition">
                        </div>
                        <div class="flex gap-2 w-full md:w-auto">
                            <button type="submit" class="flex-1 md:flex-none bg-blue-600 text-white px-8 py-3 rounded-xl hover:bg-blue-700 transition font-bold">ค้นหา</button>
                            <button type="button" onclick="window.location.href='admin_form.php'" class="flex-1 md:flex-none text-center bg-gray-100 text-gray-600 px-8 py-3 rounded-xl hover:bg-gray-200 transition font-bold">รีเซ็ต</button>
                        </div>
                    </form>
                </div>

                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
                    <div class="p-6 border-b border-gray-100 bg-gray-50/50">
                        <h3 class="font-bold text-gray-700 text-lg flex items-center gap-2">
                            <i class="fas fa-file-invoice text-blue-600"></i> รายการโครงการของคุณ
                        </h3>
                    </div>

                    <?php if ($result->num_rows > 0): ?>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 p-4 lg:hidden">
                            <?php $m_idx = $offset + 1; while ($row = $result->fetch_assoc()): ?>
                                <div class="bg-white border-2 border-gray-50 rounded-2xl p-5 shadow-sm hover:border-blue-100 transition">
                                    <div class="flex justify-between items-center mb-3">
                                        <span class="text-xs font-mono font-bold text-blue-500 bg-blue-50 px-2 py-1 rounded">#<?= sprintf("%02d", $m_idx++) ?></span>
                                        <div class="flex gap-2">
                                            <a href="pdf/report.php?id=<?= $row['id'] ?>" target="_blank" class="p-2 bg-blue-50 text-blue-600 rounded-lg"><i class="fas fa-file-pdf"></i></a>
                                            <button class="delete-btn p-2 bg-red-50 text-red-600 rounded-lg" data-id="<?= $row['id'] ?>"><i class="fas fa-trash"></i></button>
                                        </div>
                                    </div>
                                    <h4 class="font-bold text-gray-800 mb-2 leading-tight"><?= htmlspecialchars($row['project_name']) ?></h4>
                                    <p class="text-xs text-gray-400 italic">ผู้รับผิดชอบ: <?= htmlspecialchars($row['responsible_person_name']) ?></p>
                                </div>
                            <?php endwhile; $result->data_seek(0); ?>
                        </div>

                        <div class="hidden lg:block overflow-x-auto">
                            <table class="w-full text-left">
                                <thead class="bg-gray-50 text-gray-500 text-xs uppercase tracking-widest border-b">
                                    <tr>
                                        <th class="px-6 py-4 w-20">#</th>
                                        <th class="px-6 py-4 w-7/12">ชื่อโครงการ</th>
                                        <th class="px-6 py-4">ผู้จัดทำ</th>
                                        <th class="px-6 py-4 text-center">การดำเนินการ</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100 bg-white">
                                    <?php $d_idx = $offset + 1; while ($row = $result->fetch_assoc()): ?>
                                        <tr class="hover:bg-blue-50/50 transition">
                                            <td class="px-6 py-4 text-gray-400 font-mono text-sm"><?= sprintf("%02d", $d_idx++) ?></td>
                                            <td class="px-6 py-4 font-bold text-gray-800 leading-tight"><?= htmlspecialchars($row['project_name']) ?></td>
                                            <td class="px-6 py-4 text-gray-600 italic text-sm"><?= htmlspecialchars($row['responsible_person_name']) ?></td>
                                            <td class="px-6 py-4 text-center">
                                                <div class="flex justify-center gap-2">
                                                    <a href="pdf/report.php?id=<?= $row['id'] ?>" target="_blank"
                                                       class="bg-blue-600 text-white px-4 py-2 rounded-xl text-xs font-bold hover:bg-blue-700 transition shadow-sm flex items-center gap-2 uppercase">
                                                        <i class="fas fa-file-pdf"></i> PDF
                                                    </a>
                                                    <button data-id="<?= $row['id'] ?>"
                                                        class="delete-btn bg-red-50 text-red-600 px-4 py-2 rounded-xl text-xs font-bold hover:bg-red-600 hover:text-white transition flex items-center gap-2 border border-red-100">
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
                                <i class="fas fa-chevron-left mr-1"></i> ก่อนหน้า
                            </a>
                        <?php endif; ?>

                        <span class="px-5 py-2 bg-gray-200 text-gray-700 font-bold rounded-xl text-sm">หน้า <?= $page ?> / <?= $total_pages ?></span>

                        <?php if ($page < $total_pages): ?>
                            <a href="?page=<?= $page + 1 ?>&search=<?= urlencode($search_term) ?>"
                               class="p-2 px-6 bg-white border border-gray-200 text-gray-600 rounded-xl hover:bg-blue-600 hover:text-white transition font-bold shadow-sm">
                                ถัดไป <i class="fas fa-chevron-right ml-1"></i>
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
        // Sidebar Toggle
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

        // SweetAlert Delete & Status
        document.addEventListener('DOMContentLoaded', function() {
            const urlParams = new URLSearchParams(window.location.search);
            if (urlParams.get('status') === 'success') {
                Swal.fire({ toast: true, position: 'top-end', icon: 'success', title: 'ลบรายการสำเร็จ', showConfirmButton: false, timer: 3000, timerProgressBar: true });
            }

            document.querySelectorAll('.delete-btn').forEach(btn => {
                btn.addEventListener('click', function() {
                    const id = this.dataset.id;
                    Swal.fire({
                        title: 'ยืนยันการลบ?',
                        text: "คุณจะไม่สามารถกู้คืนข้อมูลนี้ได้!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#ef4444',
                        cancelButtonColor: '#6b7280',
                        confirmButtonText: 'ใช่, ลบเลย!',
                        cancelButtonText: 'ยกเลิก',
                        customClass: { confirmButton: 'rounded-xl font-bold px-6', cancelButton: 'rounded-xl font-bold px-6' }
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = `form/delete_form.php?id=${id}`;
                        }
                    });
                });
            });
        });

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