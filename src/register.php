<?php session_start(); ?>
<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>สมัครสมาชิก - Admin System</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Sarabun:wght@300;400;600;700&display=swap');

        body {
            font-family: 'Sarabun', sans-serif;
        }
    </style>
</head>

<body class="bg-slate-100 min-h-screen flex items-center justify-center px-4 py-12">

    <div class="w-full max-w-xl bg-white rounded-[2.5rem] shadow-2xl shadow-blue-200/50 overflow-hidden border border-white">
        <div class="bg-blue-900 p-8 text-center text-white relative">
            <img src="https://sci.rmuti.ac.th/main/wp-content/uploads/2022/02/RMUTI_KORAT.png" class="w-16 mx-auto mb-4 drop-shadow-lg" alt="Logo">
            <h2 class="text-2xl font-extrabold uppercase tracking-wider">Create Account</h2>
            <p class="text-blue-200 text-sm mt-1 font-light italic">ระบบจัดทำแบบเสนอรายละเอียดคำชี้แจงรายการครุภัณฑ์ มทร.อีสาน</p>
        </div>

        <div class="p-8 md:p-10">
            <?php if (isset($_SESSION['error'])): ?>
                <div class="bg-red-50 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded-r-xl text-sm flex items-center gap-3">
                    <i class="fas fa-exclamation-circle text-lg"></i>
                    <span><?= htmlspecialchars($_SESSION['error']);
                            unset($_SESSION['error']); ?></span>
                </div>
            <?php endif; ?>

            <form action="register_db.php" method="post" class="space-y-5">

                <div class="space-y-1">
                    <label class="text-xs font-bold text-slate-500 ml-1 uppercase">คำนำหน้าชื่อ</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-slate-400 pointer-events-none">
                            <i class="fa-solid fa-user-tag"></i>
                        </span>
                        <select name="prename" id="prename" class="w-full pl-11 pr-10 py-3 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none transition appearance-none" onchange="toggleOtherPrename()">
                            <option value="นาย">นาย</option>
                            <option value="นาง">นาง</option>
                            <option value="นางสาว">นางสาว</option>
                            <option value="อื่น ๆ">อื่น ๆ</option>
                        </select>
                        <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none text-slate-400">
                            <i class="fa-solid fa-chevron-down text-xs"></i>
                        </div>
                    </div>
                </div>

                <div id="otherPrenameDiv" class="space-y-1 hidden">
                    <label class="text-xs font-bold text-slate-500 ml-1 uppercase">ระบุคำนำหน้าชื่อ</label>
                    <input type="text" name="other_prename" id="other_prename" placeholder="กรอกคำนำหน้าชื่อ"
                        class="w-full px-5 py-3 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none transition shadow-sm" />
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="space-y-1">
                        <label class="text-xs font-bold text-slate-500 ml-1 uppercase">ชื่อ</label>
                        <input type="text" name="firstname" required value="<?= $_SESSION['old_input']['firstname'] ?? '' ?>"
                            placeholder="ชื่อของคุณ"
                            class="w-full px-5 py-3 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none transition shadow-sm" />
                    </div>
                    <div class="space-y-1">
                        <label class="text-xs font-bold text-slate-500 ml-1 uppercase">นามสกุล</label>
                        <input type="text" name="lastname" required value="<?= $_SESSION['old_input']['lastname'] ?? '' ?>"
                            placeholder="นามสกุลของคุณ"
                            class="w-full px-5 py-3 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none transition shadow-sm" />
                    </div>
                </div>

                <div class="space-y-1">
                    <label class="text-xs font-bold text-slate-500 ml-1 uppercase">หน่วยงาน / สังกัด</label>
                    <div class="relative group">
                        <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-slate-400 group-focus-within:text-blue-600 transition-colors">
                            <i class="fa-solid fa-building"></i>
                        </span>
                        <input type="text" name="agency" required value="<?= $_SESSION['old_input']['agency'] ?? '' ?>"
                            placeholder="เช่น คณะวิทยาศาสตร์และศิลปศาสตร์"
                            class="w-full pl-11 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none transition shadow-sm" />
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="space-y-1">
                        <label class="text-xs font-bold text-slate-500 ml-1 uppercase">อีเมล</label>
                        <div class="relative group">
                            <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-slate-400 group-focus-within:text-blue-600 transition-colors">
                                <i class="fa-solid fa-envelope text-xs"></i>
                            </span>
                            <input type="email" name="email" required value="<?= $_SESSION['old_input']['email'] ?? '' ?>"
                                placeholder="name@example.com"
                                class="w-full pl-10 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none transition shadow-sm text-sm" />
                        </div>
                    </div>
                    <div class="space-y-1">
                        <label class="text-xs font-bold text-slate-500 ml-1 uppercase">เบอร์โทรศัพท์</label>
                        <div class="relative group">
                            <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-slate-400 group-focus-within:text-blue-600 transition-colors">
                                <i class="fa-solid fa-phone text-xs"></i>
                            </span>
                            <input type="text" name="phone" required value="<?= $_SESSION['old_input']['phone'] ?? '' ?>"
                                placeholder="08X-XXX-XXXX"
                                class="w-full pl-10 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none transition shadow-sm text-sm" />
                        </div>
                    </div>
                </div>

                <div class="space-y-1">
                    <label class="text-xs font-bold text-slate-500 ml-1 uppercase">รหัสผ่าน</label>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="relative group">
                        <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-slate-400 group-focus-within:text-blue-600 transition-colors">
                            <i class="fa-solid fa-lock text-xs"></i>
                        </span>
                        <input type="password" name="password" id="password" required placeholder="รหัสผ่าน (ขั้นต่ำ 8 ตัว)"
                            minlength="8"
                            class="w-full pl-10 pr-12 py-3 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none transition shadow-sm text-sm" />
                        <button type="button" onclick="togglePass('password', this)" class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-blue-600 p-2">
                            <i class="fa-solid fa-eye text-xs"></i>
                        </button>
                    </div>
                    <div class="relative group">
                        <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-slate-400 group-focus-within:text-blue-600 transition-colors">
                            <i class="fa-solid fa-lock text-xs"></i>
                        </span>
                        <input type="password" name="c_password" id="c_password" required placeholder="ยืนยันรหัสผ่าน"
                            minlength="8"
                            class="w-full pl-10 pr-12 py-3 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none transition shadow-sm text-sm" />
                        <button type="button" onclick="togglePass('c_password', this)" class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-blue-600 p-2">
                            <i class="fa-solid fa-eye text-xs"></i>
                        </button>
                    </div>
                </div>

                <div class="pt-4">
                    <button type="submit" name="register"
                        class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-4 rounded-2xl shadow-lg shadow-blue-200 transition-all active:scale-[0.98] flex items-center justify-center gap-2">
                        <i class="fas fa-user-plus"></i> ลงทะเบียนสมาชิก
                    </button>
                </div>
            </form>

            <div class="mt-8 text-center space-y-3">
                <p class="text-slate-500 text-sm">
                    มีบัญชีอยู่แล้ว? <a href="login.php" class="text-blue-600 font-bold hover:underline">เข้าสู่ระบบที่นี่</a>
                </p>
                <a href="index.php" class="inline-block text-slate-400 hover:text-slate-600 text-xs transition">
                    <i class="fas fa-arrow-left"></i> กลับสู่หน้าหลัก
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
        function togglePass(id, btn) {
            const field = document.getElementById(id);
            const icon = btn.querySelector('i');
            if (field.type === 'password') {
                field.type = 'text';
                icon.classList.replace('fa-eye', 'fa-eye-slash');
            } else {
                field.type = 'password';
                icon.classList.replace('fa-eye-slash', 'fa-eye');
            }
        }

        function toggleOtherPrename() {
            const select = document.getElementById('prename');
            const otherDiv = document.getElementById('otherPrenameDiv');
            const otherInput = document.getElementById('other_prename');

            if (select.value === 'อื่น ๆ') {
                otherDiv.classList.remove('hidden');
                otherInput.required = true;
            } else {
                otherDiv.classList.add('hidden');
                otherInput.required = false;
                otherInput.value = '';
            }
        }

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