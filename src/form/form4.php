<?php
session_start();

// 1. บันทึกข้อมูลจากหน้า 3 ลง Session เมื่อกดถัดไปมา
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $_SESSION['form3'] = $_POST;
}

// 2. ฟังก์ชันช่วยดึงค่าปกติ (String)
function getForm4Value($fieldName) {
    return isset($_SESSION['form4'][$fieldName]) ? htmlspecialchars($_SESSION['form4'][$fieldName]) : '';
}

// 3. ฟังก์ชันเช็ค Checkbox นโยบาย
function isPolicyChecked($value) {
    if (isset($_SESSION['form4']['policy_options']) && is_array($_SESSION['form4']['policy_options'])) {
        return in_array($value, $_SESSION['form4']['policy_options']) ? 'checked' : '';
    }
    return '';
}

// 4. แก้ไขฟังก์ชันเช็ค Radio เกณฑ์ ICT (ดึงจาก Array)
function isIctChecked($index, $value) {
    if (isset($_SESSION['form4']['ict_criteria'][$index]) && $_SESSION['form4']['ict_criteria'][$index] == $value) {
        return 'checked';
    }
    return '';
}
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ฟอร์มหน้าที่ 4 - รายละเอียดอุปกรณ์</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Sarabun:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Sarabun', sans-serif; }
        .form-input-focus { transition: all 0.3s ease; }
        .form-input-focus:focus { transform: translateY(-1px); box-shadow: 0 4px 12px rgba(59, 130, 246, 0.15); }
        .animate-fade-in { animation: fadeIn 0.3s ease-in-out; }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
    </style>
