<?php
session_start();

// บันทึกข้อมูลจากหน้า 2 ลง Session เมื่อมีการส่งค่ามา
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $_SESSION['form2'] = $_POST;
}

// ฟังก์ชันช่วยดึงค่าปกติ (String)
function getForm3Value($fieldName) {
    return isset($_SESSION['form3'][$fieldName]) ? htmlspecialchars($_SESSION['form3'][$fieldName]) : '';
}

/**
 * ฟังก์ชันเช็คสถานะ Checkbox ของแผนงาน (Array 2 มิติ)
 * $rowIdx = ลำดับกิจกรรม (1, 2, 3...)
 * $monthVal = เลขเดือน (1-12)
 */
function isMonthChecked($rowIdx, $monthVal) {
    if (isset($_SESSION['form3']['work_plan_months'][$rowIdx]) && is_array($_SESSION['form3']['work_plan_months'][$rowIdx])) {
        return in_array($monthVal, $_SESSION['form3']['work_plan_months'][$rowIdx]) ? 'checked' : '';
    }
    return '';
}

// ฟังก์ชันเช็ค Radio ของลักษณะโครงการ
function isRadioChecked($fieldName, $value) {
    return (isset($_SESSION['form3'][$fieldName]) && $_SESSION['form3'][$fieldName] == $value) ? 'checked' : '';
}
?>

