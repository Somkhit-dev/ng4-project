<?php
session_start();
require_once 'config.php';

// ตรวจสอบล็อกอิน
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$sql = "SELECT prename, firstname, lastname, agency, phone, email FROM users WHERE user_id = ?";
$stmt = $conn->prepare($sql);

if (!$stmt) {
    die("เกิดข้อผิดพลาดในคำสั่ง SQL: " . $conn->error);
}

$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ข้อมูลส่วนตัว - My Profile</title>
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
                    <i class="fas fa-id-badge text-xl"></i>
                </div>
                <h1 class="text-xl font-bold tracking-tight text-slate-900 uppercase">ระบบจัดทำแบบเสนอรายละเอียดคำชี้แจงรายการครุภัณฑ์ มทร.อีสาน</h1>
            </div>
            
            <nav class="flex items-center gap-1 md:gap-4 text-sm font-medium">
                <a href="user_dashboard.php" class="px-4 py-2 text-slate-600 hover:bg-slate-100 rounded-xl transition">หน้าหลัก</a>
                <a href="profile.php" class="px-4 py-2 text-blue-600 bg-blue-50 rounded-xl transition">ข้อมูลส่วนตัว</a>
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
                <h1 class="text-2xl font-bold">PROFILE</h1>
            </div>
            </div>
        </div>

    <main class="container mx-auto px-4 py-10">
        <div class="max-w-3xl mx-auto">
            
            <div class="bg-blue-900 rounded-t-3xl p-8 text-white flex flex-col items-center md:flex-row md:items-end gap-6 relative overflow-hidden">
                <div class="z-10 bg-white/20 p-4 rounded-full backdrop-blur-md border border-white/30">
                    <i class="fas fa-user-circle text-6xl"></i>
                </div>
                <div class="z-10 text-center md:text-left">
                    <h2 class="text-2xl font-bold"><?= htmlspecialchars($user['firstname'] . " " . $user['lastname']); ?></h2>
                    <p class="text-blue-200 text-sm italic"><?= htmlspecialchars($user['email']); ?></p>
                </div>
                <i class="fas fa-shield-alt absolute -right-10 -bottom-10 text-9xl text-white/5 rotate-12"></i>
            </div>

            <div class="bg-white shadow-xl shadow-slate-200/50 rounded-b-3xl overflow-hidden border border-slate-100 border-t-0">
                
                <div class="flex bg-slate-50 border-b border-slate-100 p-1">
                    <button class="tab-button flex-1 py-4 flex items-center justify-center gap-2 rounded-2xl font-bold transition-all text-blue-600 bg-white shadow-sm" data-tab="profile">
                        <i class="fas fa-user-check"></i> ข้อมูลส่วนตัว
                    </button>
                    <button class="tab-button flex-1 py-4 flex items-center justify-center gap-2 rounded-2xl font-bold transition-all text-slate-500 hover:bg-white/50" data-tab="password">
                        <i class="fas fa-key"></i> เปลี่ยนรหัสผ่าน
                    </button>
                </div>

                <div class="p-8">
                    <div class="tab-content animate-in fade-in duration-300" id="profile">
                        <?php if ($user): ?>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            <div class="space-y-1">
                                <p class="text-xs font-bold text-slate-400 uppercase tracking-widest flex items-center gap-2">
                                    <i class="fas fa-user text-blue-500"></i> ชื่อ-นามสกุล
                                </p>
                                <p class="text-lg font-semibold text-slate-800 border-b border-slate-50 pb-2">
                                    <?= htmlspecialchars($user['prename'] . $user['firstname'] . " " . $user['lastname']); ?>
                                </p>
                            </div>

                            <div class="space-y-1">
                                <p class="text-xs font-bold text-slate-400 uppercase tracking-widest flex items-center gap-2">
                                    <i class="fas fa-building text-emerald-500"></i> หน่วยงาน
                                </p>
                                <p class="text-lg font-semibold text-slate-800 border-b border-slate-50 pb-2">
                                    <?= htmlspecialchars($user['agency']); ?>
                                </p>
                            </div>

                            <div class="space-y-1">
                                <p class="text-xs font-bold text-slate-400 uppercase tracking-widest flex items-center gap-2">
                                    <i class="fas fa-envelope text-amber-500"></i> อีเมลติดต่อ
                                </p>
                                <p class="text-lg font-semibold text-slate-800 border-b border-slate-50 pb-2">
                                    <?= htmlspecialchars($user['email']); ?>
                                </p>
                            </div>

                            <div class="space-y-1">
                                <p class="text-xs font-bold text-slate-400 uppercase tracking-widest flex items-center gap-2">
                                    <i class="fas fa-phone text-rose-500"></i> เบอร์โทรศัพท์
                                </p>
                                <p class="text-lg font-semibold text-slate-800 border-b border-slate-50 pb-2">
                                    <?= htmlspecialchars($user['phone']); ?>
                                </p>
                            </div>
                        </div>

                        <div class="mt-12 flex justify-center">
                            <a href="edit_profile_form.php" class="px-8 py-3 bg-blue-600 text-white rounded-2xl hover:bg-blue-700 shadow-lg shadow-blue-200 transition font-bold flex items-center gap-2">
                                <i class="fas fa-user-edit"></i> แก้ไขข้อมูลส่วนตัว
                            </a>
                        </div>
                        <?php else: ?>
                            <div class="py-10 text-center text-rose-500 italic">
                                <i class="fas fa-exclamation-triangle text-3xl mb-2"></i>
                                <p>ไม่พบข้อมูลผู้ใช้ในระบบ</p>
                            </div>
                        <?php endif; ?>
                    </div>

                    <div class="tab-content hidden animate-in fade-in duration-300" id="password">
                        <div class="max-w-md mx-auto">
                            <div class="bg-amber-50 border-l-4 border-amber-400 p-4 mb-8 rounded-r-xl">
                                <p class="text-amber-700 text-sm">
                                    <i class="fas fa-info-circle mr-1"></i> เพื่อความปลอดภัย รหัสผ่านควรมีความยาวอย่างน้อย 8 ตัวอักษร
                                </p>
                            </div>
                            <form action="reset_password_user.php" method="POST" class="space-y-5">
                                <div>
                                    <label class="block text-slate-600 font-semibold mb-2">รหัสผ่านใหม่</label>
                                    <div class="relative">
                                        <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-slate-400">
                                            <i class="fas fa-lock"></i>
                                        </span>
                                        <input type="password" name="new_password" required placeholder="••••••••"
                                            class="w-full pl-11 pr-4 py-3 border border-slate-200 rounded-xl focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none transition shadow-sm">
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-slate-600 font-semibold mb-2">ยืนยันรหัสผ่านใหม่</label>
                                    <div class="relative">
                                        <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-slate-400">
                                            <i class="fas fa-check-circle"></i>
                                        </span>
                                        <input type="password" name="confirm_password" required placeholder="••••••••"
                                            class="w-full pl-11 pr-4 py-3 border border-slate-200 rounded-xl focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none transition shadow-sm">
                                    </div>
                                </div>
                                <div class="pt-4">
                                    <button type="submit" class="w-full py-4 bg-rose-500 text-white rounded-2xl hover:bg-rose-600 shadow-lg shadow-rose-200 transition font-bold flex items-center justify-center gap-2">
                                        <i class="fas fa-key"></i> ยืนยันการเปลี่ยนรหัสผ่าน
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <footer class="bg-slate-900 text-slate-500 py-10 mt-10">
        <div class="container mx-auto px-4 text-center">
            <p class="text-sm">© <?= date("Y") ?> ระบบจัดทำแบบเสนอรายละเอียดคำชี้แจงรายการครุภัณฑ์ (ง4)</p>
            <p class="text-[10px] mt-2 uppercase tracking-widest opacity-50">Rajamangala University of Technology Isan</p>
        </div>
    </footer>

    <script>
        const tabButtons = document.querySelectorAll(".tab-button");
        const tabContents = document.querySelectorAll(".tab-content");

        tabButtons.forEach(btn => {
            btn.addEventListener("click", () => {
                // Remove active classes from all buttons
                tabButtons.forEach(b => {
                    b.classList.remove("text-blue-600", "bg-white", "shadow-sm");
                    b.classList.add("text-slate-500");
                });

                // Add active classes to clicked button
                btn.classList.add("text-blue-600", "bg-white", "shadow-sm");
                btn.classList.remove("text-slate-500");

                // Show/Hide Content
                const target = btn.getAttribute("data-tab");
                tabContents.forEach(tc => tc.classList.add("hidden"));
                document.getElementById(target).classList.remove("hidden");
            });
        });
    </script>

</body>
</html>
<?php
$stmt->close();
$conn->close();
?>