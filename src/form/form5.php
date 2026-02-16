<?php
session_start();

// บันทึกข้อมูลจากหน้า 4 ลง Session
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $_SESSION['form4'] = $_POST;
}

// ฟังก์ชันดึงค่าคืนกรณีมีการย้อนกลับ
function getForm5Value($fieldName) {
    return isset($_SESSION['form5'][$fieldName]) ? htmlspecialchars($_SESSION['form5'][$fieldName]) : '';
}

// ฟังก์ชันเช็ค Checkbox
function isChecked($fieldName, $value) {
    if (isset($_SESSION['form5'][$fieldName]) && is_array($_SESSION['form5'][$fieldName])) {
        return in_array($value, $_SESSION['form5'][$fieldName]) ? 'checked' : '';
    }
    return '';
}
?>

<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ฟอร์มหน้าที่ 5 - รายละเอียดระบบงาน</title>
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

        <form method="POST" action="form6.php" id="mainForm" class="space-y-8">

            <section class="space-y-6">
                <div class="flex items-center gap-2 pb-2 border-b border-blue-100">
                    <div class="w-2 h-8 bg-blue-500 rounded-full"></div>
                    <h2 class="text-xl font-bold text-gray-800">12.2 รายละเอียดการพัฒนาระบบงาน <span class="text-red-500">*</span></h2>
                </div>

                <div class="grid grid-cols-1 gap-6 px-2">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">12.2.1 ชื่อระบบงาน <span class="text-red-500">*</span></label>
                        <input type="text" name="system_name" value="<?= getForm5Value('system_name') ?>" required class="form-input-focus w-full px-4 py-3 border border-gray-300 rounded-xl outline-none bg-gray-50/50" placeholder="ระบุชื่อระบบงาน...">
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">12.2.2 ขอบเขตและข้อกำหนด <span class="text-red-500">*</span></label>
                        <textarea name="system_scope" rows="3" required class="form-input-focus w-full px-4 py-3 border border-gray-300 rounded-xl outline-none bg-gray-50/50"><?= getForm5Value('system_scope') ?></textarea>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">12.2.3 แนวคิดของระบบงาน <span class="text-red-500">*</span></label>
                        <textarea name="system_concept" rows="3" required class="form-input-focus w-full px-4 py-3 border border-gray-300 rounded-xl outline-none bg-gray-50/50"><?= getForm5Value('system_concept') ?></textarea>
                    </div>
                </div>

                <div class="bg-blue-50/50 p-6 rounded-2xl border border-blue-100 space-y-4" id="cost-items-container">
                    <label class="block text-sm font-bold text-blue-800 uppercase tracking-wider">12.2.4 รายละเอียดค่าใช้จ่าย <span class="text-red-500">*</span></label>
                    
                    <div id="cost-items-list" class="space-y-4">
                        <?php 
                        $cost_items = $_SESSION['form5']['cost_item'] ?? [''];
                        foreach($cost_items as $idx => $val): ?>
                        <div class="cost-item p-4 bg-white rounded-xl border border-gray-200 relative animate-fade-in shadow-sm">
                            <div class="flex items-center gap-2 mb-3">
                                <span class="bg-blue-600 text-white w-6 h-6 flex items-center justify-center rounded-full text-xs cost-item-index"><?= $idx + 1 ?></span>
                                <span class="text-sm font-bold text-gray-600">รายการค่าใช้จ่าย <span class="text-red-500">*</span></span>
                            </div>
                            <textarea name="cost_item[]" rows="2" required class="w-full px-4 py-2 border border-gray-200 rounded-lg outline-none focus:ring-2 focus:ring-blue-400 mb-4 text-sm" placeholder="รายละเอียดค่าใช้จ่าย..."><?= htmlspecialchars($val) ?></textarea>
                            
                            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                                <div>
                                    <label class="block text-[10px] font-bold text-gray-400 uppercase mb-1">ระยะเวลา (เดือน) <span class="text-red-500">*</span></label>
                                    <input type="number" name="cost_duration[]" required value="<?= htmlspecialchars($_SESSION['form5']['cost_duration'][$idx] ?? '') ?>" class="w-full px-3 py-2 border border-gray-200 rounded-lg text-sm" oninput="calculateRow(this)">
                                </div>
                                <div>
                                    <label class="block text-[10px] font-bold text-gray-400 uppercase mb-1">อัตรา (บาท) <span class="text-red-500">*</span></label>
                                    <input type="number" name="cost_rate[]" required value="<?= htmlspecialchars($_SESSION['form5']['cost_rate'][$idx] ?? '') ?>" class="w-full px-3 py-2 border border-gray-200 rounded-lg text-sm" oninput="calculateRow(this)">
                                </div>
                                <div>
                                    <label class="block text-[10px] font-bold text-gray-400 uppercase mb-1">จำนวน <span class="text-red-500">*</span></label>
                                    <input type="number" name="cost_amount[]" required value="<?= htmlspecialchars($_SESSION['form5']['cost_amount'][$idx] ?? '') ?>" class="w-full px-3 py-2 border border-gray-200 rounded-lg text-sm" oninput="calculateRow(this)">
                                </div>
                                <div>
                                    <label class="block text-[10px] font-bold text-gray-400 uppercase mb-1">รวม (บาท) <span class="text-red-500">*</span></label>
                                    <input type="number" name="cost_total[]" required readonly value="<?= htmlspecialchars($_SESSION['form5']['cost_total'][$idx] ?? '') ?>" class="w-full px-3 py-2 border border-gray-200 rounded-lg text-sm bg-gray-50 font-bold text-blue-600">
                                </div>
                            </div>
                            <button type="button" class="remove-cost-item absolute top-4 right-4 text-red-400 font-bold <?= count($cost_items) === 1 ? 'hidden' : '' ?>">×</button>
                        </div>
                        <?php endforeach; ?>
                    </div>

                    <div class="flex justify-between items-center mt-6 pt-4 border-t border-blue-100">
                        <div class="flex items-center gap-4">
                            <span class="text-gray-700 font-bold">รวมทั้งสิ้น:</span>
                            <input type="number" id="total_cost" name="total_cost" value="<?= getForm5Value('total_cost') ?>" required class="w-48 px-4 py-2 bg-white border-2 border-green-400 rounded-xl text-green-600 font-black text-xl outline-none text-center" readonly placeholder="0">
                        </div>
                        <button type="button" id="add-cost-item" class="bg-blue-600 text-white px-6 py-2 rounded-xl shadow-lg hover:bg-blue-700 transition-all font-bold">+ เพิ่มรายการ</button>
                    </div>
                </div>
            </section>

            <section class="space-y-4">
                <div class="flex items-center gap-2 pb-2 border-b border-blue-100">
                    <div class="w-2 h-8 bg-blue-500 rounded-full"></div>
                    <h2 class="text-xl font-bold text-gray-800">13. วิธีการจัดหา <span class="text-red-500">*</span></h2>
                </div>
                <div class="flex flex-wrap gap-4 px-2" id="procurement-group">
                    <?php 
                    $methods = ["จัดซื้อ", "การจ้าง", "อื่น ๆ"];
                    foreach($methods as $method): ?>
                    <label class="flex items-center p-3 border border-gray-200 rounded-lg hover:bg-blue-50 cursor-pointer transition-colors">
                        <input type="checkbox" name="procurement_methods[]" value="<?= $method ?>" <?= isChecked('procurement_methods', $method) ?> 
                            class="w-5 h-5 text-blue-600 rounded procurement-checkbox" 
                            <?= $method === 'อื่น ๆ' ? 'id="procurement-method-other-checkbox"' : '' ?>>
                        <span class="ml-2 text-sm text-gray-600"><?= $method ?></span>
                    </label>
                    <?php endforeach; ?>
                    <input type="text" name="procurement_method_other_detail" id="procurement-method-other-input" value="<?= getForm5Value('procurement_method_other_detail') ?>" 
                        class="<?= (isset($_SESSION['form5']['procurement_method_other_detail']) && $_SESSION['form5']['procurement_method_other_detail'] != '') ? '' : 'hidden' ?> px-4 py-2 border-2 border-blue-100 rounded-xl outline-none" placeholder="โปรดระบุ...">
                </div>
            </section>

            <section class="space-y-4">
                <div class="flex items-center gap-2 pb-2 border-b border-blue-100">
                    <div class="w-2 h-8 bg-blue-500 rounded-full"></div>
                    <h2 class="text-xl font-bold text-gray-800">14. สถานที่ติดตั้งอุปกรณ์ <span class="text-red-500">*</span></h2>
                </div>
                <div class="overflow-x-auto rounded-xl border border-gray-200">
                    <table class="w-full text-left" id="dynamic-table">
                        <thead class="bg-slate-50">
                            <tr>
                                <th class="px-4 py-3 text-xs font-bold text-gray-500 uppercase">รายการ <span class="text-red-500">*</span></th>
                                <th class="px-4 py-3 text-xs font-bold text-gray-500 uppercase w-24">จำนวน <span class="text-red-500">*</span></th>
                                <th class="px-4 py-3 text-xs font-bold text-gray-500 uppercase">สถานที่ติดตั้ง <span class="text-red-500">*</span></th>
                                <th class="px-4 py-3 w-16 text-center">
                                    <button type="button" id="add-row-btn" class="text-blue-600 text-xl font-bold">+</button>
                                </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            <?php 
                            $table_col1 = $_SESSION['form5']['table_col1'] ?? [''];
                            foreach($table_col1 as $idx => $val): ?>
                            <tr>
                                <td class="p-2"><input type="text" name="table_col1[]" required value="<?= htmlspecialchars($val) ?>" class="w-full px-3 py-1.5 border border-gray-200 rounded-md"></td>
                                <td class="p-2"><input type="text" name="table_col2[]" required value="<?= htmlspecialchars($_SESSION['form5']['table_col2'][$idx] ?? '') ?>" class="w-full px-3 py-1.5 border border-gray-200 rounded-md"></td>
                                <td class="p-2"><input type="text" name="table_col3[]" required value="<?= htmlspecialchars($_SESSION['form5']['table_col3'][$idx] ?? '') ?>" class="w-full px-3 py-1.5 border border-gray-200 rounded-md"></td>
                                <td class="p-2 text-center">
                                    <?php if($idx > 0): ?>
                                    <button type="button" class="remove-row text-red-400 font-bold text-xl">×</button>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </section>

            <section class="space-y-4">
                <div class="flex items-center gap-2 pb-2 border-b border-blue-100">
                    <div class="w-2 h-8 bg-blue-500 rounded-full"></div>
                    <h2 class="text-xl font-bold text-gray-800">15. ประโยชน์ที่คาดว่าจะได้รับ <span class="text-red-500">*</span></h2>
                </div>
                <div class="px-2">
                    <textarea name="expected_benefits" rows="4" required class="form-input-focus w-full px-4 py-3 border border-gray-300 rounded-xl outline-none bg-gray-50/50" placeholder="ระบุประโยชน์ที่จะได้รับ..."><?= getForm5Value('expected_benefits') ?></textarea>
                </div>
            </section>

            <div class="flex justify-between items-center pt-8 border-t">
                <a href="form4.php" class="text-gray-500 hover:text-gray-700 font-bold">← ย้อนกลับ</a>
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-12 py-3 rounded-xl font-bold shadow-lg transition-all hover:-translate-y-1 active:scale-95">
                    ถัดไป →
                </button>
            </div>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const mainForm = document.getElementById('mainForm');
            const costList = document.getElementById('cost-items-list');
            const addCostBtn = document.getElementById('add-cost-item');
            const installTable = document.getElementById('dynamic-table').querySelector('tbody');
            const addRowBtn = document.getElementById('add-row-btn');

            // --- คำนวณรวมรายแถว และ รวมทั้งสิ้น ---
            window.calculateRow = function(input) {
                const parent = input.closest('.cost-item');
                const duration = parseFloat(parent.querySelector('input[name="cost_duration[]"]').value || 0);
                const rate = parseFloat(parent.querySelector('input[name="cost_rate[]"]').value || 0);
                const amount = parseFloat(parent.querySelector('input[name="cost_amount[]"]').value || 0);
                
                const total = duration * rate * amount;
                parent.querySelector('input[name="cost_total[]"]').value = total;
                calculateGrandTotal();
            };

            function calculateGrandTotal() {
                let grandTotal = 0;
                document.querySelectorAll('input[name="cost_total[]"]').forEach(input => {
                    grandTotal += parseFloat(input.value || 0);
                });
                document.getElementById('total_cost').value = grandTotal;
            }

            // --- ระบบรายการค่าใช้จ่าย ---
            function updateCostIndexes() {
                const items = costList.querySelectorAll('.cost-item');
                items.forEach((item, idx) => {
                    item.querySelector('.cost-item-index').textContent = idx + 1;
                    const removeBtn = item.querySelector('.remove-cost-item');
                    if (items.length > 1) removeBtn.classList.remove('hidden');
                    else removeBtn.classList.add('hidden');
                });
                calculateGrandTotal();
            }

            addCostBtn.addEventListener('click', () => {
                const firstItem = costList.querySelector('.cost-item');
                const newItem = firstItem.cloneNode(true);
                newItem.querySelectorAll('input, textarea').forEach(i => i.value = '');
                costList.appendChild(newItem);
                updateCostIndexes();
            });

            costList.addEventListener('click', (e) => {
                if (e.target.classList.contains('remove-cost-item')) {
                    e.target.closest('.cost-item').remove();
                    updateCostIndexes();
                }
            });

            // --- ระบบตารางสถานที่ติดตั้ง ---
            addRowBtn.addEventListener('click', () => {
                const firstRow = installTable.querySelector('tr');
                const newRow = firstRow.cloneNode(true);
                newRow.querySelectorAll('input').forEach(i => i.value = '');
                const actionCell = newRow.querySelector('td:last-child');
                actionCell.innerHTML = '<button type="button" class="remove-row text-red-400 font-bold text-xl">×</button>';
                installTable.appendChild(newRow);
            });

            installTable.addEventListener('click', (e) => {
                if (e.target.classList.contains('remove-row')) {
                    e.target.closest('tr').remove();
                }
            });

            // --- ตรวจสอบ Checkbox ก่อน Submit ---
            mainForm.addEventListener('submit', function(e) {
                const checkboxes = document.querySelectorAll('.procurement-checkbox:checked');
                if (checkboxes.length === 0) {
                    e.preventDefault();
                    alert("กรุณาเลือกวิธีการจัดหาอย่างน้อย 1 วิธี");
                }
            });

            // --- อื่นๆ (ระบุ) ---
            const otherCheckbox = document.getElementById('procurement-method-other-checkbox');
            const otherInput = document.getElementById('procurement-method-other-input');
            if(otherCheckbox) {
                otherCheckbox.addEventListener('change', function() {
                    otherInput.classList.toggle('hidden', !this.checked);
                    if (this.checked) otherInput.setAttribute('required', 'required');
                    else otherInput.removeAttribute('required');
                });
            }

            calculateGrandTotal();
        });
    </script>
</body>
</html>