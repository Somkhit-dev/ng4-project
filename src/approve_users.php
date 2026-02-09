<?php
session_start();
require_once 'config.php'; 

// ตรวจสอบสิทธิ์ Admin
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
    <title>Approve Users - Admin System</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Sarabun:wght@300;400;600;700&display=swap');
        body { font-family: 'Sarabun', sans-serif; }
        /* ปรับแต่งสไตล์ปุ่ม SweetAlert ให้เข้ากับธีม */
        .swal2-popup { border-radius: 1.5rem !important; font-family: 'Sarabun', sans-serif !important; }
        .swal2-confirm { border-radius: 0.75rem !important; font-weight: 700 !important; }
        .swal2-cancel { border-radius: 0.75rem !important; font-weight: 700 !important; }
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
                
                <a href="approve_users.php" class="flex items-center space-x-3 bg-blue-600 p-3 rounded-lg transition text-white">
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

            <footer class="mt-8 text-[10px] text-center text-gray-600 italic">
                <p>&copy; <?= date("Y"); ?> Admin Panel System</p>
            </footer>
        </aside>

        <div id="overlay" class="fixed inset-0 bg-black/60 z-40 hidden lg:hidden"></div>

        <main class="flex-1 p-4 md:p-8 lg:ml-64 transition-all">
            <div class="max-w-7xl mx-auto">
                
                <div class="mb-8 flex flex-col md:flex-row md:items-end md:justify-between gap-4">
                    <div>
                        <h2 class="text-2xl md:text-4xl font-extrabold text-gray-800 tracking-tight">APPROVE USERS</h2>
                        <p class="text-gray-500 text-sm md:text-base italic">ตรวจสอบและอนุมัติการสมัครสมาชิกของผู้ใช้ใหม่</p>
                    </div>
                    <div class="bg-white px-4 py-2 rounded-xl shadow-sm border border-gray-200 text-sm inline-flex items-center gap-2 self-start">
                        <span class="w-2 h-2 bg-orange-500 rounded-full animate-pulse"></span>
                        <span class="text-gray-600 font-medium italic">Pending Verification</span>
                    </div>
                </div>

                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
                    <div class="p-6 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
                        <h3 class="font-bold text-gray-700 text-lg flex items-center">
                            <i class="fas fa-user-clock text-orange-500 mr-2"></i> สมาชิกที่รอการอนุมัติ
                        </h3>
                    </div>

                    <?php
                    $sql = "SELECT * FROM users WHERE role = 'member' AND approve != 'อนุมัติแล้ว' ORDER BY user_id ASC";
                    $result = $conn->query($sql);

                    if ($result && $result->num_rows > 0): 
                        
                        // --- Mobile Cards ---
                        echo '<div class="grid grid-cols-1 md:grid-cols-2 gap-4 p-4 lg:hidden">';
                        $m_idx = 1;
                        while ($row = $result->fetch_assoc()): ?>
                            <div class="bg-white border-2 border-gray-50 rounded-2xl p-5 shadow-sm">
                                <div class="flex justify-between items-start mb-4">
                                    <div class="w-10 h-10 bg-blue-100 text-blue-700 rounded-xl flex items-center justify-center font-bold">
                                        <?= $m_idx++ ?>
                                    </div>
                                    <span class="px-3 py-1 bg-yellow-100 text-yellow-700 rounded-full text-[10px] font-bold uppercase tracking-wider border border-yellow-200">
                                        <?= htmlspecialchars($row["approve"]) ?>
                                    </span>
                                </div>
                                <h4 class="font-bold text-gray-800 text-lg"><?= htmlspecialchars($row["prename"].$row["firstname"].' '.$row["lastname"]) ?></h4>
                                <div class="mt-3 space-y-2 text-sm text-gray-600">
                                    <p class="flex items-center gap-2 truncate"><i class="far fa-envelope text-blue-400 w-4"></i> <?= htmlspecialchars($row["email"]) ?></p>
                                    <p class="flex items-center gap-2"><i class="fas fa-building text-blue-400 w-4"></i> <?= htmlspecialchars($row["agency"]) ?></p>
                                    <p class="flex items-center gap-2"><i class="fas fa-phone text-blue-400 w-4"></i> <?= htmlspecialchars($row["phone"]) ?></p>
                                </div>
                                
                                <div class="mt-5">
                                    <form method="POST" action="approve_users_db.php">
                                        <input type="hidden" name="user_id" value="<?= htmlspecialchars($row["user_id"]) ?>">
                                        <button type="button" onclick="confirmApprove(this)" class="w-full bg-green-500 text-white py-3 rounded-xl font-bold hover:bg-green-600 transition shadow-lg shadow-green-100 flex items-center justify-center gap-2">
                                            <i class="fas fa-check-circle"></i> อนุมัติการใช้งาน
                                        </button>
                                    </form>
                                </div>
                                
                                <div class="mt-4 pt-4 border-t border-gray-50 text-[10px] text-gray-400 text-right uppercase italic">
                                    Applied: <?= $row["created_at"] ?>
                                </div>
                            </div>
                        <?php endwhile;
                        echo '</div>';

                        // --- Desktop Table ---
                        echo '<div class="hidden lg:block overflow-x-auto">';
                        echo '<table class="w-full text-left border-collapse">';
                        echo '<thead class="bg-gray-50 text-gray-500 text-xs uppercase tracking-widest border-b border-gray-100">';
                        echo '<tr>';
                        echo '<th class="px-6 py-4 font-bold">ลำดับ</th>';
                        echo '<th class="px-6 py-4 font-bold">ชื่อ-สกุล</th>';
                        echo '<th class="px-6 py-4 font-bold">รายละเอียด</th>';
                        echo '<th class="px-6 py-4 font-bold">อนุมัติเมื่อ</th>';
                        echo '<th class="px-6 py-4 text-center font-bold">ดำเนินการ</th>';
                        echo '</tr>';
                        echo '</thead>';
                        echo '<tbody class="divide-y divide-gray-50 bg-white">';
                        
                        $result->data_seek(0); 
                        $d_idx = 1;
                        while ($row = $result->fetch_assoc()): ?>
                            <tr class="hover:bg-blue-50/30 transition group">
                                <td class="px-6 py-4 text-gray-400 font-mono text-sm"><?= sprintf("%02d", $d_idx++) ?></td>
                                <td class="px-6 py-4">
                                    <div class="font-bold text-gray-800"><?= htmlspecialchars($row["prename"].$row["firstname"].' '.$row["lastname"]) ?></div>
                                    <div class="text-[10px] bg-yellow-50 text-yellow-600 px-2 rounded-md font-bold inline-block border border-yellow-100 mt-1 uppercase"><?= htmlspecialchars($row["approve"]) ?></div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm text-blue-600 font-medium"><?= htmlspecialchars($row["email"]) ?></div>
                                    <div class="text-xs text-gray-500 italic"><?= htmlspecialchars($row["agency"]) ?></div>
                                    <div class="text-xs text-gray-400"><?= htmlspecialchars($row["phone"]) ?></div>
                                </td>
                                <td class="px-6 py-4 text-xs text-gray-400 italic font-medium"><?= $row["created_at"] ?></td>
                                <td class="px-6 py-4 text-center">
                                    <form method="POST" action="approve_users_db.php">
                                        <input type="hidden" name="user_id" value="<?= htmlspecialchars($row["user_id"]) ?>">
                                        <button type="button" onclick="confirmApprove(this)" class="inline-flex items-center gap-2 bg-green-500 text-white px-5 py-2 rounded-lg text-sm font-bold hover:bg-green-600 transition shadow-md hover:shadow-lg transform hover:-translate-y-0.5">
                                            <i class="fas fa-check"></i> อนุมัติ
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        <?php endwhile;
                        echo '</tbody></table></div>';

                    else: ?>
                        <div class="p-20 text-center">
                            <div class="w-20 h-20 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-4 border-2 border-dashed border-gray-200">
                                <i class="fas fa-check-double text-gray-300 text-3xl"></i>
                            </div>
                            <p class="text-gray-500 font-medium text-lg">ไม่มีสมาชิกที่รอการตรวจสอบในขณะนี้</p>
                            <p class="text-gray-400 text-sm italic mt-1">All members have been verified.</p>
                        </div>
                    <?php endif; ?>
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

        // SweetAlert2 Confirmation Logic
        function confirmApprove(button) {
            const form = button.closest('form');
            
            Swal.fire({
                title: 'ยืนยันการอนุมัติ?',
                text: "คุณต้องการอนุมัติให้ผู้ใช้นี้เข้าสู่ระบบใช่หรือไม่?",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#10b981', // green-500
                cancelButtonColor: '#6b7280',  // gray-500
                confirmButtonText: '<i class="fas fa-check-circle mr-2"></i> ใช่, อนุมัติเลย',
                cancelButtonText: 'ยกเลิก',
                reverseButtons: true,
                customClass: {
                    popup: 'shadow-2xl'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    // Show Loading
                    Swal.fire({
                        title: 'กำลังบันทึกข้อมูล...',
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });
                    form.submit();
                }
            });
        }

        // Handle Responsive Sidebar
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

    <?php if(isset($_GET['status'])): ?>
        <script>
            const status = "<?= $_GET['status'] ?>";
            if(status === 'success') {
                Swal.fire({
                    icon: 'success',
                    title: 'อนุมัติเรียบร้อย!',
                    text: 'ผู้ใช้งานสามารถเข้าสู่ระบบได้แล้ว',
                    timer: 3000,
                    confirmButtonColor: '#3b82f6'
                });
            } else if(status === 'error') {
                Swal.fire({
                    icon: 'error',
                    title: 'เกิดข้อผิดพลาด',
                    text: 'ไม่สามารถดำเนินการได้ในขณะนี้',
                    confirmButtonColor: '#ef4444'
                });
            }
        </script>
    <?php endif; ?>

</body>
</html>