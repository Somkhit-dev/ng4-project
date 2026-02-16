<?php
session_start();

// 1. บันทึกข้อมูลหน้า 5
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $_SESSION['form5'] = $_POST;
}

// 2. ตรวจสอบว่าใน Session มีรูปที่เคยอัปโหลดไว้ก่อนหน้าไหม (เป็น Base64)
$saved_image = isset($_SESSION['form6_image_data']) ? $_SESSION['form6_image_data'] : '';
?>

<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ฟอร์มหน้าที่ 6 - อัปโหลดโครงสร้างระบบ</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Sarabun:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Sarabun', sans-serif;
        }
    </style>
</head>

<body class="bg-slate-50 flex justify-center items-center min-h-screen p-4">
    <div class="bg-white p-8 rounded-2xl shadow-xl w-full max-w-4xl border border-gray-100">

        <div class="mb-10 text-center">
            <h1 class="text-3xl font-bold text-gray-800 mb-2">แบบฟอร์มจัดหาระบบคอมพิวเตอร์</h1>
            <p class="text-gray-500">กรุณากรอกข้อมูลโครงการให้ครบถ้วน</p>
        </div>
        <form method="POST" action="form_db.php" enctype="multipart/form-data" class="space-y-8">

            <section class="space-y-4">
                <div class="flex items-center gap-2 pb-2 border-b border-blue-100">
                    <div class="w-2 h-8 bg-blue-500 rounded-full"></div>
                    <h2 class="text-xl font-bold text-gray-800">16. โครงสร้างและการเชื่อมต่อระบบ <span class="text-red-500">*</span></h2>
                </div>

                <div class="px-2">
                    <div class="flex flex-col items-center justify-center w-full">
                        <label for="image_file" class="flex flex-col items-center justify-center w-full min-h-[16rem] border-2 border-blue-200 border-dashed rounded-2xl cursor-pointer bg-blue-50/30 hover:bg-blue-50 transition-all p-4">

                            <div id="upload-placeholder" class="<?= $saved_image ? 'hidden' : '' ?> flex flex-col items-center">
                                <svg class="w-12 h-12 mb-3 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                <p class="mb-2 text-sm text-gray-700 font-bold">คลิกเพื่อเลือกรูปภาพ</p>
                            </div>

                            <img id="preview-img" src="<?= $saved_image ?>" class="<?= $saved_image ? '' : 'hidden' ?> max-h-64 object-contain rounded-lg shadow-md" alt="Preview">

                            <input type="file" name="image_file" id="image_file" accept=".jpg,.jpeg,.png" class="hidden" onchange="processFile(this)">

                            <input type="hidden" name="image_data_base64" id="image_data_base64" value="<?= $saved_image ?>">
                        </label>
                    </div>
                    <p class="text-center text-xs text-gray-400 mt-2">* หากต้องการเปลี่ยนรูป ให้คลิกที่รูปเดิมเพื่อเลือกใหม่</p>
                </div>
            </section>

            <div class="flex justify-between items-center pt-8 border-t">
                <a href="form5.php" class="text-gray-500 font-bold">← ย้อนกลับ</a>
                <button type="submit" id="submitBtn" class="bg-green-600 text-white px-12 py-4 rounded-xl font-bold shadow-lg">
                    บันทึกข้อมูล
                </button>
            </div>
        </form>
    </div>

    <script>
        function processFile(input) {
            const preview = document.getElementById('preview-img');
            const placeholder = document.getElementById('upload-placeholder');
            const hiddenInput = document.getElementById('image_data_base64');
            const file = input.files[0];
            const reader = new FileReader();

            reader.onloadend = function() {
                const base64String = reader.result;
                preview.src = base64String;
                hiddenInput.value = base64String; // เก็บรูปลง hidden input

                preview.classList.remove('hidden');
                placeholder.classList.add('hidden');

                // ส่งรูปไปเก็บใน Session ทันทีผ่าน AJAX (เพื่อให้ย้อนกลับแล้วไม่หาย)
                saveImageToSession(base64String);
            }

            if (file) {
                reader.readAsDataURL(file);
            }
        }

        // ฟังก์ชันพิเศษ: ส่งรูปไปฝากไว้ใน Session ทันทีที่เลือก
        function saveImageToSession(base64Data) {
            fetch('save_image_session.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: 'image_data=' + encodeURIComponent(base64Data)
            });
        }

        // ตรวจสอบก่อนส่งว่ามีรูปหรือยัง
        document.querySelector('form').onsubmit = function(e) {
            const imageData = document.getElementById('image_data_base64').value;
            if (!imageData) {
                e.preventDefault();
                alert("กรุณาเลือกรูปภาพโครงสร้างระบบก่อนบันทึก");
            }
        };
    </script>
</body>

</html>