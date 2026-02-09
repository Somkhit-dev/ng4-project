<?php
session_start();
require '../config.php';
ob_start();

// รวมข้อมูลจากทุกหน้า
$all_data = array_merge(
    $_SESSION['form1'] ?? [],
    $_SESSION['form2'] ?? [],
    $_SESSION['form3'] ?? [],
    $_SESSION['form4'] ?? [],
    $_SESSION['form5'] ?? [],
    $_POST
);

// ตรวจสอบการ login
if (!isset($_SESSION['user_id'])) {
    die("กรุณาเข้าสู่ระบบก่อน");
}
$user_id = $_SESSION['user_id'];

// ตรวจสอบคีย์จำเป็น
$required_keys = [
    'project_name',
    'department_name',
    'unit_name',
    'responsible_person_name',
    'responsible_person_position',
    'responsible_person_phone',
    'responsible_person_email',
    'funding_source',
    'other_funding_source_detail',
    'project_rationale',
    'project_objectives',
    'goal_quantitative',
    'goal_qualitative',
    'project_type',
    'budget_type'
];
foreach ($required_keys as $key) {
    if (!isset($all_data[$key])) {
        die("ขาดข้อมูล: $key");
    }
}
$responsible_person_fax = $all_data['responsible_person_fax'] ?? '';

// งบประมาณ
$budget_type = $all_data['budget_type'];
$single_year = $all_data['single_year'] ?? null;
$single_amount = isset($all_data['single_amount']) ? floatval($all_data['single_amount']) : null;
$single_ict = isset($all_data['single_ict']) ? floatval($all_data['single_ict']) : null;
$multi_range = $all_data['multi_range'] ?? null;
$multi_years = $all_data['multi_year'] ?? [];
$multi_amounts = $all_data['multi_amount'] ?? [];
$multi_icts = $all_data['multi_ict'] ?? [];

$budget_year = ($budget_type === 'single') ? intval($single_year) : null;
$budget_amount = ($budget_type === 'single') ? $single_amount : null;
$ict_budget_amount = ($budget_type === 'single') ? $single_ict : null;
$multi_range_bind = ($budget_type === 'multi') ? $multi_range : null;
$other_project_detail = $all_data['other_project_detail'] ?? '';


$stmt = $conn->prepare("INSERT INTO form_fields (
    project_name, department_name, unit_name,
    responsible_person_name, responsible_person_position,
    responsible_person_phone, responsible_person_fax, responsible_person_email,
    budget_year, budget_amount, ict_budget_amount,
    funding_source, other_funding_source_detail,
    project_rationale, project_objectives,
    goal_quantitative, goal_qualitative,
    project_type, other_project_detail,
    budget_type, multi_range,

    system_name, system_scope, system_concept,
    expected_benefits, project_approver,
    user_id
) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

// ตรวจสอบการ prepare
if (!$stmt) {
    die("❌ Prepare form_fields ผิดพลาด: " . $conn->error);
}


$stmt->bind_param(
    "ssssssssiddsssssssssssssssi",
    $all_data['project_name'],
    $all_data['department_name'],
    $all_data['unit_name'],
    $all_data['responsible_person_name'],
    $all_data['responsible_person_position'],
    $all_data['responsible_person_phone'],
    $responsible_person_fax,
    $all_data['responsible_person_email'],
    $budget_year,
    $budget_amount,
    $ict_budget_amount,
    $all_data['funding_source'],
    $all_data['other_funding_source_detail'],
    $all_data['project_rationale'],
    $all_data['project_objectives'],
    $all_data['goal_quantitative'],
    $all_data['goal_qualitative'],
    $all_data['project_type'],
    $other_project_detail,
    $budget_type,
    $multi_range_bind,

    $all_data['system_name'],
    $all_data['system_scope'],
    $all_data['system_concept'],
    $all_data['expected_benefits'],
    $all_data['project_approver'],
    $user_id
);

$success = $stmt->execute();
if (!$success) {
    die("บันทึกข้อมูลหลักไม่สำเร็จ: " . $stmt->error);
}

