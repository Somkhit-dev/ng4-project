<?php
session_start();

// 1. บันทึกข้อมูลจากหน้า 1 ลง Session เมื่อมีการ Submit มา
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $_SESSION['form1'] = $_POST;
}

// 2. ฟังก์ชันช่วยดึงค่าจาก Session (สำหรับกรณีที่กดไปหน้า 3 แล้วย้อนกลับมาหน้า 2)
function getForm2Value($fieldName) {
    return isset($_SESSION['form2'][$fieldName]) ? htmlspecialchars($_SESSION['form2'][$fieldName]) : '';
}
?>

<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ฟอร์มหน้าที่ 2 - รายละเอียดโครงการ</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Sarabun:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Sarabun', sans-serif; }
        .form-input-focus {
            transition: all 0.3s ease;
        }
        .form-input-focus:focus {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(16, 185, 129, 0.15);
        }
    </style>
</head>

<body class="bg-slate-50 flex justify-center items-center min-h-screen p-4">
    <div class="bg-white p-8 rounded-2xl shadow-xl w-full max-w-4xl border border-gray-100">
        
        <div class="mb-10 text-center">
            <h1 class="text-3xl font-bold text-gray-800 mb-2">แบบฟอร์มจัดหาระบบคอมพิวเตอร์</h1>
            <p class="text-gray-500">กรุณากรอกข้อมูลโครงการให้ครบถ้วน</p>
        </div>

        <form method="POST" action="form3.php" class="space-y-8">

            <section class="space-y-4">
                <div class="flex items-center gap-2 pb-2 border-b border-blue-100">
                    <div class="w-2 h-8 bg-blue-500 rounded-full"></div>
                    <h2 class="text-xl font-bold text-gray-800">4. หลักการและเหตุผล <span class="text-red-500">*</span></h2>
                </div>
                <div class="px-2">
                    <textarea id="project_rationale" name="project_rationale" required 
                        placeholder="ระบุความเป็นมาและความจำเป็นในการจัดหา..."
                        class="form-input-focus mt-1 block w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-400 bg-gray-50/50" 
                        rows="4"><?= getForm2Value('project_rationale') ?></textarea>
                </div>
            </section>

            <section class="space-y-4">
                <div class="flex items-center gap-2 pb-2 border-b border-blue-100">
                    <div class="w-2 h-8 bg-blue-500 rounded-full"></div>
                    <h2 class="text-xl font-bold text-gray-800">5. วัตถุประสงค์ <span class="text-red-500">*</span></h2>
                </div>
                <div class="px-2">
                    <textarea id="project_objectives" name="project_objectives" required 
                        placeholder="โครงการนี้ทำเพื่ออะไร..."
                        class="form-input-focus mt-1 block w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-400 bg-gray-50/50" 
                        rows="4"><?= getForm2Value('project_objectives') ?></textarea>
                </div>
            </section>

            <section class="space-y-4">
                <div class="flex items-center gap-2 pb-2 border-b border-blue-100">
                    <div class="w-2 h-8 bg-blue-500 rounded-full"></div>
                    <h2 class="text-xl font-bold text-gray-800">6. เป้าหมาย <span class="text-red-500">*</span></h2>
                </div>

                <div class="grid grid-cols-1 gap-6 px-2">
                    <div class="bg-blue-50/50 p-6 rounded-2xl border border-blue-100">
                        <label for="goal_quantitative" class="block text-sm font-bold text-blue-800 mb-2 uppercase tracking-wider">
                            6.1 เป้าหมายเชิงปริมาณ (กรุณาระบุเป็นข้อๆ เช่น 1. ตัวอย่าง)
                        </label>
                        <textarea id="goal_quantitative" name="goal_quantitative" required
                            placeholder="1. จัดหาเครื่องคอมพิวเตอร์จำนวน 10 เครื่อง&#10;2. ติดตั้งระบบเครือข่าย 1 ระบบ"
                            class="form-input-focus mt-1 block w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-400 bg-white"
                            rows="6"><?= getForm2Value('goal_quantitative') ?></textarea>
                    </div>

                    <div>
                        <label for="goal_qualitative" class="block text-sm font-semibold text-gray-700 mb-2">
                            6.2 เป้าหมายเชิงคุณภาพ <span class="text-red-500">*</span>
                        </label>
                        <textarea id="goal_qualitative" name="goal_qualitative" required 
                            placeholder="ผลสัมฤทธิ์ที่คาดหวังในเชิงคุณภาพ..."
                            class="form-input-focus mt-1 block w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-400 bg-gray-50/50" 
                            rows="4"><?= getForm2Value('goal_qualitative') ?></textarea>
                    </div>
                </div>
            </section>

            <div class="flex justify-between items-center pt-8 border-t border-gray-100">
                <a href="form1.php" class="text-gray-500 hover:text-gray-700 font-bold flex items-center gap-2 transition-colors">
                    ← ย้อนกลับ
                </a>
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-10 py-3 rounded-xl font-bold shadow-lg shadow-blue-200 transition-all hover:-translate-y-1 active:scale-95">
                    ขั้นตอนถัดไป →
                </button>
            </div>
        </form>
    </div>

    <script>
        // ระบบตรวจสอบรูปแบบการกรอกข้อมูล
        document.querySelector("form").addEventListener("submit", function(e) {
            const quantitative = document.getElementById("goal_quantitative").value.trim();
            const lines = quantitative.split('\n').filter(line => line.trim() !== ''); 
            
            const isValid = lines.every((line, index) =>
                line.trim().match(/^\d+\./) 
            );

            if (!isValid || lines.length === 0) {
                e.preventDefault();
                alert("กรุณากรอกเป้าหมายเชิงปริมาณเป็นข้อ ๆ โดยขึ้นต้นด้วยตัวเลขและจุด เช่น:\n1. ข้อความที่หนึ่ง\n2. ข้อความที่สอง");
            }
        });
    </script>
</body>

</html>