</head>
<body class="bg-slate-50 flex justify-center items-center min-h-screen p-4">
    <div class="bg-white p-8 rounded-2xl shadow-xl w-full max-w-5xl border border-gray-100">
        
        <div class="mb-10 text-center">
            <h1 class="text-3xl font-bold text-gray-800 mb-2">แบบฟอร์มจัดหาระบบคอมพิวเตอร์</h1>
            <p class="text-gray-500">กรุณากรอกข้อมูลโครงการให้ครบถ้วน</p>
        </div>

        <form method="POST" action="form5.php" id="mainForm" class="space-y-8">

            <section class="space-y-4">
                <div class="flex items-center gap-2 pb-2 border-b border-blue-100">
                    <div class="w-2 h-8 bg-blue-500 rounded-full"></div>
                    <h2 class="text-xl font-bold text-gray-800">11. ความสอดคล้องกับนโยบาย <span class="text-red-500">*</span></h2>
                </div>
                <div class="grid grid-cols-1 gap-3 px-2">
                    <?php 
                    $policies = [
                        "national_strategy" => "สอดคล้องกับยุทธศาสตร์ชาติ/แผนปฏิรูปประเทศ",
                        "digital_economy_plan" => "สอดคล้องกับแผนพัฒนาดิจิทัลเพื่อเศรษฐกิจและสังคม",
                        "ministry_digital_plan" => "สอดคล้องกับแผนพัฒนาดิจิทัลของกระทรวง",
                        "agency_digital_action_plan" => "สอดคล้องกับแผนปฏิบัติการดิจิทัลของหน่วยงาน",
                        "other" => "อื่น ๆ (ระบุรายละเอียดเพิ่มเติม)"
                    ];
                    foreach($policies as $val => $label): ?>
                    <label class="flex items-center p-3 border border-gray-100 rounded-xl hover:bg-blue-50 transition-colors cursor-pointer">
                        <input type="checkbox" name="policy_options[]" value="<?= $val ?>" <?= isPolicyChecked($val) ?> 
                            class="w-5 h-5 text-blue-600 rounded" 
                            <?= $val === 'other' ? 'onchange="toggleOtherPolicy(this)"' : '' ?>>
                        <span class="ml-3 text-gray-700"><?= $label ?></span>
                    </label>
                    <?php endforeach; ?>
                </div>
                <div id="other_policy_input" class="<?= isPolicyChecked('other') ? '' : 'hidden' ?> px-2">
                    <textarea name="other_policy_detail" placeholder="อธิบายความสอดคล้อง..." 
                        class="w-full px-4 py-3 border-2 border-blue-100 rounded-xl outline-none"><?= getForm4Value('other_policy_detail') ?></textarea>
                </div>
            </section>

            <section class="space-y-4">
                <div class="flex items-center gap-2 pb-2 border-b border-blue-100">
                    <div class="w-2 h-8 bg-blue-500 rounded-full"></div>
                    <h2 class="text-xl font-bold text-gray-800">12. รายละเอียดอุปกรณ์ <span class="text-red-500">*</span></h2>
                </div>

                <div id="items_container" class="space-y-6">
                    <?php
                    $item_names = $_SESSION['form4']['item_name'] ?? [''];
                    foreach($item_names as $idx => $name):
                    ?>
                    <div class="item-form p-6 bg-slate-50 rounded-2xl border border-gray-200 relative shadow-sm">
                        <div class="flex justify-between items-center mb-4 border-b border-gray-200 pb-2">
                            <span class="text-blue-600 font-bold">รายการที่ <span class="item-number"><?= $idx + 1 ?></span></span>
                            <?php if($idx > 0): ?>
                            <button type="button" onclick="removeItem(this)" class="text-red-400 hover:text-red-600 font-bold">ลบรายการนี้ ×</button>
                            <?php endif; ?>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                            <div class="md:col-span-2">
                                <label class="block text-xs font-bold text-gray-500 mb-1">ชื่อรายการ <span class="text-red-500">*</span></label>
                                <input type="text" name="item_name[]" value="<?= htmlspecialchars($name) ?>" required class="form-input-focus block w-full px-4 py-2 border border-gray-300 rounded-lg outline-none">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-gray-500 mb-1">จำนวน <span class="text-red-500">*</span></label>
                                <input type="number" name="item_quantity[]" value="<?= htmlspecialchars($_SESSION['form4']['item_quantity'][$idx] ?? '') ?>" required min="1" oninput="calculateTotal()" class="form-input-focus block w-full px-4 py-2 border border-gray-300 rounded-lg outline-none">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-gray-500 mb-1">ราคา/หน่วย <span class="text-red-500">*</span></label>
                                <input type="number" name="unit_price[]" value="<?= htmlspecialchars($_SESSION['form4']['unit_price'][$idx] ?? '') ?>" required min="0" oninput="calculateTotal()" class="form-input-focus block w-full px-4 py-2 border border-gray-300 rounded-lg outline-none">
                            </div>
                            <div class="md:col-span-2">
                                <label class="block text-xs font-bold text-gray-500 mb-1">คุณลักษณะเฉพาะ <span class="text-red-500">*</span></label>
                                <textarea name="item_specification[]" required rows="3" class="form-input-focus block w-full px-4 py-2 border border-gray-300 rounded-lg outline-none text-sm"><?= htmlspecialchars($_SESSION['form4']['item_specification'][$idx] ?? '') ?></textarea>
                            </div>
                            <div class="md:col-span-2">
                                <label class="block text-xs font-bold text-gray-500 mb-1">รายละเอียดอื่นๆ <span class="text-red-500">*</span></label>
                                <textarea name="item_additional_detail[]" required rows="3" class="form-input-focus block w-full px-4 py-2 border border-gray-300 rounded-lg outline-none text-sm"><?= htmlspecialchars($_SESSION['form4']['item_additional_detail'][$idx] ?? '') ?></textarea>
                            </div>

                            <div class="md:col-span-4 bg-white p-4 rounded-xl border border-gray-100">
                                <label class="block text-xs font-bold text-blue-500 mb-3">เกณฑ์ราคากลาง (ICT Criteria)</label>
                                <div class="flex flex-wrap gap-4">
                                    <label class="flex items-center text-sm cursor-pointer"><input type="radio" name="ict_criteria[<?= $idx ?>]" value="no_criteria" required <?= isIctChecked($idx, 'no_criteria') ?> class="w-4 h-4 text-blue-600"><span class="ml-2">ไม่มีในเกณฑ์</span></label>
                                    <label class="flex items-center text-sm cursor-pointer"><input type="radio" name="ict_criteria[<?= $idx ?>]" value="compliant" <?= isIctChecked($idx, 'compliant') ?> class="w-4 h-4 text-blue-600"><span class="ml-2">ตามเกณฑ์</span></label>
                                    <label class="flex items-center text-sm cursor-pointer"><input type="radio" name="ict_criteria[<?= $idx ?>]" value="not_compliant" <?= isIctChecked($idx, 'not_compliant') ?> onchange="toggleIctDetail(this)" class="w-4 h-4 text-blue-600"><span class="ml-2">ไม่เป็นไปตามเกณฑ์</span></label>
                                </div>
                                <div class="ict-standard-detail <?= isIctChecked($idx, 'not_compliant') ? '' : 'hidden' ?> mt-3">
                                    <input type="text" name="ict_standard_detail[]" value="<?= htmlspecialchars($_SESSION['form4']['ict_standard_detail'][$idx] ?? '') ?>" placeholder="ระบุเหตุผล..." class="w-full px-4 py-2 border-b-2 border-blue-100 outline-none">
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>

                <div class="flex justify-center"><button type="button" onclick="addItem()" class="border-2 border-blue-500 text-blue-600 px-6 py-2 rounded-xl font-bold hover:bg-blue-50">+ เพิ่มรายการอุปกรณ์</button></div>
            </section>

            <section class="bg-blue-600 rounded-2xl p-6 text-white shadow-lg">
                <div class="flex flex-col md:flex-row justify-between items-center gap-4">
                    <h3 class="text-xl font-bold">รวมงบประมาณทั้งสิ้น (บาท)</h3>
                    <input type="number" id="total_budget_display" name="total_budget" value="<?= getForm4Value('total_budget') ?>" required readonly class="w-full md:w-64 px-6 py-3 bg-white text-blue-600 text-2xl font-black rounded-xl text-center">
                </div>
            </section>

            <div class="flex justify-between items-center pt-8 border-t">
                <a href="form3.php" class="text-gray-400 font-bold">← ย้อนกลับ</a>
                <button type="submit" class="bg-green-500 hover:bg-green-600 text-white px-12 py-3 rounded-xl font-bold shadow-lg">ยืนยันข้อมูลหน้าถัดไป →</button>
            </div>
        </form>
    </div>

    <script>
        function toggleOtherPolicy(cb) {
            document.getElementById('other_policy_input').classList.toggle('hidden', !cb.checked);
        }

        function toggleIctDetail(radio) {
            const detailDiv = radio.closest('.bg-white').querySelector('.ict-standard-detail');
            detailDiv.classList.toggle('hidden', radio.value !== 'not_compliant');
        }

        function calculateTotal() {
            let grandTotal = 0;
            const quantities = document.getElementsByName('item_quantity[]');
            const prices = document.getElementsByName('unit_price[]');
            for(let i=0; i < quantities.length; i++) {
                grandTotal += (parseFloat(quantities[i].value || 0) * parseFloat(prices[i].value || 0));
            }
            document.getElementById('total_budget_display').value = grandTotal;
        }

        function updateItemNumbers() {
            document.querySelectorAll('#items_container .item-form').forEach((el, idx) => {
                el.querySelector('.item-number').textContent = idx + 1;
                // แก้ไข JavaScript ให้ตั้งค่า name แบบ Array index
                el.querySelectorAll('input[type="radio"]').forEach(radio => {
                    radio.name = `ict_criteria[${idx}]`;
                });
            });
        }

        function addItem() {
            const container = document.getElementById('items_container');
            const newItem = container.querySelector('.item-form').cloneNode(true);
            newItem.querySelectorAll('input, textarea').forEach(input => {
                if(input.type === 'radio') input.checked = false;
                else if(input.type === 'checkbox') input.checked = false;
                else input.value = '';
            });
            newItem.querySelector('.ict-standard-detail').classList.add('hidden');
            container.appendChild(newItem);
            updateItemNumbers();
        }

        function removeItem(btn) {
            btn.closest('.item-form').remove();
            updateItemNumbers();
            calculateTotal();
        }

        document.getElementById('mainForm').addEventListener('submit', function(e) {
            const specs = document.getElementsByName('item_specification[]');
            for (let i = 0; i < specs.length; i++) {
                const lines = specs[i].value.trim().split('\n').filter(l => l.trim() !== '');
                if (!lines.every((line) => line.trim().match(/^\d+\./))) {
                    e.preventDefault();
                    alert(`รายการที่ ${i + 1}: กรุณากรอกรายละเอียดให้เป็นข้อๆ (1. 2. 3.)`);
                    specs[i].focus();
                    return;
                }
            }
        });

        window.onload = calculateTotal;
    </script>
</body>
</html>