$form_id = $stmt->insert_id;
$stmt->close();



// บันทึก multi_year_budget (ถ้างบประมาณหลายปี)
if ($budget_type === 'multi' && !empty($multi_years)) {
    $stmt_multi = $conn->prepare("INSERT INTO multi_year_budget (form_id, budget_year, budget_amount, ict_budget_amount) VALUES (?, ?, ?, ?)");
    if (!$stmt_multi) {
        die("Prepare multi_year_budget ผิดพลาด: " . $conn->error);
    }
    foreach ($multi_years as $index => $year) {
        $year_trim = trim($year);
        if ($year_trim === '') continue;

        $amount = isset($multi_amounts[$index]) ? floatval($multi_amounts[$index]) : 0;
        $ict = isset($multi_icts[$index]) ? floatval($multi_icts[$index]) : 0;

        $stmt_multi->bind_param("isdd", $form_id, $year_trim, $amount, $ict);
        $stmt_multi->execute();
    }
    $stmt_multi->close();
}

// บันทึก status_items
$status_items = $all_data['status_item'] ?? [];
$status_locations = $all_data['status_location'] ?? [];
$status_years = $all_data['status_year'] ?? [];

if (!empty($status_items)) {
    $stmt_status = $conn->prepare("INSERT INTO status_items (form_id, item_name, location, install_year) VALUES (?, ?, ?, ?)");
    if (!$stmt_status) {
        die("Prepare status_items ผิดพลาด: " . $conn->error);
    }
    foreach ($status_items as $index => $item) {
        $item_name = trim($item);
        $location = trim($status_locations[$index] ?? '');
        $year = trim($status_years[$index] ?? '');
        if ($item_name === '' && $location === '' && $year === '') continue;
        $stmt_status->bind_param("isss", $form_id, $item_name, $location, $year);
        $stmt_status->execute();
    }
    $stmt_status->close();
}

// การอัปโหลดรูปภาพ
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['image_file'])) {
    $file = $_FILES['image_file'];

    if ($file['error'] === UPLOAD_ERR_OK) {
        $uploadDir = 'uploaded_files/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        $fileExt = pathinfo($file['name'], PATHINFO_EXTENSION);
        $fileName = uniqid('img_', true) . '.' . $fileExt;
        $uploadPath = $uploadDir . $fileName;

        if (move_uploaded_file($file['tmp_name'], $uploadPath)) {
            // บันทึก image URL ลงฐานข้อมูลด้วย form_id ที่เพิ่ง insert มา
            $stmt = $conn->prepare("INSERT INTO uploaded_images (form_id, image_url) VALUES (?, ?)");
            if ($stmt === false) {
                die("Prepare failed: " . $conn->error);
            }

            // ใช้ $form_id ที่ได้จาก insert_id ด้านบน
            $stmt->bind_param("is", $form_id, $uploadPath);
            if ($stmt->execute()) {
                echo "อัปโหลดและบันทึกลงฐานข้อมูลสำเร็จ!";
            } else {
                echo "Execute failed: " . $stmt->error;
            }
            $stmt->close();
        } else {
            echo "ไม่สามารถย้ายไฟล์ได้";
        }
    } else {
        echo "เกิดข้อผิดพลาดในการอัปโหลด: " . $file['error'];
    }
} else {
    echo "ไม่มีไฟล์ส่งมาจากฟอร์ม";
}


// บันทึกข้อมูล it_personnel
$it_positions = $all_data['it_personnel_position'] ?? [];
$it_quantities = $all_data['it_personnel_quantity'] ?? [];

if (!empty($it_positions)) {
    $stmt_it = $conn->prepare("INSERT INTO it_personnel (form_id, position_name, quantity) VALUES (?, ?, ?)");
    if (!$stmt_it) {
        die("Prepare it_personnel ผิดพลาด: " . $conn->error);
    }

    foreach ($it_positions as $index => $position) {
        $pos = trim($position);
        $qty = isset($it_quantities[$index]) ? intval($it_quantities[$index]) : 0;
        if ($pos === '') continue;
        $stmt_it->bind_param("isi", $form_id, $pos, $qty);
        $stmt_it->execute();
    }
    $stmt_it->close();
}

