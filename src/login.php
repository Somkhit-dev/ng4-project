<?php session_start(); ?>
<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>เข้าสู่ระบบ - Admin System</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Sarabun:wght@300;400;600;700&display=swap');

        body {
            font-family: 'Sarabun', sans-serif;
        }

        .glass {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
    </style>
</head>

<body class="bg-slate-100 min-h-screen flex items-center justify-center px-4 py-10">

    <div class="w-full max-w-md glass rounded-[2.5rem] shadow-2xl shadow-blue-200/50 overflow-hidden border border-white">
        <div class="bg-blue-900 p-8 text-center text-white relative">
            <img src="https://sci.rmuti.ac.th/main/wp-content/uploads/2022/02/RMUTI_KORAT.png" class="w-20 mx-auto mb-4 drop-shadow-lg" alt="Logo">
            <h2 class="text-2xl font-extrabold uppercase tracking-wider">Sign In</h2>
            <p class="text-blue-200 text-sm mt-1 font-light italic">ระบบจัดทำแบบเสนอรายละเอียดคำชี้แจงรายการครุภัณฑ์ มทร.อีสาน</p>
            <div class="absolute -top-10 -right-10 w-32 h-32 bg-white/10 rounded-full"></div>
        </div>

        <div class="p-8 md:p-10">
            <?php if (isset($_SESSION['error'])): ?>
                <div class="bg-red-50 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded-r-xl text-sm flex items-center gap-3">
                    <i class="fas fa-exclamation-circle text-lg"></i>
                    <span><?= htmlspecialchars($_SESSION['error']);
                            unset($_SESSION['error']); ?></span>
                </div>
            <?php endif; ?>

            <?php if (isset($_SESSION['success'])): ?>
                <div class="bg-green-50 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded-r-xl text-sm flex items-center gap-3">
                    <i class="fas fa-check-circle text-lg"></i>
                    <span><?= htmlspecialchars($_SESSION['success']);
                            unset($_SESSION['success']); ?></span>
                </div>
            <?php endif; ?>

            <form action="login_db.php" method="post" class="space-y-6">
                <div class="space-y-2">
                    <label class="text-sm font-bold text-slate-600 ml-1">อีเมลผู้ใช้งาน</label>
                    <div class="relative group">
                        <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-slate-400 group-focus-within:text-blue-600 transition-colors">
                            <i class="fa-solid fa-envelope"></i>
                        </span>
                        <input type="email" name="email" placeholder="example@domain.com" required
                            class="w-full pl-11 pr-4 py-3.5 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none transition shadow-sm" />
                    </div>
                </div>

                <div class="space-y-2">
                    <label class="text-sm font-bold text-slate-600 ml-1">รหัสผ่าน</label>
                    <div class="relative group">
                        <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-slate-400 group-focus-within:text-blue-600 transition-colors">
                            <i class="fa-solid fa-lock"></i>
                        </span>
                        <input type="password" name="password" id="password" placeholder="••••••••" required
                            class="w-full pl-11 pr-24 py-3.5 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none transition shadow-sm" />
                        <button type="button" id="togglePassword"
                            class="absolute right-3 top-1/2 -translate-y-1/2 px-3 py-1 text-xs font-bold text-blue-600 hover:bg-blue-50 rounded-lg transition">
                            แสดง
                        </button>
                    </div>
                </div>

                <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-4 rounded-2xl shadow-lg shadow-blue-200 transition-all transform hover:-translate-y-0.5 active:scale-95 flex items-center justify-center gap-2">
                    <i class="fas fa-sign-in-alt"></i> เข้าสู่ระบบ
                </button>
            </form>

            <div class="mt-10 pt-6 border-t border-slate-100 text-center space-y-4">
                <p class="text-slate-500 text-sm">
                    ยังไม่เป็นสมาชิก?
                    <a href="register.php" class="text-blue-600 font-bold hover:underline underline-offset-4">สร้างบัญชีใหม่</a>
                </p>
                <a href="index.php" class="inline-flex items-center gap-2 text-slate-400 hover:text-slate-600 text-sm transition font-medium">
                    <i class="fas fa-arrow-left text-xs"></i> กลับไปหน้าแรก
                </a>
            </div>
        </div>
    </div>

    <div class="fixed bottom-6 w-full text-center text-slate-400 text-xs hidden md:block">
        &copy; <?= date("Y"); ?> Rajamangala University of Technology Isan.
    </div>

    <div class="fixed bottom-6 right-6 z-50">
        <button onclick="toggleContactModal()" class="w-14 h-14 bg-blue-900 text-white rounded-full shadow-2xl flex items-center justify-center hover:scale-110 transition-transform active:scale-95 group relative">
            <i class="fa-solid fa-headset text-xl"></i>
            <span class="absolute top-0 right-0 flex h-3 w-3">
                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span>
                <span class="relative inline-flex rounded-full h-3 w-3 bg-red-500"></span>
            </span>
        </button>
    </div>

    <div id="contactModal" class="fixed inset-0 z-[60] hidden flex items-center justify-center px-4">
        <div onclick="toggleContactModal()" class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm"></div>

        <div class="bg-white w-full max-w-sm rounded-[2rem] shadow-2xl relative z-10 overflow-hidden transform transition-all scale-100">
            <div class="bg-blue-900 p-6 text-center text-white">
                <div class="w-16 h-16 bg-white/10 rounded-full flex items-center justify-center mx-auto mb-3">
                    <i class="fa-solid fa-comments text-2xl"></i>
                </div>
                <h3 class="text-xl font-bold">ศูนย์ช่วยเหลือ</h3>
                <p class="text-blue-200 text-sm font-light">พบปัญหาการใช้งาน ติดต่อเจ้าหน้าที่ได้ทันที</p>
            </div>

            <div class="p-6 space-y-3">
                <a  class="flex items-center gap-4 p-4 rounded-2xl bg-slate-50 hover:bg-blue-50 border border-slate-100 transition-colors group">
                    <div class="w-10 h-10 bg-blue-100 text-blue-600 rounded-xl flex items-center justify-center group-hover:bg-blue-600 group-hover:text-white transition-all">
                        <i class="fa-solid fa-phone"></i>
                    </div>
                    <div>
                        <p class="text-[10px] text-slate-400 font-bold uppercase">เบอร์โทรศัพท์</p>
                        <p class="text-sm font-bold text-slate-700">0900000000</p>
                    </div>
                </a>

                <a  class="flex items-center gap-4 p-4 rounded-2xl bg-slate-50 hover:bg-green-50 border border-slate-100 transition-colors group">
                    <div class="w-10 h-10 bg-green-100 text-green-600 rounded-xl flex items-center justify-center group-hover:bg-[#06C755] group-hover:text-white transition-all">
                        <i class="fa-brands fa-line text-lg"></i>
                    </div>
                    <div>
                        <p class="text-[10px] text-slate-400 font-bold uppercase">Line</p>
                        <p class="text-sm font-bold text-slate-700">@rmuti_support</p>
                    </div>
                </a>

                <a class="flex items-center gap-4 p-4 rounded-2xl bg-slate-50 hover:bg-orange-50 border border-slate-100 transition-colors group">
                    <div class="w-10 h-10 bg-orange-100 text-orange-600 rounded-xl flex items-center justify-center group-hover:bg-orange-500 group-hover:text-white transition-all">
                        <i class="fa-solid fa-envelope"></i>
                    </div>
                    <div>
                        <p class="text-[10px] text-slate-400 font-bold uppercase">Email</p>
                        <p class="text-sm font-bold text-slate-700">support@rmuti.ac.th</p>
                    </div>
                </a>

                <button onclick="toggleContactModal()" class="w-full mt-2 py-3 text-slate-400 text-sm font-semibold hover:text-slate-600 transition-colors">
                    ปิดหน้าต่างนี้
                </button>
            </div>
        </div>
    </div>
    <script>
        const toggle = document.getElementById('togglePassword');
        toggle.addEventListener('click', function() {
            const field = document.getElementById('password');
            const isPass = field.type === 'password';
            field.type = isPass ? 'text' : 'password';
            this.textContent = isPass ? 'ซ่อน' : 'แสดง';
        });

        function toggleContactModal() {
            const modal = document.getElementById('contactModal');
            if (modal.classList.contains('hidden')) {
                modal.classList.remove('hidden');
                // เพิ่ม Animation เล็กน้อย
                modal.querySelector('.bg-white').classList.add('animate-bounce-in');
            } else {
                modal.classList.add('hidden');
            }
        }
    </script>
</body>

</html>