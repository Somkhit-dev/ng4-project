<?php
session_start();

// ฟังก์ชันช่วยดึงค่าจาก Session ถ้าไม่มีให้คืนค่าว่าง
function getValue($fieldName) {
    return isset($_SESSION['form1'][$fieldName]) ? htmlspecialchars($_SESSION['form1'][$fieldName]) : '';
}

// ฟังก์ชันช่วยเช็ค Radio สำหรับประเภทงบประมาณและแหล่งเงิน
function isChecked($fieldName, $value) {
    return (isset($_SESSION['form1'][$fieldName]) && $_SESSION['form1'][$fieldName] == $value) ? 'checked' : '';
}
?>

<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>แบบฟอร์มจัดหาระบบคอมพิวเตอร์</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Sarabun:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Sarabun', sans-serif; }
        .form-input-focus {
            transition: all 0.3s ease;
        }
        .form-input-focus:focus {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(59, 130, 246, 0.15);
        }
        .animate-fade-in {
            animation: fadeIn 0.3s ease-in-out;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>

<body class="bg-slate-50 flex justify-center items-center min-h-screen p-4">
    <div class="bg-white p-8 rounded-2xl shadow-xl w-full max-w-4xl border border-gray-100">
        
        <div class="mb-10 text-center">
            <h1 class="text-3xl font-bold text-gray-800 mb-2">แบบฟอร์มจัดหาระบบคอมพิวเตอร์</h1>
            <p class="text-gray-500">กรุณากรอกข้อมูลโครงการให้ครบถ้วน</p>
        </div>

        <form method="POST" action="form2.php" class="space-y-8">

            <section class="space-y-4">
                <div class="flex items-center gap-2 pb-2 border-b border-blue-100">
                    <div class="w-2 h-8 bg-blue-500 rounded-full"></div>
                    <h2 class="text-xl font-bold text-gray-800">1. ชื่อโครงการ/กิจกรรม</h2>
                </div>
                <div class="px-2">
                    <input type="text" id="project_name" name="project_name" required 
                        value="<?= getValue('project_name') ?>"
                        placeholder="ระบุชื่อครงการ..."
                        class="form-input-focus mt-1 block w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-400 bg-gray-50/50">
                </div>
            </section>

            <section class="space-y-4">
                <div class="flex items-center gap-2 pb-2 border-b border-blue-100">
                    <div class="w-2 h-8 bg-blue-500 rounded-full"></div>
                    <h2 class="text-xl font-bold text-gray-800">2. ข้อมูลหน่วยงาน</h2>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 px-2">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">2.1 ชื่อส่วนราชการ <span class="text-red-500">*</span></label>
                        <input type="text" name="department_name" value="<?= getValue('department_name') ?>" required class="form-input-focus block w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-400 outline-none">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">2.2 ชื่อหน่วยงาน <span class="text-red-500">*</span></label>
                        <input type="text" name="unit_name" value="<?= getValue('unit_name') ?>" required class="form-input-focus block w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-400 outline-none">
                    </div>
                </div>

                <div class="bg-blue-50/50 p-6 rounded-2xl space-y-4">
                    <p class="text-sm font-bold text-blue-800 uppercase tracking-wider font-semibold">2.3 ข้อมูลผู้รับผิดชอบโครงการ</p>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="md:col-span-2">
                            <label class="block text-xs font-bold text-gray-500 mb-1">ชื่อ-นามสกุล</label>
                            <input type="text" name="responsible_person_name" value="<?= getValue('responsible_person_name') ?>" required class="form-input-focus block w-full px-4 py-2 border border-gray-200 rounded-lg">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-500 mb-1">ตำแหน่ง</label>
                            <input type="text" name="responsible_person_position" value="<?= getValue('responsible_person_position') ?>" required class="form-input-focus block w-full px-4 py-2 border border-gray-200 rounded-lg">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-500 mb-1">เบอร์โทรศัพท์</label>
                            <input type="tel" name="responsible_person_phone" value="<?= getValue('responsible_person_phone') ?>" pattern="[0-9]{10}" maxlength="10" class="form-input-focus block w-full px-4 py-2 border border-gray-200 rounded-lg">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-500 mb-1">อีเมล</label>
                            <input type="email" name="responsible_person_email" value="<?= getValue('responsible_person_email') ?>" required class="form-input-focus block w-full px-4 py-2 border border-gray-200 rounded-lg">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-500 mb-1">โทรสาร (ถ้ามี)</label>
                            <input type="tel" name="responsible_person_fax" value="<?= getValue('responsible_person_fax') ?>" class="form-input-focus block w-full px-4 py-2 border border-gray-200 rounded-lg">
                        </div>
                    </div>
                </div>
            </section>

            <section class="space-y-4">
                <div class="flex items-center gap-2 pb-2 border-b border-blue-100">
                    <div class="w-2 h-8 bg-blue-500 rounded-full"></div>
                    <h2 class="text-xl font-bold text-gray-800">3. งบประมาณ</h2>
                </div>

                <div class="px-2">
                    <label class="block text-sm font-semibold text-gray-700 mb-3">3.1 ประเภทงบประมาณโครงการ</label>
                    <div class="flex gap-4">
                        <label class="flex-1 cursor-pointer">
                            <input type="radio" id="budget_single" name="budget_type" value="single" class="hidden peer" onclick="toggleBudgetSection()" required <?= isChecked('budget_type', 'single') ?>>
                            <div class="p-4 text-center border-2 rounded-xl peer-checked:border-blue-500 peer-checked:bg-blue-50 hover:bg-gray-50 transition-all">
                                <span class="block font-bold text-gray-700">ปีเดียว</span>
                            </div>
                        </label>
                        <label class="flex-1 cursor-pointer">
                            <input type="radio" id="budget_multi" name="budget_type" value="multi" class="hidden peer" onclick="toggleBudgetSection()" <?= isChecked('budget_type', 'multi') ?>>
                            <div class="p-4 text-center border-2 rounded-xl peer-checked:border-blue-500 peer-checked:bg-blue-50 hover:bg-gray-50 transition-all">
                                <span class="block font-bold text-gray-700">หลายปี (ผูกพัน)</span>
                            </div>
                        </label>
                    </div>
                </div>

                <div id="budget_single_section" class="<?= (isset($_SESSION['form1']['budget_type']) && $_SESSION['form1']['budget_type'] == 'single') ? 'animate-fade-in' : 'hidden' ?> px-2">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 p-4 bg-gray-50 rounded-xl border border-dashed border-gray-300">
                        <div>
                            <label class="block text-xs font-bold text-gray-500 mb-1">ปี พ.ศ.</label>
                            <input type="text" name="single_year" value="<?= getValue('single_year') ?>" placeholder="25XX" class="block w-full px-4 py-2 border border-gray-300 rounded-lg">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-500 mb-1">วงเงิน (บาท)</label>
                            <input type="number" name="single_amount" value="<?= getValue('single_amount') ?>" placeholder="0.00" class="block w-full px-4 py-2 border border-gray-300 rounded-lg">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-500 mb-1">งบ ICT (บาท)</label>
                            <input type="number" name="single_ict" value="<?= getValue('single_ict') ?>" placeholder="0.00" class="block w-full px-4 py-2 border border-gray-300 rounded-lg">
                        </div>
                    </div>
                </div>

                <div id="budget_multi_section" class="<?= (isset($_SESSION['form1']['budget_type']) && $_SESSION['form1']['budget_type'] == 'multi') ? 'animate-fade-in' : 'hidden' ?> px-2">
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">ช่วงปีงบประมาณ</label>
                        <input type="text" name="multi_range" value="<?= getValue('multi_range') ?>" placeholder="เช่น 2567 - 2569" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg">
                    </div>
                    <div class="overflow-hidden border border-gray-200 rounded-xl bg-white">
                        <table class="w-full text-left">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-4 py-3 text-xs font-bold text-gray-500 uppercase">ปี พ.ศ.</th>
                                    <th class="px-4 py-3 text-xs font-bold text-gray-500 uppercase">จำนวนเงิน (บาท)</th>
                                    <th class="px-4 py-3 text-xs font-bold text-gray-500 uppercase">ICT (บาท)</th>
                                    <th class="px-4 py-3 w-10"></th>
                                </tr>
                            </thead>
                            <tbody id="multi_budget_body" class="divide-y divide-gray-100">
                                <?php
                                if (isset($_SESSION['form1']['multi_year'])) {
                                    foreach ($_SESSION['form1']['multi_year'] as $key => $year) {
                                ?>
                                <tr>
                                    <td class="p-2"><input type="text" name="multi_year[]" value="<?= htmlspecialchars($year) ?>" class="w-full px-3 py-1.5 border border-gray-200 rounded-md"></td>
                                    <td class="p-2"><input type="number" name="multi_amount[]" value="<?= htmlspecialchars($_SESSION['form1']['multi_amount'][$key]) ?>" class="w-full px-3 py-1.5 border border-gray-200 rounded-md"></td>
                                    <td class="p-2"><input type="number" name="multi_ict[]" value="<?= htmlspecialchars($_SESSION['form1']['multi_ict'][$key]) ?>" class="w-full px-3 py-1.5 border border-gray-200 rounded-md"></td>
                                    <td class="p-2 text-center">
                                        <button type="button" onclick="this.closest('tr').remove()" class="text-red-400 hover:text-red-600 font-bold text-xl">×</button>
                                    </td>
                                </tr>
                                <?php 
                                    }
                                } else { ?>
                                <tr>
                                    <td class="p-2"><input type="text" name="multi_year[]" class="w-full px-3 py-1.5 border border-gray-200 rounded-md"></td>
                                    <td class="p-2"><input type="number" name="multi_amount[]" class="w-full px-3 py-1.5 border border-gray-200 rounded-md"></td>
                                    <td class="p-2"><input type="number" name="multi_ict[]" class="w-full px-3 py-1.5 border border-gray-200 rounded-md"></td>
                                    <td class="p-2 text-center">
                                        <button type="button" onclick="addBudgetRow()" class="text-blue-500 hover:text-blue-700 font-bold text-xl">+</button>
                                    </td>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="px-2 pt-4">
                    <label class="block text-sm font-semibold text-gray-700 mb-3">3.2 แหล่งเงินทุน <span class="text-red-500">*</span></label>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                        <?php 
                        $sources = ["งบประมาณแผ่นดิน", "เปลี่ยนแปลงรายการ", "เงินเหลือจ่าย", "เงินรายได้", "เงินนอกงบประมาณ", "เงินช่วยเหลือ", "เงินกู้", "อื่น ๆ"];
                        foreach($sources as $index => $source): 
                        ?>
                        <label class="flex items-center p-3 border border-gray-200 rounded-lg hover:bg-blue-50 cursor-pointer transition-colors">
                            <input type="radio" name="funding_source" value="<?= $source ?>" id="<?= $index === 7 ? 'other_fund' : 'fund_'.$index ?>" 
                                class="w-4 h-4 text-blue-600 focus:ring-blue-500" required 
                                onclick="toggleOtherFundInput()" <?= isChecked('funding_source', $source) ?>>
                            <span class="ml-2 text-sm text-gray-600"><?= $source ?></span>
                        </label>
                        <?php endforeach; ?>
                    </div>
                    
                    <div id="other_fund_input" class="<?= (isset($_SESSION['form1']['funding_source']) && $_SESSION['form1']['funding_source'] == 'อื่น ๆ') ? 'animate-fade-in' : 'hidden' ?> mt-4">
                        <label class="block text-sm font-medium text-blue-700 mb-1">โปรดระบุแหล่งเงินเพิ่มเติม:</label>
                        <input type="text" id="other_funding_source_detail" name="other_funding_source_detail" 
                            value="<?= getValue('other_funding_source_detail') ?>"
                            class="block w-full px-4 py-2 border-2 border-blue-100 rounded-lg focus:ring-2 focus:ring-blue-400 outline-none">
                    </div>
                </div>
            </section>

            <div class="flex justify-between items-center pt-8 border-t border-gray-100">
                <p class="text-sm text-gray-400 italic font-light">ข้อมูลจะถูกบันทึกไว้ใน Session อัตโนมัติเมื่อกดถัดไป</p>
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-10 py-3 rounded-xl font-bold shadow-lg shadow-blue-200 transition-all hover:-translate-y-1 active:scale-95">
                    ขั้นตอนถัดไป →
                </button>
            </div>

        </form>
    </div>

    <script>
        // เรียกใช้ฟังก์ชันทันทีที่โหลดหน้า เพื่อจัดการ UI ตาม Session
        window.onload = function() {
            toggleBudgetSection();
            toggleOtherFundInput();
        };

        function toggleBudgetSection() {
            const single = document.getElementById('budget_single').checked;
            const multi = document.getElementById('budget_multi').checked;
            
            const singleSection = document.getElementById('budget_single_section');
            const multiSection = document.getElementById('budget_multi_section');

            if (single) {
                singleSection.classList.remove('hidden');
                singleSection.classList.add('animate-fade-in');
                multiSection.classList.add('hidden');
            } else if (multi) {
                multiSection.classList.remove('hidden');
                multiSection.classList.add('animate-fade-in');
                singleSection.classList.add('hidden');
            }
        }

        function addBudgetRow() {
            const tbody = document.getElementById('multi_budget_body');
            const row = document.createElement('tr');
            row.className = "bg-white hover:bg-gray-50 transition-colors animate-fade-in";
            row.innerHTML = `
                <td class="p-2"><input type="text" name="multi_year[]" class="w-full px-3 py-1.5 border border-gray-200 rounded-md" required></td>
                <td class="p-2"><input type="number" name="multi_amount[]" class="w-full px-3 py-1.5 border border-gray-200 rounded-md" required></td>
                <td class="p-2"><input type="number" name="multi_ict[]" class="w-full px-3 py-1.5 border border-gray-200 rounded-md" required></td>
                <td class="p-2 text-center">
                    <button type="button" onclick="this.closest('tr').remove()" class="text-red-400 hover:text-red-600 font-bold text-xl">×</button>
                </td>
            `;
            tbody.appendChild(row);
        }

        function toggleOtherFundInput() {
            const otherFundRadio = document.getElementById('other_fund');
            const otherInputDiv = document.getElementById('other_fund_input');
            const inputField = document.getElementById('other_funding_source_detail');
            
            if (otherFundRadio && otherFundRadio.checked) {
                otherInputDiv.classList.remove('hidden');
                otherInputDiv.classList.add('animate-fade-in');
                inputField.required = true;
            } else {
                if (otherInputDiv) {
                    otherInputDiv.classList.add('hidden');
                    inputField.required = false;
                }
            }
        }
    </script>
</body>
</html>