// บันทึกข้อมูล work_plan
$work_plan_duration = $all_data['work_plan_duration'] ?? '';
$work_plan_months = $all_data['work_plan_months'] ?? [];

if (!empty($work_plan_months)) {
    $stmt_plan = $conn->prepare("INSERT INTO work_plan (form_id, activity_no, month_no) VALUES (?, ?, ?)");
    if (!$stmt_plan) {
        die("Prepare work_plan ผิดพลาด: " . $conn->error);
    }

    foreach ($work_plan_months as $activity_no => $months) {
        foreach ($months as $month_no) {
            $stmt_plan->bind_param("iii", $form_id, $activity_no, $month_no);
            $stmt_plan->execute();
        }
    }
    $stmt_plan->close();

    // เก็บ work_plan_duration แยกไว้
    $stmt_duration = $conn->prepare("INSERT INTO work_plan_duration (form_id, duration_text) VALUES (?, ?)");
    $stmt_duration->bind_param("is", $form_id, $work_plan_duration);
    $stmt_duration->execute();
    $stmt_duration->close();
}

// บันทึกข้อมูลความสอดคล้องกับนโยบาย (policy alignment)
// รับค่าจากฟอร์ม
$policy_options = $all_data['policy_options'] ?? [];
$other_policy_detail = $all_data['other_policy_detail'] ?? null;

if (!empty($policy_options)) {
    $stmt_policy = $conn->prepare("INSERT INTO policy_alignment (form_id, policy_key, other_detail) VALUES (?, ?, ?)");
    if (!$stmt_policy) {
        die("Prepare policy_alignment ผิดพลาด: " . $conn->error);
    }

    foreach ($policy_options as $policy_key) {
        $detail = ($policy_key === 'other') ? $other_policy_detail : null;

        $stmt_policy->bind_param("iss", $form_id, $policy_key, $detail);
        $stmt_policy->execute();
    }

    $stmt_policy->close();
}



// บันทึกข้อมูล รายละเอียดอุปกรณ์/ระบบที่ขอจัดหา
$item_names = $all_data['item_name'] ?? [];
$item_quantities = $all_data['item_quantity'] ?? [];
$unit_prices = $all_data['unit_price'] ?? [];
$total_prices = $all_data['total_price'] ?? [];
$item_specs = $all_data['item_specification'] ?? [];
$item_details = $all_data['item_additional_detail'] ?? [];
$ict_criterias = $all_data['ict_criteria'] ?? [];
$ict_details = $all_data['ict_standard_detail'] ?? [];

