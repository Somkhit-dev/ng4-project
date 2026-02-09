<?php
session_start();
require 'config.php';
?>
<!DOCTYPE html>
<html lang="th" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ระบบจัดทำแบบเสนอ ง4 - RMUTI</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Sarabun:wght@300;400;600;700&family=Inter:wght@700;800;900&display=swap');
        
        body { font-family: 'Sarabun', sans-serif; background-color: #f1f5f9; }
        .font-heading { font-family: 'Inter', 'Sarabun', sans-serif; }

        /* ปรับ Navbar ให้ดูโปร่งแต่เห็นชัด */
        .glass-nav {
            background: rgba(15, 23, 42, 0.9);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        /* ปรับพื้นหลัง Hero ให้ดูมีมิติด้วยการไล่สีเข้ม */
        .hero-bg {
            background: radial-gradient(circle at top right, #1e293b, #0f172a);
        }

        /* การ์ดข่าวแบบมีมิติ */
        .news-card {
            background: white;
            transition: all 0.3s ease;
            border: 1px solid rgba(226, 232, 240, 0.8);
        }
        .news-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
            border-color: #3b82f6;
        }
    </style>
</head>
<body class="text-slate-900 leading-relaxed">

    <nav class="fixed top-0 left-0 w-full glass-nav z-[100] transition-all duration-300">
        <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">
            <div class="flex items-center gap-3">
                <img src="https://sci.rmuti.ac.th/main/wp-content/uploads/2022/02/RMUTI_KORAT.png" class="w-10 h-10 object-contain brightness-0 invert" alt="Logo">
                <h1 class="text-xl font-black text-white tracking-tighter uppercase font-heading">RMUTI</h1>
            </div>
            
            <div class="flex items-center gap-4">
                <?php if(isset($_SESSION['user_id'])): ?>
                    <a href="user_dashboard.php" class="text-slate-300 hover:text-white transition text-sm font-bold hidden md:block">แดชบอร์ด</a>
                    <a href="logout.php" class="flex items-center gap-2 px-5 py-2 bg-red-500 text-white rounded-xl text-sm font-black hover:bg-red-600 transition-all shadow-lg shadow-red-500/20">
                        <i class="fas fa-sign-out-alt"></i> <span>ออกจากระบบ</span>
                    </a>
                <?php else: ?>
                    <a href="login.php" class="text-slate-300 hover:text-white transition font-bold text-sm px-4">เข้าสู่ระบบ</a>
                    <a href="register.php" class="bg-blue-600 hover:bg-blue-500 text-white px-6 py-2 rounded-xl text-sm font-bold transition-all shadow-lg shadow-blue-600/30">
                        สมัครสมาชิก
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </nav>

    <header class="relative pt-56 pb-32 hero-bg overflow-hidden text-white border-b border-blue-900/30">
        <div class="absolute top-0 right-0 -mr-24 -mt-24 w-96 h-96 bg-blue-500/20 rounded-full blur-[100px]"></div>
        <div class="absolute bottom-0 left-0 -ml-24 -mb-24 w-80 h-80 bg-indigo-500/20 rounded-full blur-[100px]"></div>

        <div class="max-w-7xl mx-auto px-6 relative z-10 text-center">
            <div class="inline-flex items-center gap-2 bg-blue-500/10 border border-blue-400/20 px-4 py-2 rounded-2xl mb-8">
                <span class="w-2 h-2 bg-blue-400 rounded-full animate-pulse"></span>
                <span class="text-[10px] font-black uppercase tracking-widest text-blue-300">Document Management</span>
            </div>
            
            <h1 class="text-5xl md:text-8xl font-black mb-8 tracking-tighter leading-tight font-heading">
                ระบบจัดการแบบเสนอ<br>
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-indigo-300 font-black">รายละเอียดคำชี้แจงรายการครุภัณฑ์</span>
            </h1>
            <p class="text-lg md:text-xl text-slate-400 max-w-2xl mx-auto mb-12 font-light leading-relaxed">
                 <br class="hidden md:block">
                สะดวก รวดเร็ว แม่นยำ
            </p>

            <div class="flex flex-wrap justify-center gap-4">
                <a href="login.php" class="px-10 py-5 bg-blue-600 text-white rounded-2xl font-bold shadow-2xl shadow-blue-600/40 hover:bg-blue-500 hover:-translate-y-1 transition-all flex items-center gap-3 group">
                    เริ่มใช้งานระบบ <i class="fas fa-arrow-right group-hover:translate-x-1 transition-transform"></i>
                </a>
                <a href="#news" class="px-10 py-5 bg-slate-800 border border-slate-700 text-white rounded-2xl font-bold hover:bg-slate-700 transition-all flex items-center gap-2">
                    <i class="far fa-newspaper"></i> ข่าวสารล่าสุด
                </a>
            </div>
        </div>
    </header>

    <section id="news" class="py-24">
        <div class="max-w-7xl mx-auto px-6">
            <div class="flex flex-col md:flex-row justify-between items-end mb-16 gap-4">
                <div class="text-left border-l-4 border-blue-600 pl-6">
                    <h2 class="text-3xl md:text-5xl font-black text-slate-900 mb-2 tracking-tighter font-heading uppercase">ประกาศ</h2>
                    <p class="text-slate-500 font-medium">ประกาศสำคัญและความเคลื่อนไหวของระบบ</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <?php
                $sql = "SELECT * FROM news_announcements WHERE status = 'active' ORDER BY is_pinned DESC, created_at DESC LIMIT 4";
                $result = mysqli_query($conn, $sql);

                if (mysqli_num_rows($result) > 0):
                    while($row = mysqli_fetch_assoc($result)):
                        $is_urgent = ($row['category'] == 'urgent');
                ?>
                    <div class="news-card group p-8 rounded-[2rem] relative overflow-hidden">
                        <?php if($row['is_pinned']): ?>
                            <div class="absolute top-0 right-0 bg-orange-500 text-white px-4 py-2 rounded-bl-2xl shadow-md">
                                <i class="fas fa-thumbtack"></i>
                            </div>
                        <?php endif; ?>

                        <div class="flex items-center gap-4 mb-6">
                            <div class="px-3 py-1 rounded-lg text-[10px] font-black uppercase tracking-widest <?= $is_urgent ? 'bg-red-500 text-white' : 'bg-blue-600 text-white' ?>">
                                <?= $is_urgent ? 'Urgent' : 'General' ?>
                            </div>
                            <span class="text-[10px] font-bold text-slate-400 uppercase flex items-center gap-1">
                                <i class="far fa-calendar-alt"></i> <?= date('d M Y', strtotime($row['created_at'])) ?>
                            </span>
                        </div>

                        <h3 class="text-xl font-bold text-slate-900 mb-4 leading-tight group-hover:text-blue-600 transition-colors">
                            <?= htmlspecialchars($row['title']); ?>
                        </h3>
                        <p class="text-slate-600 text-sm font-light line-clamp-2 mb-8 leading-relaxed">
                            <?= htmlspecialchars($row['content']); ?>
                        </p>

                        <div class="flex justify-between items-center pt-6 border-t border-slate-50">
                            <?php if($row['file_path']): ?>
                                <a href="uploads/<?= $row['file_path']; ?>" class="flex items-center gap-2 text-xs font-black text-blue-600 hover:text-blue-700 transition-colors bg-blue-50 px-4 py-2 rounded-xl">
                                    <i class="fas fa-download"></i> ดาวน์โหลดเอกสาร
                                </a>
                            <?php else: ?>
                                <div class="text-slate-300 text-xs font-medium">ไม่มีไฟล์แนบ</div>
                            <?php endif; ?>
                            <div class="w-8 h-8 rounded-full bg-slate-50 flex items-center justify-center text-slate-300 group-hover:bg-blue-600 group-hover:text-white transition-all">
                                <i class="fas fa-arrow-right text-[10px]"></i>
                            </div>
                        </div>
                    </div>
                <?php endwhile; else: ?>
                    <div class="col-span-full py-20 text-center bg-white border border-slate-200 rounded-[3rem] text-slate-400">
                        <i class="far fa-folder-open text-4xl mb-4 block"></i>
                        ยังไม่มีประกาศในขณะนี้
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <footer class="bg-slate-900 text-white py-16 border-t border-white/5">
        <div class="max-w-7xl mx-auto px-6 grid md:grid-cols-3 gap-12 items-center">
            <div class="flex items-center gap-4">
                <img src="https://sci.rmuti.ac.th/main/wp-content/uploads/2022/02/RMUTI_KORAT.png" class="w-12 h-12 brightness-0 invert" alt="Logo">
                <div class="text-left leading-none">
                    <p class="text-lg font-black uppercase tracking-tighter">RMUTI</p>
                    <p class="text-[10px] text-slate-500 mt-1 uppercase font-bold">Document Management</p>
                </div>
            </div>
            
            <div class="text-center text-slate-500 text-xs font-medium uppercase tracking-[0.1em]">
                &copy; <?= date("Y") ?> Rajamangala University of Technology Isan.
            </div>

            <div class="flex justify-center md:justify-end gap-3">
                <a href="#" class="w-10 h-10 bg-white/5 rounded-xl flex items-center justify-center hover:bg-blue-600 hover:text-white transition-all border border-white/10"><i class="fab fa-facebook-f text-sm"></i></a>
                <a href="#" class="w-10 h-10 bg-white/5 rounded-xl flex items-center justify-center hover:bg-blue-600 hover:text-white transition-all border border-white/10"><i class="fas fa-envelope text-sm"></i></a>
            </div>
        </div>
    </footer>

    <script>

        window.addEventListener('scroll', function() {
            const nav = document.querySelector('nav');
            if (window.scrollY > 20) {
                nav.style.padding = "12px 0";
                nav.style.background = "rgba(15, 23, 42, 0.95)";
            } else {
                nav.style.padding = "16px 0";
                nav.style.background = "rgba(15, 23, 42, 0.9)";
            }
        });
    </script>
</body>
</html>