<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ฟอร์มหน้าที่ 3 - ลักษณะโครงการและแผนงาน</title>
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

        <form action="form4.php" method="POST" id="mainForm" class="space-y-8">
            
            <section class="space-y-4">
                <div class="flex items-center gap-2 pb-2 border-b border-blue-100">
                    <div class="w-2 h-8 bg-blue-500 rounded-full"></div>
                    <h2 class="text-xl font-bold text-gray-800">7. ลักษณะโครงการ <span class="text-red-500">*</span></h2>
                </div>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-3 px-2">
                    <?php 
                    $p_types = ["จัดหาใหม่", "ขยายระบบเดิม", "ทดแทนระบบเดิม", "อื่น ๆ"];
                    foreach($p_types as $type): ?>
                        <label class="flex items-center p-3 border border-gray-200 rounded-lg hover:bg-blue-50 cursor-pointer transition-colors">
                            <input type="radio" name="project_type" value="<?= $type ?>" <?= isRadioChecked('project_type', $type) ?> class="w-4 h-4 text-blue-600" required onclick="toggleOtherProjectInput()">
                            <span class="ml-2 text-sm text-gray-600"><?= $type ?></span>
                        </label>
                    <?php endforeach; ?>
                </div>
                <div id="otherProjectInput" class="<?= (isset($_SESSION['form3']['project_type']) && $_SESSION['form3']['project_type'] == 'อื่น ๆ') ? '' : 'hidden' ?> px-2 animate-fade-in">
                    <input type="text" id="other_project_detail" name="other_project_detail" value="<?= getForm3Value('other_project_detail') ?>" class="w-full px-4 py-2 border-2 border-blue-100 rounded-lg outline-none" placeholder="โปรดระบุลักษณะโครงการ...">
                </div>
            </section>

            <section class="space-y-4">
                <div class="flex items-center gap-2 pb-2 border-b border-blue-100">
                    <div class="w-2 h-8 bg-blue-500 rounded-full"></div>
                    <h2 class="text-xl font-bold text-gray-800">8. สถานภาพปัจจุบัน <span class="text-red-500">*</span></h2>
                </div>
                <div class="overflow-x-auto rounded-xl border border-gray-200">
                    <table class="w-full text-left">
                        <thead class="bg-slate-50">
                            <tr>
                                <th class="px-4 py-3 text-xs font-bold text-gray-500 uppercase">รายการ</th>
                                <th class="px-4 py-3 text-xs font-bold text-gray-500 uppercase">สถานที่ติดตั้ง</th>
                                <th class="px-4 py-3 text-xs font-bold text-gray-500 uppercase">ปี พ.ศ. ที่ติดตั้ง</th>
                                <th class="px-4 py-3 w-20 text-center">
                                    <button type="button" onclick="addStatusRow()" class="text-blue-600 text-xl font-bold">+</button>
                                </th>
                            </tr>
                        </thead>
                        <tbody id="status_table_body" class="divide-y divide-gray-100">
                            <?php 
                            $status_items = $_SESSION['form3']['status_item'] ?? [''];
                            foreach($status_items as $idx => $val): ?>
                            <tr>
                                <td class="p-2"><input type="text" name="status_item[]" value="<?= htmlspecialchars($val) ?>" required class="w-full px-3 py-1.5 border border-gray-200 rounded-md outline-none"></td>
                                <td class="p-2"><input type="text" name="status_location[]" value="<?= htmlspecialchars($_SESSION['form3']['status_location'][$idx] ?? '') ?>" required class="w-full px-3 py-1.5 border border-gray-200 rounded-md outline-none"></td>
                                <td class="p-2"><input type="text" name="status_year[]" value="<?= htmlspecialchars($_SESSION['form3']['status_year'][$idx] ?? '') ?>" required class="w-full px-3 py-1.5 border border-gray-200 rounded-md outline-none"></td>
                                <td class="p-2 text-center">
                                    <?php if($idx > 0): ?>
                                    <button type="button" onclick="this.closest('tr').remove()" class="text-red-400 hover:text-red-600 font-bold text-xl">×</button>
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
                    <h2 class="text-xl font-bold text-gray-800">9. บุคลากรด้าน IT <span class="text-red-500">*</span></h2>
                </div>
                <div class="overflow-x-auto rounded-xl border border-gray-200 max-w-2xl">
                    <table class="w-full text-left">
                        <thead class="bg-slate-50">
                            <tr>
                                <th class="px-4 py-3 text-xs font-bold text-gray-500 uppercase">ตำแหน่ง</th>
                                <th class="px-4 py-3 text-xs font-bold text-gray-500 uppercase">จำนวน (คน)</th>
                                <th class="px-4 py-3 w-20 text-center">
                                    <button type="button" onclick="addItPersonnelRow()" class="text-blue-600 text-xl font-bold">+</button>
                                </th>
                            </tr>
                        </thead>
                        <tbody id="it_personnel_table_body" class="divide-y divide-gray-100">
                            <?php 
                            $it_positions = $_SESSION['form3']['it_personnel_position'] ?? [''];
                            foreach($it_positions as $idx => $val): ?>
                            <tr>
                                <td class="p-2"><input type="text" name="it_personnel_position[]" value="<?= htmlspecialchars($val) ?>" required class="w-full px-3 py-1.5 border border-gray-200 rounded-md outline-none"></td>
                                <td class="p-2"><input type="number" name="it_personnel_quantity[]" value="<?= htmlspecialchars($_SESSION['form3']['it_personnel_quantity'][$idx] ?? '') ?>" required class="w-full px-3 py-1.5 border border-gray-200 rounded-md outline-none" min="0"></td>
                                <td class="p-2 text-center">
                                    <?php if($idx > 0): ?>
                                    <button type="button" onclick="this.closest('tr').remove()" class="text-red-400 hover:text-red-600 font-bold text-xl">×</button>
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
                    <h2 class="text-xl font-bold text-gray-800">10. แผนการดำเนินงาน <span class="text-red-500">*</span></h2>
                </div>
                <div class="px-2">
                    <label class="block text-sm font-semibold text-gray-700 mb-1">ระยะเวลาดำเนินการรวม <span class="text-red-500">*</span></label>
                    <input type="text" name="work_plan_duration" value="<?= getForm3Value('work_plan_duration') ?>" class="form-input-focus block w-full md:w-1/2 px-4 py-2.5 border border-gray-300 rounded-lg outline-none" placeholder="เช่น 1 ม.ค. 2568 - 30 เม.ย. 2568" required>
                </div>

                <div class="overflow-x-auto rounded-xl border border-gray-200 mt-4">
                    <table class="w-full text-xs text-left border-collapse">
                        <thead class="bg-slate-50 border-b border-gray-200">
                            <tr>
                                <th class="px-4 py-4 border-r border-gray-200 text-gray-700 w-1/3" rowspan="2">กิจกรรม (กรุณาเลือกช่วงเวลาอย่างน้อยกิจกรรมละ 1 เดือน)</th>
                                <th class="px-2 py-2 text-center text-gray-700 border-b border-gray-200" colspan="12">เดือนที่ดำเนินการ</th>
                                <th class="px-4 py-4 border-l border-gray-200 text-gray-700" rowspan="2">หมายเหตุ</th>
                            </tr>
                            <tr id="work-plan-month-headers" class="divide-x divide-gray-200"></tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 bg-white">
                            <?php
                            $activities = [
                                '1. ประชุมคณะกรรมการและกำหนดรายละเอียด',
                                '2. เสนอขออนุมัติโครงการ',
                                '3. กระบวนการจัดซื้อจัดจ้าง',
                                '4. ส่งมอบ/ติดตั้ง/ตรวจสอบระบบ',
                                '5. ประเมินผลและสรุปโครงการ'
                            ];
                            foreach ($activities as $idx => $name): 
                                $rowNum = $idx + 1; // ลำดับกิจกรรมสำหรับ name attribute
                            ?>
                                <tr class="hover:bg-blue-50/30 divide-x divide-gray-100 activity-row">
                                    <td class="px-4 py-3 font-medium text-gray-700"><?= $name ?></td>
                                    <?php for ($m = 1; $m <= 12; $m++): ?>
                                        <td class="p-1 text-center">
                                            <input type="checkbox" name="work_plan_months[<?= $rowNum ?>][]" value="<?= $m ?>" <?= isMonthChecked($rowNum, $m) ?> class="w-4 h-4 rounded text-blue-600 month-checkbox">
                                        </td>
                                    <?php endfor; ?>
                                    <td class="px-2 py-2">
                                        <input type="text" name="activity_note[]" value="<?= htmlspecialchars($_SESSION['form3']['activity_note'][$idx] ?? '') ?>" class="w-full border-none focus:ring-0 text-xs bg-transparent">
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </section>

            <div class="flex justify-between items-center pt-8 border-t border-gray-100">
                <a href="form2.php" class="text-gray-500 hover:text-gray-700 font-bold flex items-center gap-2 transition-colors">
                    ← ย้อนกลับ
                </a>
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-10 py-3 rounded-xl font-bold shadow-lg shadow-blue-200 transition-all hover:-translate-y-1 active:scale-95">
                    ถัดไป →
                </button>
            </div>
        </form>
    </div>

    <script>
        // สร้างหัวตารางเดือน 1-12
        const headersRow = document.getElementById('work-plan-month-headers');
        for (let i = 1; i <= 12; i++) {
            const th = document.createElement('th');
            th.className = "px-1 py-2 text-center text-[10px] text-gray-400 font-normal";
            th.innerText = i;
            headersRow.appendChild(th);
        }

        function toggleOtherProjectInput() {
            const container = document.getElementById("otherProjectInput");
            const otherRadio = document.querySelector('input[value="อื่น ๆ"]');
            const otherField = document.getElementById("other_project_detail");
            
            if(otherRadio.checked) {
                container.classList.remove('hidden');
                otherField.setAttribute('required', 'required');
            } else {
                container.classList.add('hidden');
                otherField.removeAttribute('required');
            }
        }

        function addStatusRow() {
            const tbody = document.getElementById('status_table_body');
            const row = document.createElement('tr');
            row.className = "divide-x divide-gray-100 hover:bg-gray-50 animate-fade-in";
            row.innerHTML = `
                <td class="p-2"><input type="text" name="status_item[]" required class="w-full px-3 py-1.5 border border-gray-200 rounded-md outline-none"></td>
                <td class="p-2"><input type="text" name="status_location[]" required class="w-full px-3 py-1.5 border border-gray-200 rounded-md outline-none"></td>
                <td class="p-2"><input type="text" name="status_year[]" required class="w-full px-3 py-1.5 border border-gray-200 rounded-md outline-none"></td>
                <td class="p-2 text-center"><button type="button" onclick="this.closest('tr').remove()" class="text-red-400 hover:text-red-600 font-bold text-xl">×</button></td>
            `;
            tbody.appendChild(row);
        }

        function addItPersonnelRow() {
            const tbody = document.getElementById('it_personnel_table_body');
            const row = document.createElement('tr');
            row.className = "divide-x divide-gray-100 hover:bg-gray-50 animate-fade-in";
            row.innerHTML = `
                <td class="p-2"><input type="text" name="it_personnel_position[]" required class="w-full px-3 py-1.5 border border-gray-200 rounded-md outline-none"></td>
                <td class="p-2"><input type="number" name="it_personnel_quantity[]" required class="w-full px-3 py-1.5 border border-gray-200 rounded-md outline-none" min="0"></td>
                <td class="p-2 text-center"><button type="button" onclick="this.closest('tr').remove()" class="text-red-400 hover:text-red-600 font-bold text-xl">×</button></td>
            `;
            tbody.appendChild(row);
        }

        // Validation: ต้องเลือกอย่างน้อย 1 เดือนต่อกิจกรรม
        document.getElementById('mainForm').addEventListener('submit', function(e) {
            const activityRows = document.querySelectorAll('.activity-row');
            let allActivitiesChecked = true;

            activityRows.forEach((row) => {
                const checkedMonths = row.querySelectorAll('.month-checkbox:checked');
                if (checkedMonths.length === 0) allActivitiesChecked = false;
            });

            if (!allActivitiesChecked) {
                e.preventDefault();
                alert("กรุณาเลือกช่วงเดือนที่ดำเนินกิจกรรมในข้อ 10 ให้ครบทุกหัวข้อกิจกรรม (อย่างน้อยกิจกรรมละ 1 เดือน)");
            }
        });
    </script>
</body>
</html>