if (!empty($item_names)) {
    $stmt_items = $conn->prepare("INSERT INTO procurement_items (
            form_id, item_name, item_quantity, unit_price, total_price, item_specification,
            item_additional_detail, ict_criteria, ict_standard_detail
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");

    if (!$stmt_items) {
        die("Prepare procurement_items ผิดพลาด: " . $conn->error);
    }

    for ($i = 0; $i < count($item_names); $i++) {
        $criteria = '';
        if (isset($ict_criterias[$i])) {
            if (is_array($ict_criterias[$i])) {
                $criteria = implode(',', $ict_criterias[$i]);
            } else {
                $criteria = $ict_criterias[$i];
            }
        }
        $ict_detail = $ict_details[$i] ?? null;

        $stmt_items->bind_param(
            "isiddssss",
            $form_id,
            $item_names[$i],
            $item_quantities[$i],
            $unit_prices[$i],
            $total_prices[$i],
            $item_specs[$i],
            $item_details[$i],
            $criteria,
            $ict_detail
        );
        $stmt_items->execute();
    }

    $stmt_items->close();
}

// บันทึกงบรวม
$total_budget = $all_data['total_budget'] ?? 0;
$stmt_total = $conn->prepare("UPDATE form_fields SET total_budget = ? WHERE id = ?");
if (!$stmt_total) {
    die("Prepare update total_budget ผิดพลาด: " . $conn->error);
}
$stmt_total->bind_param("di", $total_budget, $form_id);
$stmt_total->execute();
$stmt_total->close();


// --- รายการค่าใช้จ่ายในการพัฒนาระบบงาน ---
$cost_items = $all_data['cost_item'] ?? [];
$cost_durations = $all_data['cost_duration'] ?? [];
$cost_rates = $all_data['cost_rate'] ?? [];
$cost_amounts = $all_data['cost_amount'] ?? [];
$total_cost = $all_data['total_cost'] ?? 0;

// บันทึกรายการค่าใช้จ่ายย่อย
if (!empty($cost_items) && is_array($cost_items)) {
    $stmt_cost = $conn->prepare("INSERT INTO system_cost_items (form_id, cost_item, cost_duration, cost_rate, cost_amount) VALUES (?, ?, ?, ?, ?)");
    foreach ($cost_items as $i => $item) {
        if (trim($item) === '') continue;
        $duration = isset($cost_durations[$i]) ? (int)$cost_durations[$i] : 0;
        $rate = isset($cost_rates[$i]) ? (float)$cost_rates[$i] : 0;
        $amount = isset($cost_amounts[$i]) ? (int)$cost_amounts[$i] : 0;
        $stmt_cost->bind_param("isddi", $form_id, $item, $duration, $rate, $amount);
        $stmt_cost->execute();
    }
}

// บันทึกค่าใช้จ่ายรวม ลงใน form_fields
$stmt_update_total = $conn->prepare("UPDATE form_fields SET total_cost = ? WHERE id = ?");
$stmt_update_total->bind_param("di", $total_cost, $form_id);
$stmt_update_total->execute();

// --- วิธีการจัดหา ---
$procurement_methods = $all_data['procurement_methods'] ?? [];
$procurement_method_other_detail = $all_data['procurement_method_other_detail'] ?? '';

if (!empty($procurement_methods)) {
    $stmt_methods = $conn->prepare("INSERT INTO methods_of_procurement (form_id, method, other_detail) VALUES (?, ?, ?)");
    if (!$stmt_methods) {
        die("Prepare methods_of_procurement ผิดพลาด: " . $conn->error);
    }

    foreach ($procurement_methods as $method) {
        $method_trim = trim($method);
        $other_detail = ($method_trim === 'อื่น ๆ') ? $procurement_method_other_detail : null;
        $stmt_methods->bind_param("iss", $form_id, $method_trim, $other_detail);
        $stmt_methods->execute();
    }
    $stmt_methods->close();
}

// --- สถานที่ติดตั้ง ---
$table_col1 = $all_data['table_col1'] ?? [];
$table_col2 = $all_data['table_col2'] ?? [];
$table_col3 = $all_data['table_col3'] ?? [];

$stmt_place = $conn->prepare("INSERT INTO installation_places (form_id, item, quantity, location) VALUES (?, ?, ?, ?)");
if (!$stmt_place) {
    die("Prepare installation_places ผิดพลาด: " . $conn->error);
}

foreach ($table_col1 as $index => $item) {
    $item = trim($item);
    $quantity = $table_col2[$index] ?? '';
    $location = $table_col3[$index] ?? '';

    if ($item !== '' || $quantity !== '' || $location !== '') { 
        $stmt_place->bind_param("isss", $form_id, $item, $quantity, $location);
        $stmt_place->execute();
    }
}

$stmt_place->close();



// สำเร็จ
unset($_SESSION['form1'], $_SESSION['form2'], $_SESSION['form3'], $_SESSION['form4'], $_SESSION['form5']);

$redirect_to = "../user_dashboard.php?success=1";

if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin') {
    $redirect_to = "../admin_form.php?success=1";
}

ob_end_clean();
header("Location: " . $redirect_to);
exit;