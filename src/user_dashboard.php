<?php
session_start();
require 'config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// ============================
// Pagination + Search
// ============================
$limit = 10;
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int) $_GET['page'] : 1;
$offset = ($page - 1) * $limit;

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
    <title>Dashboard - แบบฟอร์มของฉัน</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Sarabun:wght@300;400;600;700&display=swap');
        body { font-family: 'Sarabun', sans-serif; }
    </style>
</head>

<body class="bg-slate-50 text-slate-800">
    <div class="min-h-screen flex flex-col">
    <header class="bg-white border-b border-slate-200 sticky top-0 z-50">
        <div class="container mx-auto px-4 py-4 flex flex-col md:flex-row justify-between items-center gap-4">
            <div class="flex items-center gap-2">
                <div class="bg-blue-600 p-2 rounded-lg text-white">
                    <i class="fas fa-id-badge text-xl"></i>
                </div>
                <h1 class="text-xl font-bold tracking-tight text-slate-900 uppercase">ระบบจัดทำแบบเสนอรายละเอียดคำชี้แจงรายการครุภัณฑ์ มทร.อีสาน</h1>
            </div>
            
            <nav class="flex items-center gap-1 md:gap-4 text-sm font-medium">
                <a href="user_dashboard.php" class="px-4 py-2 text-blue-600 bg-blue-50 rounded-xl transition">หน้าหลัก</a>
                <a href="profile.php"class="px-4 py-2 text-slate-600 hover:bg-slate-100 rounded-xl transition">ข้อมูลส่วนตัว</a>
                <a href="contact.php" class="px-4 py-2 text-slate-600 hover:bg-slate-100 rounded-xl transition">ติดต่อ</a>
                <div class="h-6 w-px bg-slate-200 mx-2 hidden md:block"></div>
                <a href="logout.php" class="px-4 py-2 bg-red-50 text-red-600 hover:bg-red-100 rounded-xl transition flex items-center gap-2">
                    <i class="fas fa-sign-out-alt"></i> ออกจากระบบ
                </a>
            </nav>
        </div>
    </header>

        <div class="bg-gradient-to-r from-blue-600 to-blue-500 text-white py-4 mb-6 shadow-md">
            <div class="container mx-auto px-10">
            <div class="flex items-center justify-center gap-3">
                <h1 class="text-2xl font-bold">DASHBOARD</h1>
            </div>
            </div>
        </div>

        <main class="container mx-auto px-4 pb-20 flex-grow">
            <div class="flex flex-col lg:flex-row justify-between items-stretch lg:items-center gap-6 mb-8">
                <div class="flex-1">
                    <form method="GET" class="relative group">
                        <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-slate-400 group-focus-within:text-blue-500 transition">
                            <i class="fas fa-search"></i>
                        </span>
                        <input type="text" name="search" value="<?= htmlspecialchars($search_term) ?>"
                            placeholder="ค้นชื่อโครงการ หรือชื่อผู้จัดทำ..."
                            class="w-full pl-11 pr-32 py-4 bg-white border border-slate-200 rounded-2xl shadow-sm focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none transition">
                        <div class="absolute inset-y-0 right-0 p-1.5 flex gap-1">
                            <?php if($search_term): ?>
                                <a href="user_dashboard.php" class="px-4 flex items-center text-slate-400 hover:text-slate-600 transition">
                                    ล้างค่า
                                </a>
                            <?php endif; ?>
                            <button type="submit" class="bg-blue-600 text-white px-6 rounded-xl hover:bg-blue-700 transition font-bold">
                                ค้นหา
                            </button>
                        </div>
                    </form>
                </div>

                <a href="form/form1.php" target="_blank"
                    class="bg-emerald-600 text-white px-8 py-4 rounded-2xl hover:bg-emerald-700 shadow-lg shadow-emerald-200 transition font-bold flex items-center justify-center gap-2 whitespace-nowrap">
                    <i class="fas fa-plus-circle"></i> สร้างแบบฟอร์มใหม่
                </a>
            </div>

            <?php if ($result->num_rows > 0): ?>
                <div class="hidden lg:block bg-white shadow-xl shadow-slate-200/50 rounded-3xl border border-slate-100 overflow-hidden">
                    <table class="w-full text-left">
                        <thead>
                            <tr class="bg-slate-50 text-slate-500 text-xs uppercase tracking-widest font-bold">
                                <th class="px-8 py-5 border-b border-slate-100 w-16">#</th>
                                <th class="px-8 py-5 border-b border-slate-100">ชื่อโครงการ</th>
                                <th class="px-8 py-5 border-b border-slate-100">ผู้จัดทำ</th>
                                <th class="px-8 py-5 border-b border-slate-100 text-center">จัดการ</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50">
                            <?php $i = $offset + 1; while ($row = $result->fetch_assoc()): ?>
                                <tr class="hover:bg-blue-50/30 transition group">
                                    <td class="px-8 py-6 text-slate-400 font-mono text-sm"><?= sprintf("%02d", $i++) ?></td>
                                    <td class="px-8 py-6">
                                        <div class="font-bold text-slate-800 text-lg group-hover:text-blue-700 transition leading-tight">
                                            <?= htmlspecialchars($row['project_name']) ?>
                                        </div>
                                    </td>
                                    <td class="px-8 py-6 text-slate-500 font-medium"><?= htmlspecialchars($row['responsible_person_name']) ?></td>
                                    <td class="px-8 py-6">
                                        <div class="flex justify-center items-center gap-2">
                                            <a href="pdf/report.php?id=<?= $row['id'] ?>" target="_blank" 
                                               class="bg-blue-100 text-blue-600 px-5 py-2.5 rounded-xl text-xs font-bold hover:bg-blue-600 hover:text-white transition flex items-center gap-2 shadow-sm">
                                                <i class="fas fa-file-pdf"></i> พิมพ์ PDF
                                            </a>
                                            <button data-id="<?= $row['id'] ?>"
                                                class="delete-btn bg-slate-100 text-slate-500 px-4 py-2.5 rounded-xl text-xs font-bold hover:bg-red-500 hover:text-white transition">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            <?php endwhile; $result->data_seek(0); ?>
                        </tbody>
                    </table>
                </div>

                <div class="lg:hidden grid grid-cols-1 gap-4">
                    <?php $i = $offset + 1; while ($row = $result->fetch_assoc()): ?>
                        <div class="bg-white p-6 rounded-3xl shadow-sm border border-slate-100">
                            <div class="flex justify-between items-start mb-4">
                                <span class="text-xs font-bold text-slate-300">#<?= sprintf("%02d", $i++) ?></span>
                                <button data-id="<?= $row['id'] ?>" class="delete-btn text-slate-300 hover:text-red-500 p-2"><i class="fas fa-trash-alt"></i></button>
                            </div>
                            <h4 class="font-bold text-slate-800 text-lg mb-2 leading-snug"><?= htmlspecialchars($row['project_name']) ?></h4>
                            <p class="text-sm text-slate-500 mb-6 italic"><?= htmlspecialchars($row['responsible_person_name']) ?></p>
                            <a href="pdf/report.php?id=<?= $row['id'] ?>" target="_blank" 
                               class="w-full bg-blue-600 text-white py-3 rounded-2xl flex items-center justify-center gap-2 font-bold shadow-lg shadow-blue-200">
                                <i class="fas fa-file-pdf"></i> ดาวน์โหลด/พิมพ์ PDF
                            </a>
                        </div>
                    <?php endwhile; ?>
                </div>

                <div class="mt-12 flex justify-center items-center gap-2">
                    <?php if ($page > 1): ?>
                        <a href="?page=<?= $page - 1 ?>&search=<?= urlencode($search_term) ?>"
                            class="w-12 h-12 bg-white border border-slate-200 flex items-center justify-center rounded-2xl text-slate-600 hover:bg-blue-600 hover:text-white transition shadow-sm">
                            <i class="fas fa-chevron-left"></i>
                        </a>
                    <?php endif; ?>

                    <div class="bg-white border border-slate-200 px-6 py-3 rounded-2xl font-bold text-slate-700 shadow-sm">
                        หน้า <?= $page ?> / <?= $total_pages ?>
                    </div>

                    <?php if ($page < $total_pages): ?>
                        <a href="?page=<?= $page + 1 ?>&search=<?= urlencode($search_term) ?>"
                            class="w-12 h-12 bg-white border border-slate-200 flex items-center justify-center rounded-2xl text-slate-600 hover:bg-blue-600 hover:text-white transition shadow-sm">
                            <i class="fas fa-chevron-right"></i>
                        </a>
                    <?php endif; ?>
                </div>

            <?php else: ?>
                <div class="bg-white p-20 rounded-3xl border border-dashed border-slate-300 text-center">
                    <div class="bg-slate-50 w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-6">
                        <i class="fas fa-folder-open text-3xl text-slate-300"></i>
                    </div>
                    <h3 class="text-xl font-bold text-slate-800">ไม่พบแบบฟอร์ม</h3>
                    <p class="text-slate-400 mt-2">ยังไม่มีข้อมูลที่คุณค้นหา หรือคุณยังไม่ได้สร้างแบบฟอร์ม</p>
                </div>
            <?php endif; ?>
        </main>

    <footer class="bg-slate-900 text-slate-500 py-10 mt-10">
        <div class="container mx-auto px-4 text-center">
            <p class="text-sm">© <?= date("Y") ?> ระบบจัดทำแบบเสนอรายละเอียดคำชี้แจงรายการครุภัณฑ์ (ง4)</p>
            <p class="text-[10px] mt-2 uppercase tracking-widest opacity-50">Rajamangala University of Technology Isan</p>
        </div>
    </footer>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // ตรวจสอบสถานะจาก URL
            const urlParams = new URLSearchParams(window.location.search);
            const status = urlParams.get('status');

            if (status === 'success') {
                Swal.fire({
                    toast: true, position: 'top-end', icon: 'success', title: 'ลบรายการสำเร็จ', showConfirmButton: false, timer: 3000, timerProgressBar: true
                });
            }

            // จัดการปุ่มลบ
            document.querySelectorAll('.delete-btn').forEach(function(btn) {
                btn.addEventListener('click', function() {
                    const id = this.dataset.id;
                    Swal.fire({
                        title: 'ยืนยันการลบ?',
                        text: "คุณจะไม่สามารถกู้คืนข้อมูลนี้ได้อีก!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#ef4444',
                        cancelButtonColor: '#64748b',
                        confirmButtonText: 'ลบข้อมูล',
                        cancelButtonText: 'ยกเลิก',
                        customClass: {
                            confirmButton: 'rounded-2xl font-bold px-8 py-3',
                            cancelButton: 'rounded-2xl font-bold px-8 py-3'
                        }
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = `form/delete_form.php?id=${id}`;
                        }
                    });
                });
            });
        });
    </script>
</body>

</html>