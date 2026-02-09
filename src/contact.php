<?php
session_start();

// ถ้ายังไม่ได้ล็อกอิน ห้ามเข้าหน้า
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ติดต่อเรา - Admin System</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Sarabun:wght@300;400;600;700&display=swap');
        body { font-family: 'Sarabun', sans-serif; }
    </style>
</head>
<body class="bg-slate-50 text-slate-800 antialiased min-h-screen flex flex-col">

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
                <a href="profile.php" class="px-4 py-2 text-slate-600 hover:bg-slate-100 rounded-xl transition">ข้อมูลส่วนตัว</a>
                <a href="contact.php" class="px-4 py-2 text-blue-600 bg-blue-50 rounded-xl transition">ติดต่อ</a>
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
                <h1 class="text-2xl font-bold">CONTACT US</h1>
            </div>
            </div>
        </div>

    <main class="container mx-auto px-4 py-12 flex-grow">
        
        <div class="text-center mb-12">

            <p class="text-slate-500 mt-2 italic font-light">หากคุณมีข้อสงสัยหรือต้องการความช่วยเหลือ สามารถติดต่อเราได้ตามช่องทางด้านล่าง</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 max-w-5xl mx-auto">
            
            <div class="group bg-white shadow-xl shadow-slate-200/50 rounded-[2rem] p-8 border border-slate-100 transition-all hover:scale-[1.02]">
                <div class="bg-blue-50 w-16 h-16 rounded-2xl flex items-center justify-center mb-6 transition-colors group-hover:bg-blue-600">
                    <i class="fas fa-user-shield text-2xl text-blue-600 group-hover:text-white"></i>
                </div>
                <h3 class="text-xl font-bold text-slate-800 mb-6">ติดต่อผู้ดูแลระบบ (Admin)</h3>
                
                <div class="space-y-6">
                    <div class="flex items-center space-x-4">
                        <div class="bg-slate-50 text-blue-600 p-3 rounded-xl"><i class="fas fa-envelope"></i></div>
                        <div>
                            <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">อีเมล</p>
                            <p class="text-lg font-medium text-slate-800">somkid.de@rmuti.ac.th</p>
                        </div>
                    </div>

                    <div class="flex items-center space-x-4">
                        <div class="bg-slate-50 text-emerald-600 p-3 rounded-xl"><i class="fas fa-phone-alt"></i></div>
                        <div>
                            <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">เบอร์โทรศัพท์</p>
                            <p class="text-lg font-medium text-slate-800">0902765514</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="group bg-white shadow-xl shadow-slate-200/50 rounded-[2rem] p-8 border border-slate-100 transition-all hover:scale-[1.02]">
                <div class="bg-emerald-50 w-16 h-16 rounded-2xl flex items-center justify-center mb-6 transition-colors group-hover:bg-emerald-600">
                    <i class="fas fa-university text-2xl text-emerald-600 group-hover:text-white"></i>
                </div>
                <h3 class="text-xl font-bold text-slate-800 mb-6">ติดต่อหน่วยงานที่เกี่ยวข้อง</h3>
                
                <div class="space-y-6">
                    <div class="flex items-center space-x-4">
                        <div class="bg-slate-50 text-blue-600 p-3 rounded-xl"><i class="fas fa-at"></i></div>
                        <div>
                            <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">อีเมลหน่วยงาน</p>
                            <p class="text-lg font-medium text-slate-800">info@university.ac.th</p>
                        </div>
                    </div>

                    <div class="flex items-center space-x-4">
                        <div class="bg-slate-50 text-emerald-600 p-3 rounded-xl"><i class="fas fa-phone-square-alt"></i></div>
                        <div>
                            <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">เบอร์โทรภายใน</p>
                            <p class="text-lg font-medium text-slate-800">044-123-456</p>
                        </div>
                    </div>

                    <div class="flex items-start space-x-4">
                        <div class="bg-slate-50 text-rose-600 p-3 rounded-xl mt-1"><i class="fas fa-map-marker-alt"></i></div>
                        <div>
                            <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">ที่ตั้งหน่วยงาน</p>
                            <p class="text-sm font-medium text-slate-800 leading-relaxed">
                                มหาวิทยาลัยเทคโนโลยีราชมงคลอีสาน<br>
                                744 ถ.สุรนารายณ์ ต.ในเมือง อ.เมือง จ.นครราชสีมา 30000
                            </p>
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

</body>
</html>