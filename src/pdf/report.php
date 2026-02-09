<?php
ob_start(); // เริ่มเก็บบัฟเฟอร์

// เรียก autoload ของ Composer
require __DIR__ . '/../vendor/autoload.php';

// สร้างอ็อบเจ็กต์ TCPDF ได้เลย
$pdf = new TCPDF();


// เรียกใช้งานไฟล์ตั้งค่าฐานข้อมูล
require_once('../config.php');

// เชื่อมต่อฐานข้อมูล
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$conn->set_charset("utf8");

// รับค่า form_id จาก URL
$form_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($form_id <= 0) {
    die("Invalid form ID");
}

// เตรียมและ execute SQL
$sql = "SELECT * FROM form_fields WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $form_id);
$stmt->execute();
$result = $stmt->get_result();

// ตรวจสอบผลลัพธ์
if ($result->num_rows === 0) {
    die("ไม่พบข้อมูลล่าสุดในฐานข้อมูล (No recent data found in the database).");
}


// ดึงข้อมูล
$data_from_db = $result->fetch_assoc();

// ดึงข้อมูลจากตาราง multi_year_budget ที่สัมพันธ์กับ form_fields
$multi_year_rows = [];
$form_id = $data_from_db['id']; // ใช้ ID นี้สำหรับดึงข้อมูลหลายปี
$sql_multi = "SELECT * FROM multi_year_budget WHERE form_id = ?";
$stmt_multi = $conn->prepare($sql_multi);
$stmt_multi->bind_param("i", $form_id);
$stmt_multi->execute();
$result_multi = $stmt_multi->get_result();

while ($row = $result_multi->fetch_assoc()) {
    $multi_year_rows[] = $row;
}
// ดึงข้อมูลภาพจากตาราง uploaded_images ที่สัมพันธ์กับ form_fields
$image_path = '';
$sql_img = "SELECT image_url FROM uploaded_images WHERE form_id = ? LIMIT 1";
$stmt_img = $conn->prepare($sql_img);

if ($stmt_img === false) {
    die("Prepare failed: " . $conn->error);
}

$stmt_img->bind_param("i", $form_id);
$stmt_img->execute();
$result_img = $stmt_img->get_result();

if ($row_img = $result_img->fetch_assoc()) {
    $image_path = $row_img['image_url'];  // ใช้ชื่อคอลัมน์จริง
}


// ดึงข้อมูลจากตาราง status_items ที่สัมพันธ์กับ form_fields
$status_items = [];
$sql_status = "SELECT item_name, location, install_year FROM status_items WHERE form_id = ?";
$stmt_status = $conn->prepare($sql_status);
$stmt_status->bind_param("i", $form_id);
$stmt_status->execute();
$result_status = $stmt_status->get_result();

while ($row = $result_status->fetch_assoc()) {
    $status_items[] = $row;
}

// ดึงภาพจาก uploaded_images
$imagePath = ''; // ดึงจากฐานข้อมูล
$stmt = $conn->prepare("SELECT image_url FROM uploaded_images WHERE form_id = ?");
$stmt->bind_param("i", $form_id);
$stmt->execute();
$stmt->bind_result($imagePath);
$stmt->fetch();
$stmt->close();

// สร้าง path เต็มสำหรับ TCPDF (ต้องใช้ path จริงบนเครื่อง)
$imageFullPath = realpath(__DIR__ . '/../form/' . $imagePath);

// ตรวจสอบว่า path ถูกต้อง
if ($imageFullPath && file_exists($imageFullPath)) {
    $imageHTML = '<img src="' . $imageFullPath . '" width="300">';
} else {
    $imageHTML = '<p>ไม่พบรูปภาพ: ' . $imagePath . '</p>'; // Debug ได้เลยตรงนี้
}


// ดึงข้อมูลจากตาราง it_personnel ที่สัมพันธ์กับ form_fields
$it_personnel = [];
$sql_it = "SELECT position_name, quantity FROM it_personnel WHERE form_id = ?";
$stmt_it = $conn->prepare($sql_it);
$stmt_it->bind_param("i", $form_id);
$stmt_it->execute();
$result_it = $stmt_it->get_result();

while ($row = $result_it->fetch_assoc()) {
    $it_personnel[] = $row;
}

// ดึงข้อมูลจากตาราง work_plan_duration ที่สัมพันธ์กับ form_fields
$work_plan_duration = '';
$sql_duration = "SELECT duration_text FROM work_plan_duration WHERE form_id = ?";
$stmt_duration = $conn->prepare($sql_duration);
$stmt_duration->bind_param("i", $form_id);
$stmt_duration->execute();
$result_duration = $stmt_duration->get_result();

if ($row = $result_duration->fetch_assoc()) {
    $work_plan_duration = $row['duration_text'];
}


// ดึงข้อมูล work_plan (กิจกรรม 5 แถว x 12 เดือน)
$work_plan_data = [];
$sql_work_plan = "SELECT activity_no, month_no FROM work_plan WHERE form_id = ?";
$stmt_wp = $conn->prepare($sql_work_plan);
$stmt_wp->bind_param("i", $form_id);
$stmt_wp->execute();
$result_wp = $stmt_wp->get_result();

while ($row = $result_wp->fetch_assoc()) {
    $act = $row['activity_no'];
    $mon = $row['month_no'];
    $work_plan_data[$act][$mon] = true;
}

// ดึงข้อมูล policy_alignment ที่สัมพันธ์กับ form_fields
$policy_keys = []; // เตรียม array
$other_text = '';

$stmt = $conn->prepare("SELECT policy_key, other_detail FROM policy_alignment WHERE form_id = ?");
$stmt->bind_param("i", $form_id);
$stmt->execute();
$result = $stmt->get_result();

while ($row = $result->fetch_assoc()) {
    $policy_keys[] = $row['policy_key'];
    if ($row['policy_key'] == 'other' && !empty($row['other_detail'])) {
        $other_text = ' ระบุ: ' . htmlspecialchars($row['other_detail']);
    }
}

// ดึงข้อมูลจากตาราง procurement_items ที่สัมพันธ์กับ form_fields
$sql_procurement = "SELECT 
    item_name, 
    item_quantity, 
    unit_price, 
    total_price, 
    item_specification, 
    item_additional_detail, 
    ict_criteria, 
    ict_standard_detail
FROM procurement_items
WHERE form_id = ?";

$stmt_procurement = $conn->prepare($sql_procurement);

if (!$stmt_procurement) {
    die("Prepare failed: (" . $conn->errno . ") " . $conn->error);
}

$stmt_procurement->bind_param("i", $form_id);
$stmt_procurement->execute();

$result_procurement = $stmt_procurement->get_result();

$procurement_items = [];
while ($row = $result_procurement->fetch_assoc()) {
    $procurement_items[] = $row;
}

$stmt_procurement->close();

// ดึงข้อมูลจากตาราง system_cost_items ที่สัมพันธ์กับ form_fields
// ดึงรายการค่าใช้จ่ายแยกแถว
$sql_system_cost = "SELECT cost_item, cost_duration, cost_rate, cost_amount
FROM system_cost_items 
WHERE form_id = ?";

$stmt_system_cost = $conn->prepare($sql_system_cost);
if (!$stmt_system_cost) {
    die("Prepare failed: (" . $conn->errno . ") " . $conn->error);
}
$stmt_system_cost->bind_param("i", $form_id);
$stmt_system_cost->execute();
$result_system_cost = $stmt_system_cost->get_result();

$system_cost_items = [];
while ($row = $result_system_cost->fetch_assoc()) {
    $system_cost_items[] = $row;
}
$stmt_system_cost->close();

// ดึง total_cost จากตารางหลัก form_fields
$sql_total = "SELECT total_cost FROM form_fields WHERE id = ?";
$stmt_total = $conn->prepare($sql_total);
$stmt_total->bind_param("i", $form_id);
$stmt_total->execute();
$stmt_total->bind_result($total_cost);
$stmt_total->fetch();
$stmt_total->close();

// --- ดึงข้อมูลวิธีการจัดหา ---
$sql_methods = "SELECT method, other_detail 
                FROM methods_of_procurement 
                WHERE form_id = ?";
$stmt_methods = $conn->prepare($sql_methods);
$stmt_methods->bind_param("i", $form_id);
$stmt_methods->execute();
$result_methods = $stmt_methods->get_result();

$methods = [];
$otherDetail = '';

while ($row = $result_methods->fetch_assoc()) {
    $methods[] = $row['method'];
    if ($row['method'] === 'อื่น ๆ' && !empty($row['other_detail'])) {
        $otherDetail = $row['other_detail'];
    }
}
$stmt_methods->close();

// --- ดึงข้อมูลสถานที่ติดตั้ง ---
$sql_installation = "SELECT item, quantity, location FROM installation_places WHERE form_id = ?";
$stmt_installation = $conn->prepare($sql_installation);
$stmt_installation->bind_param("i", $form_id);
$stmt_installation->execute();
$result_installation = $stmt_installation->get_result();
while ($row = $result_installation->fetch_assoc()) {
    $installation_items[] = $row;
}
$stmt_installation->close();


$conn->close();


// --- ส่วนการจัดการข้อมูล ---
// **แก้ไข:** กำหนดค่าเริ่มต้นสำหรับทุก field ที่คาดว่าจะใช้งาน เพื่อป้องกันข้อผิดพลาด "Undefined array key"
// ทำให้สคริปต์ทำงานได้ отказоустойчивый (robust) มากขึ้น แม้ว่าบางคอลัมน์จะไม่มีในฐานข้อมูล
$defaults = [
    'project_name'                => 'N/A',
    'department_name'             => 'มหาวิทยาลัยเทคโนโลยีราชมงคลอีสาน', // ค่าเริ่มต้นที่กำหนดไว้ล่วงหน้า
    'unit_name'                   => 'N/A', // ✅ เพิ่มบรรทัดนี้
    'agency_name'                 => 'N/A',
    'responsible_person_name'     => 'N/A',
    'responsible_person_position' => 'N/A',
    'responsible_person_phone'    => 'N/A',
    'responsible_person_fax'      => 'N/A',
    'responsible_person_email'    => 'N/A',
    'budget_year'                 => 'N/A',
    'budget_amount'               => 'N/A',
    'ict_budget_amount'           => 'N/A',
    'multi_year'                  => 'N/A',
    'multi_amount'                => 'N/A',
    'multi_ict'                   => 'N/A',
    'project_rationale'           => 'ไม่มีข้อมูล',
    'project_objectives'          => 'ไม่มีข้อมูล',
    'goal_quantitative'           => 'ไม่มีข้อมูล',
    'goal_qualitative'            => 'ไม่มีข้อมูล',
    'project_timeline'            => 'N/A',
    'budget_source'               => 'N/A',
    'total_budget'                => 0,
    'hardware_specs'              => 'ไม่มีข้อมูล',
    'proposer_name'               => '(........................................)',
    'approver_name'               => '(........................................)',
];

// รวมข้อมูลที่ดึงมาจากฐานข้อมูลเข้ากับค่าเริ่มต้น
// ค่าจาก $data_from_db จะเขียนทับค่าเริ่มต้นหากมีอยู่
$data = array_merge($defaults, $data_from_db);


// --- ส่วนการสร้างไฟล์ PDF ---
// ขยายคลาส TCPDF เพื่อสร้าง Header และ Footer แบบกำหนดเอง
class MYPDF extends TCPDF
{
    protected $logoPath;

    public function __construct($logoPath, $orientation = 'P', $unit = 'mm', $format = 'A4', $unicode = true, $encoding = 'UTF-8', $diskcache = false, $pdfa = false)
    {
        parent::__construct($orientation, $unit, $format, $unicode, $encoding, $diskcache, $pdfa);
        $this->logoPath = $logoPath;
    }

    public function Header()
    {
        $this->SetLineWidth(0.3);

        // ขนาดกระดาษ A4 แนวนอน (ขอบเริ่มที่ 15 mm จากซ้าย)
        $pageWidth = 210;
        $margin = 15;

        // ขนาดของกรอบ header รวม
        $x = $margin;
        $y = 10;
        $w = $pageWidth - ($margin * 2); // 180mm
        $h = 25;

        // วาดกรอบใหญ่
        $this->Rect($x, $y, $w, $h, 'D');

        // แบ่งกรอบเป็น 3 ส่วน: โลโก้ | ข้อความกลาง | เลขหน้า
        $col1Width = 30;  // โลโก้
        $col3Width = 20;  // เลขหน้า
        $col2Width = $w - $col1Width - $col3Width; // กลาง

        // กรอบช่องซ้าย (โลโก้)
        $this->Rect($x, $y, $col1Width, $h, 'D');

        // กรอบช่องกลาง (ข้อความ)
        $this->Rect($x + $col1Width, $y, $col2Width, $h, 'D');

        // กรอบช่องขวา (เลขหน้า)
        $this->Rect($x + $col1Width + $col2Width, $y, $col3Width, $h, 'D');

        // ---------- วางโลโก้ ----------
        $this->Image($this->logoPath, $x + 5, $y + 2.5, 20, 20, '', '', '', false, 300, '', false, false, 0, false, false, false);

        // ---------- ข้อความกลาง ----------
        $this->SetFont('thsarabunnew', '', 16);
        $this->SetXY($x + $col1Width, $y + 3);
        $txt = "แบบฟอร์มการจัดหาระบบคอมพิวเตอร์และอุปกรณ์ประกอบ\nของ กระทรวงการอุดมศึกษา วิทยาศาสตร์ วิจัยและนวัตกรรม\nที่มีมูลค่าต่ำกว่า 100 ล้านบาท";
        $this->MultiCell($col2Width, 7, $txt, 0, 'C', false, 1);

        // ---------- เลขหน้า ----------
        $page_no = $this->getAliasNumPage();
        $total_pages = $this->getAliasNbPages();

        // ตั้งตำแหน่งเริ่มต้นสำหรับเลขหน้า
        $x = 180; // แนวนอน
        $y = 12;  // แนวตั้ง

        $this->SetFont('thsarabunnew', '', 14);

        // แสดงคำว่า "หน้า" บรรทัดบน
        $this->SetXY($x, $y);
        $this->Cell(10, 18, "หน้า", 0, 2, 'C'); // 2 = ขึ้นบรรทัดใหม่หลังแสดงผล

        // แสดงเลขหน้า/จำนวน บรรทัดล่าง
        $this->SetXY($x, $y + 5); // ขยับลงมา
        $this->Cell(28, 18, "$page_no / $total_pages", 0, 0, 'C');
    }



    public function Footer()
    {
        $this->SetY(-15);
        $this->SetFont('thsarabunnew', 'I', 8);
    }
}

$imagePath = realpath('../img/Logo.jpg');
if (!file_exists($imagePath)) {
    die("Logo not found: " . $imagePath);
}

$pdf = new MYPDF($imagePath);

// ตั้งค่าเอกสาร
$pdf->SetCreator('RMUTI MIS');
$pdf->SetAuthor($data['responsible_person_name']);
$pdf->SetTitle('แบบฟอร์มจัดหาคอมพิวเตอร์ - ' . $data['project_name']);
$pdf->SetSubject('แบบฟอร์มเสนอโครงการจัดหาระบบคอมพิวเตอร์');

// ตั้งค่าระยะขอบ
$pdf->SetMargins(15, 38, 15);
$pdf->SetHeaderMargin(10);
$pdf->SetFooterMargin(15);
$pdf->SetAutoPageBreak(TRUE, 15);

// โหลดฟอนต์ THSarabunNew ถ้ายังไม่ได้เพิ่ม
$fontfile        = '../tcpdf/fonts/THSarabunNew.ttf';
$fontboldfile    = '../tcpdf/fonts/THSarabunNew-Bold.ttf';
$fontitalic      = '../tcpdf/fonts/THSarabunNew-Italic.ttf';
$fontbolditalic  = '../tcpdf/fonts/THSarabunNew-BoldItalic.ttf';

$fontname = 'thsarabunnew';
if (!file_exists(TCPDF_FONTS::getFontFullPath($fontname))) {
    TCPDF_FONTS::addTTFfont($fontfile, 'TrueTypeUnicode', '', 32);
    TCPDF_FONTS::addTTFfont($fontboldfile, 'TrueTypeUnicode', '', 32);
    TCPDF_FONTS::addTTFfont($fontitalic, 'TrueTypeUnicode', '', 32);
    TCPDF_FONTS::addTTFfont($fontbolditalic, 'TrueTypeUnicode', '', 32);
}

$pdf->SetFont($fontname, '', 14, '', true);


function generateMultiYearRows($rows)
{
    $html = '';
    $total_budget = 0;
    $total_ict = 0;

    foreach ($rows as $row) {
        // เตรียมค่าโดยเช็คว่าเป็น 0 หรือ null ให้เป็นช่องว่าง
        $budget_amount = ($row['budget_amount'] > 0) ? number_format($row['budget_amount'], 2) : '';
        $ict_budget_amount = ($row['ict_budget_amount'] > 0) ? number_format($row['ict_budget_amount'], 2) : '';

        $html .= '
        <tr>
            <td style="border: 1px solid black; text-align: center;">พ.ศ. ' . htmlspecialchars($row['budget_year']) . '</td>
            <td style="border: 1px solid black; text-align: center;">' . $budget_amount . ' บาท</td>
            <td style="border: 1px solid black; text-align: center;">' . $ict_budget_amount . ' บาท</td>
        </tr>';

        // รวมเฉพาะถ้ามีค่าจริง
        $total_budget += ($row['budget_amount'] > 0) ? $row['budget_amount'] : 0;
        $total_ict += ($row['ict_budget_amount'] > 0) ? $row['ict_budget_amount'] : 0;
    }

    // แสดงผลรวม (ถ้าไม่มีข้อมูลเลย ให้ช่องว่าง)
    $total_budget_display = ($total_budget > 0) ? number_format($total_budget, 2) : '';
    $total_ict_display = ($total_ict > 0) ? number_format($total_ict, 2) : '';

    $html .= '
    <tr>
        <td style="border: 1px solid black; text-align: center; font-weight: bold;">รวมวงเงินงบประมาณทั้งสิ้น</td>
        <td style="border: 1px solid black; text-align: center; font-weight: bold;">' . $total_budget_display . ' บาท</td>
        <td style="border: 1px solid black; text-align: center; font-weight: bold;">' . $total_ict_display . ' บาท</td>
    </tr>';

    return $html;
}

function generateStatusItemsTable($items)
{
    if (empty($items)) {
        return '<tr><td colspan="3" style="border: 1px solid black; text-align: center;">ไม่มีข้อมูล</td></tr>';
    }

    $html = '';
    foreach ($items as $item) {
        $html .= '
        <tr>
            <td style="width: 45%; border: 1px solid black; text-align: left;">' . htmlspecialchars($item['item_name']) . '</td>
            <td style="width: 30%; border: 1px solid black; text-align: left;">' . htmlspecialchars($item['location']) . '</td>
            <td style="width: 25%; border: 1px solid black; text-align: left;">พ.ศ. ' . htmlspecialchars($item['install_year']) . '</td>
        </tr>';
    }
    return $html;
}




function generateItPersonnelTable($items)
{
    if (empty($items)) {
        return '<tr><td colspan="2" style="border: 1px solid black; text-align: center;">ไม่มีข้อมูล</td></tr>';
    }

    $html = '';
    foreach ($items as $item) {
        $html .= '
        <tr>
            <td style="width: 70%; border: 1px solid black; text-align: center; text-align: left;">' . htmlspecialchars($item['position_name']) . '</td>
            <td style="width: 30%; border: 1px solid black; text-align: center; text-align: left;">' . htmlspecialchars($item['quantity']) . ' คน</td>
        </tr>';
    }
    return $html;
}

function generateWorkPlanTable($data)
{
    $activities = [
        1 => '1. ประชุมคณะกรรมการและกำหนดรายละเอียดครุภัณฑ์',
        2 => '2. ตรวจสอบรายละเอียดและดำเนินการเสนอขออนุมัติ',
        3 => '3. ระบบการจัดซื้อจัดจ้าง',
        4 => '4. ส่งมอบครุภัณฑ์/ติดตั้ง/ตรวจสอบการใช้งานของระบบ',
        5 => '5. ประเมินผล ตรวจสอบการรับประกันสัญญา และสรุปผลการดำเนินงาน',
    ];

    // ปรับเปอร์เซ็นต์ให้รวมกัน = 100%
    $activityWidth = 48;     // ช่องกิจกรรม
    $monthWidth = 3.5;       // ช่องเดือน 12 ช่อง
    $noteWidth = 10;          // ช่องหมายเหตุ
    $html = '<table border="1" cellpadding="2" cellspacing="0" style="width: 100%; font-size: 14px;">
        <thead>
            <tr>
                <th rowspan="2" style="text-align: center; width: ' . $activityWidth . '%;">กิจกรรม</th>
                <th colspan="" style="text-align: center; width: 42%;">กำหนดดำเนินการ (เดือน)</th>
                <th rowspan="2" style="text-align: center; width: ' . $noteWidth . '%;">หมายเหตุ</th>
            </tr>
            <tr>';

    // ช่องเดือน
    for ($i = 1; $i <= 12; $i++) {
        $html .= '<th style="text-align: center; width: ' . $monthWidth . '%;">' . $i . '</th>';
    }

    $html .= '</tr></thead><tbody>';

    foreach ($activities as $no => $name) {
        $html .= '<tr>';
        $html .= '<td style="width: ' . $activityWidth . '%;">' . htmlspecialchars($name) . '</td>';

        for ($m = 1; $m <= 12; $m++) {
            $style = isset($data[$no][$m]) ? 'background-color:rgb(66, 66, 66);' : '';
            $html .= '<td style="text-align: center; width: ' . $monthWidth . '%; ' . $style . '"></td>';
        }

        $html .= '<td style="width: ' . $noteWidth . '%;"></td>';
        $html .= '</tr>';
    }

    $html .= '</tbody></table>';
    return $html;
}

function generateProcurementItemsTable($items, $total_budget = 0)
{
    if (empty($items)) {
        return '
        <tr>
            <td colspan="6" style="border:1px solid black; text-align:center; font-style: italic;">ไม่มีข้อมูลรายการอุปกรณ์</td>
        </tr>';
    }

    $html = '';
    $count = 1;

    foreach ($items as $item) {
        // แปลงค่า ICT criteria ให้อ่านง่าย
        $criteriaMap = [
            'no_criteria'   => 'ไม่มีรายการตามเกณฑ์',
            'compliant'     => 'เป็นไปตามเกณฑ์',
            'not_compliant' => 'ไม่เป็นไปตามเกณฑ์'
        ];

        $criteria_raw = explode(',', $item['ict_criteria']);

        // สร้าง checkbox HTML ให้ครบทุกตัวเลือก
        $criteria_list = array_map(function ($key) use ($criteriaMap, $criteria_raw, $item) {
            $checked = in_array($key, $criteria_raw) ? "&#9745;" : "&#9744;";
            $checkedHTML = '<span style="font-family: dejavusans;">' . $checked . '</span>';
            $label = $criteriaMap[$key] ?? htmlspecialchars($key);
            if ($key === 'not_compliant' && in_array('not_compliant', $criteria_raw) && !empty($item['ict_standard_detail'])) {
                $label .= ' : ' . htmlspecialchars($item['ict_standard_detail']);
            }
            return $checkedHTML . ' ' . $label;
        }, array_keys($criteriaMap));

        $ict_text = implode('<br>', $criteria_list);

        // แถวที่ 1: ข้อมูลหลัก
        $html .= '<tr>';
        $html .= '<td style="width:5%; border:1px solid black; text-align:center; font-weight:bold;">' . $count . '.</td>';
        $html .= '<td style="width:28%; border:1px solid black; text-align:left;">' . htmlspecialchars($item['item_name']) . '</td>';
        $html .= '<td style="width:15%; border:1px solid black; text-align:center;">' . number_format($item['item_quantity']) . ' หน่วย</td>';
        $html .= '<td style="width:15%; border:1px solid black; text-align:right;">' . number_format((float)$item['unit_price'], 2) . '</td>';
        $html .= '<td style="width:15%; border:1px solid black; text-align:right;">' . number_format((float)$item['total_price'], 2) . '</td>';
        $html .= '<td style="width:22%; border:1px solid black; text-align:left;" rowspan="2">' . $ict_text . '</td>';
        $html .= '</tr>';

        // แถวที่ 2: รายละเอียดคุณลักษณะ + รายละเอียดอื่นๆ
        $html .= '<tr>';
        $html .= '<td colspan="5" style="border:1px solid black; text-align:left;">
            <strong>1. รายละเอียดคุณลักษณะเฉพาะ ครุภัณฑ์ที่เสนอจะต้องมีคุณสมบัติเทียบเท่าหรือดีกว่า </strong><br>' .
            indentEveryLine($item['item_specification']) . '<br><br>
            <strong>2. รายละเอียดอื่นๆ</strong><br>' .
            indentEveryLine($item['item_additional_detail']) . '
        </td>';
        $html .= '</tr>';

        $count++;
    }

    // แถวรวมงบประมาณทั้งหมดจาก total_budget
    $html .= '<tr>
        <td colspan="5" style="border:1px solid black; text-align:right; font-weight:bold;">รวมทั้งสิ้น</td>
        <td style="border:1px solid black; text-align:right; font-weight:bold;">' . number_format($total_budget, 2) . ' บาท</td>
        <td style="border:1px solid black;"></td>
    </tr>';

    return $html;
}

function generateSystemCostItemsTable($items, $total_cost)
{
    if (empty($items)) {
        return '<tr>
            <td colspan="5" style="border:1px solid black; text-align:center; font-style:italic;">ไม่มีรายการค่าใช้จ่าย</td>
        </tr>';
    }

    $html = '';

    foreach ($items as $item) {
        $html .= '<tr>';
        $html .= '<td style="width:40%; border:1px solid black; text-align:left;">' . htmlspecialchars($item['cost_item']) . '</td>';
        $html .= '<td style="width:15%; border:1px solid black; text-align:center;">' . htmlspecialchars($item['cost_duration']) . '</td>';
        $html .= '<td style="width:15%; border:1px solid black; text-align:right;">' . number_format((float)$item['cost_rate'], 2) . '</td>';
        $html .= '<td style="width:15%; border:1px solid black; text-align:center;">' . htmlspecialchars($item['cost_amount']) . '</td>';
        $html .= '<td style="width:15%; border:1px solid black; text-align:right;">' . number_format((float)$item['cost_duration'] * $item['cost_rate'] * $item['cost_amount'], 2) . ' บาท</td>';
        $html .= '</tr>';
    }

    // แถวรวมราคาจาก total_cost ของฟอร์มหลัก
    $html .= '<tr>';
    $html .= '<td colspan="4" style="border:1px solid black; text-align:right; font-weight:bold;">รวมทั้งสิ้น</td>';
    $html .= '<td style="border:1px solid black; text-align:right; font-weight:bold;">' . number_format((float)$total_cost, 2) . ' บาท</td>';
    $html .= '</tr>';

    return $html;
}




//--ส่วนการจัดรูปแบบย่อหน้า --
//--ย่อหน้าเป้าหมายเชิงปริมาณ--
$lines = explode("\n", $data['goal_quantitative']);
$indentedText = '';
foreach ($lines as $line) {
    $indentedText .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' . htmlspecialchars($line) . '<br>';
}

//--ย่อหน้ารายละเอียดคุณลักษณะเฉพาะ
function indentEveryLine($text, $indent = 6)
{
    $lines = explode("\n", $text); // แยกตามบรรทัด
    $indented = '';
    $space = str_repeat('&nbsp;', $indent); // สร้างช่องว่างย่อหน้า
    foreach ($lines as $line) {
        if (trim($line) !== '') {
            $indented .= $space . htmlspecialchars(trim($line)) . '<br>';
        }
    }
    return $indented;
}

//--ส่วนการสร้างตารางสถานที่ติดตั้ง--
function generateInstallationPlacesTable($items)
{
    if (empty($items)) {
        return '<tr>
            <td colspan="3" style="border:1px solid black; text-align:center; font-style:italic;">ไม่มีข้อมูลสถานที่ติดตั้ง</td>
        </tr>';
    }

    $html = '';
    $count = 1;

    foreach ($items as $item) {
        $html .= '<tr>';
        $html .= '<td style="width:45%; border:1px solid black; text-align:left;">' . $count++ . '. ' . htmlspecialchars($item['item']) . '</td>';
        $html .= '<td style="width:20%; border:1px solid black; text-align:center;">' . htmlspecialchars($item['quantity']) . '</td>';
        $html .= '<td style="width:35%; border:1px solid black; text-align:center;">' . htmlspecialchars($item['location']) . '</td>';
        $html .= '</tr>';
    }

    return $html;
}

// เพิ่มหน้าใหม่
$pdf->AddPage();

function e($string)
{
    return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
}


$html = $styles . '
<table cellpadding="3" cellspacing="0" style="width: 100%; ">
    <tr>
        <td style="border: 1px solid black; border-right: 1px solid black; width: 30%; vertical-align: middle; background-color: #a6a6a6">
            1. ชื่อโครงการ/กิจกรรม
        </td>
        <td style=" border-bottom: 1px solid black; width: 70%; vertical-align: middle;">
            
        </td>
    </tr>
    <tr>
        <td colspan="2" style="border: 1px solid black; vertical-align: middle;">
            ' . e($data['project_name']) . '
        </td>
    </tr>
</table>

<br/><br/>

<table border="1" cellpadding="3" cellspacing="0" style="width: 100%;">
    <tr>
        <td style="border: 1px solid black; border-right: 1px solid black; width: 30%; vertical-align: middle; background-color: #a6a6a6">2. ส่วนราชการ</td>
    </tr>
    <tr>
        <td class="cell-label">2.1 ชื่อส่วนราชการ</td>
        <td class="cell-value">' . e($data['department_name']) . '</td>
    </tr>
    <tr>
        <td class="cell-label">2.2 ชื่อหน่วยงาน</td>
        <td class="cell-value">' . e($data['unit_name']) . '</td>
    </tr>

</table>


<table border="1" cellpadding="3" cellspacing="0">
  <tr>
    <td rowspan="4" style="width:30%;">2.3 ผู้รับผิดชอบโครงการ</td>
    <td colspan="2" style="width:70%;">ชื่อ-สกุล : ' . e($data['responsible_person_name']) . '</td>
  </tr>
  <tr>
    <td colspan="2">ตำแหน่ง : ' . e($data['responsible_person_position']) . '</td>
  </tr>
  <tr>
<td >โทรศัพท์ : ' . e($data['responsible_person_phone']) . '</td>
<td >โทรสาร : ' . e($data['responsible_person_fax']) . '</td>
  </tr>
  <tr>
<td colspan="2">อีเมล : ' . e($data['responsible_person_email']) . '</td>
  </tr>
</table>

<br/><br/>
    
<table cellpadding="3" cellspacing="0" style="width: 100%;">
    <tr>
        <td style="border: 1px solid black; border-right: 1px solid black; width: 30%; vertical-align: middle; background-color: #a6a6a6">
            3. งบประมาณ
        </td>
        <td style="width: 70%; vertical-align: middle;"></td>
    </tr>
    <tr>
        <td style="border: 1px solid black; border-right: 1px solid black; width: 30%; vertical-align: middle;">
           3.1 งบประมาณโครงการ
        </td>
    </tr>
</table>

<br/><br/>

<table border="1" cellpadding="3" cellspacing="0" style="width: 100%;">
    <tr>
       <td style="border: 1px solid black; width: 33.33%; vertical-align: middle;">
            <span style="font-family: dejavusans;">' . ((isset($data["budget_type"]) && trim($data["budget_type"]) === "single") ? '☑' : '☐') . '</span> งบประมาณโครงการปีเดียว
        </td>
    </tr>
    <tr>
    <td style="width: 33.33%; border: 1px solid black;">ปีงบประมาณ</td>
    <td style="border: 1px solid black;"> พ.ศ. ' . e($data['budget_year']) . '</td>
</tr>

    <tr>
    <td style="border: 1px solid black; text-align: center;">วงเงินงบประมาณ</td>
    <td style="width: 33.33%; border: 1px solid black;">' . number_format((float)$data['budget_amount'], 2) . ' บาท</td>
    <td style="width: 33.33%; border: 1px solid black;">วงเงิน ICT ' . number_format((float)$data['ict_budget_amount'], 2) . ' บาท</td>
</tr>
</table>

<br/><br/>

<table border="1" cellpadding="3" cellspacing="0" style="width: 100%;">
    <tr>
        <td style="border: 1px solid black; border-right: 1px solid black; width: 38%; vertical-align: middle;">
            <span style="font-family: dejavusans;">' . ((isset($data["budget_type"]) && trim($data["budget_type"]) === "multi") ? '☑' : '☐') . '</span> งบประมาณโครงการมากกว่า 1 ปี
        </td>
    </tr>
</table>

<table border="1" cellpadding="3" cellspacing="0" style="width: 100%;">
    <tr>
        <td style="width: 20%; border: 1px solid black;">ปีงบประมาณ พ.ศ.</td>
        <td style="width: 80%; border: 1px solid black;">' . e($data['multi_range']) . '</td>
    </tr>
</table>

<table border="1" cellpadding="3" cellspacing="0" style="width: 100%;">
    <tr>
        <td style="width: 30%; border: 1px solid black; text-align: center; font-weight: bold;">ปีงบประมาณ พ.ศ.</td>
        <td style="width: 35%; border: 1px solid black; text-align: center; font-weight: bold;">วงเงินงบประมาณ (บาท)</td>
        <td style="width: 35%; border: 1px solid black; text-align: center; font-weight: bold;">วงเงินด้าน ICT (บาท)</td>
    </tr>
    ' . generateMultiYearRows($multi_year_rows) . '
</table>
 
<br/><br/>

<table cellpadding="3" cellspacing="0" style="width: 100%; ">
    <tr>
        <td style="border: 1px solid black; border-right: 1px solid black; width: 30%; vertical-align: middle; background-color: #a6a6a6">
            3.2 แหล่งเงิน
        </td>
        <td style="border-bottom: 1px solid black; width: 70%; vertical-align: middle;">
        </td>
    </tr>
    <tr>
        <td colspan="2" style="border: 1px solid black; vertical-align: middle; line-height: 2; ">
            <span style="display: inline-block; min-width: 180px;">
                <span style="font-family: dejavusans;">' . ($data['funding_source'] == 'งบประมาณแผ่นดิน' ? '☑' : '☐') . '</span> งบประมาณแผ่นดิน
            </span>
            <span style="display: inline-block; min-width: 180px;">
                <span style="font-family: dejavusans;">' . ($data['funding_source'] == 'เปลี่ยนแปลงรายการ' ? '☑' : '☐') . '</span> เปลี่ยนแปลงรายการ
            </span>
            <span style="display: inline-block; min-width: 180px;">
                <span style="font-family: dejavusans;">' . ($data['funding_source'] == 'เงินเหลือจ่าย' ? '☑' : '☐') . '</span> เงินเหลือจ่าย
            </span>
            <span style="display: inline-block; min-width: 180px;">
                <span style="font-family: dejavusans;">' . ($data['funding_source'] == 'เงินรายได้' ? '☑' : '☐') . '</span> เงินรายได้
            </span>
            <br/>
            <span style="display: inline-block; min-width: 180px;">
                <span style="font-family: dejavusans;">' . ($data['funding_source'] == 'เงินนอกงบประมาณ' ? '☑' : '☐') . '</span> เงินนอกงบประมาณ
            </span>
            <span style="display: inline-block; min-width: 180px;">
                <span style="font-family: dejavusans;">' . ($data['funding_source'] == 'เงินช่วยเหลือ' ? '☑' : '☐') . '</span> เงินช่วยเหลือ
            </span>
            <span style="display: inline-block; min-width: 180px;">
                <span style="font-family: dejavusans;">' . ($data['funding_source'] == 'เงินกู้' ? '☑' : '☐') . '</span> เงินกู้
            </span>
            <span style="display: inline-block; min-width: 180px;">
                <span style="font-family: dejavusans;">' . ($data['funding_source'] == 'อื่น ๆ' ? '☑' : '☐') . '</span> อื่น ๆ
                ' . (!empty($data['other_funding_source_detail']) ? 'โปรดระบุ: ' . e($data['other_funding_source_detail']) : '') . '
            </span>
        </td>
    </tr>
</table>

';




// เขียนเนื้อหา HTML ลงใน PDF
$pdf->writeHTML($html, true, false, true, false, '');
$pdf->AddPage();

// --- เนื้อหาหน้าถัดไป ---
$html2 = '

<table cellpadding="3" cellspacing="0" style="width: 100%;">
    <tr>
        <td style="border: 1px solid black; border-right: 1px solid black; width: 30%; vertical-align: middle; background-color: #a6a6a6">
            4. หลักการและเหตุผล
        </td>
        <td style=" border-bottom: 1px solid black; width: 70%; vertical-align: middle;">
            
        </td>
    </tr>
    <tr>
        <td colspan="2" style=" solid black; vertical-align: middle; white-space: pre-wrap; word-break: break-word;">
             ' . nl2br(e($data['project_rationale'])) . '
        </td>
    </tr>
</table>
<br/><br/>

<table cellpadding="3" cellspacing="0" style="width: 100%;">
    <tr>
        <td style="border: 1px solid black; border-right: 1px solid black; width: 30%; vertical-align: middle; background-color: #a6a6a6">
            5. วัตถุประสงค์
        </td>
        <td style=" border-bottom: 1px solid black; width: 70%; vertical-align: middle;">
            
        </td>
    </tr>
    <tr>
        <td colspan="2" style="solid black; vertical-align: middle;">
            ' . e($data['project_objectives']) . '
        </td>
    </tr>
</table>
<br/><br/>

<table cellpadding="3" cellspacing="0" style="width: 100%;">
    <tr>
        <td style="border: 1px solid black; border-right: 1px solid black; width: 30%; vertical-align: middle; background-color: #a6a6a6">
            6. เป้าหมาย
        </td>
    </tr>
</table>
<br/><br/>

<table cellpadding="3" cellspacing="0" style="width: 100%;">
    <tr>
        <td style="border: 1px solid black; border-right: 1px solid black; width: 30%; vertical-align: middle;">
            6.1 เป้าหมายเชิงปริมาณ
        </td>
        <td style="border-bottom: 1px solid black; width: 70%; vertical-align: middle;">
            
        </td>
    </tr>
    <tr>
        <td colspan="2" style="solid black; vertical-align: middle;">
            ' . $indentedText . '
        </td>
    </tr>

</table>


    <br/><br/>

 <table cellpadding="3" cellspacing="0" style="width: 100%; page-break-inside: avoid;">
    <tr>
        <td style="border: 1px solid black; border-right: 1px solid black; width: 30%; vertical-align: middle;">
            6.2 เป้าหมายเชิงคุณภาพ
        </td>
        <td style=" border-bottom: 1px solid black; width: 70%; vertical-align: middle;">
            
        </td>
    </tr>
    <tr>
        <td colspan="2" style="solid black; vertical-align: middle;">
            ' . e($data['goal_qualitative']) . '
        </td>
    </tr>
</table>   

<br/><br/>

<table cellpadding="3" cellspacing="0" style="width: 100%; ">
    <tr>
        <td style="border: 1px solid black; border-right: 1px solid black; width: 30%; vertical-align: middle; background-color: #a6a6a6">
            7. ลักษณะโครงการ
        </td>
        <td style="border-bottom: 1px solid black; width: 70%; vertical-align: middle;">
        </td>
    </tr>
    <tr>
        <td colspan="2" style="border: 1px solid black; vertical-align: middle; line-height: 2;">
            <span style="display: inline-block; min-width: 180px;">
                <span style="font-family: dejavusans;">' . ($data['project_type'] == 'จัดหาใหม่' ? '☑' : '☐') . '</span> จัดหาใหม่
            </span>
            <span style="display: inline-block; min-width: 180px;">
                <span style="font-family: dejavusans;">' . ($data['project_type'] == 'ขยายระบบเดิม' ? '☑' : '☐') . '</span> ขยายระบบเดิม
            </span>
            <span style="display: inline-block; min-width: 180px;">
                <span style="font-family: dejavusans;">' . ($data['project_type'] == 'ทดแทนระบบเดิม' ? '☑' : '☐') . '</span> ทดแทนระบบเดิม
            </span>
            <span style="display: inline-block; min-width: 180px;">
                <span style="font-family: dejavusans;">' . ($data['project_type'] == 'อื่น ๆ' ? '☑' : '☐') . '</span> อื่น ๆ
                ' . (!empty($data['other_project_detail']) ? ' ระบุ : ' . e($data['other_project_detail']) : '') . '
            </span>
        </td>
    </tr>
</table>



<br/><br/>

<table border="1" cellpadding="3" cellspacing="0" style="width: 100%;">
    <tr>
        <td style="border: 1px solid black; border-right: 1px solid black; width: 54%; vertical-align: middle; background-color: #a6a6a6">
           8. สถานภาพของระบบ/อุปกรณ์คอมพิวเตอร์ในปัจจุบัน
        </td>
    </tr>
</table>
<table border="1" cellpadding="3" cellspacing="0" style="width: 100%;">
    <tr>
        <td style="width: 45%; border: 1px solid black; text-align: center; font-weight: bold;">รายการ</td>
        <td style="width: 30%; border: 1px solid black; text-align: center; font-weight: bold;">สถานที่ติดตั้ง</td>
        <td style="width: 25%; border: 1px solid black; text-align: center; font-weight: bold;">ติดตั้งใช้งานเมื่อปี พ.ศ.</td>
    </tr>
' . generateStatusItemsTable($status_items) . '

</table>
<br/><br/>
<table border="1" cellpadding="3" cellspacing="0" style="width: 100%; border-collapse: collapse; page-break-inside: avoid;">
    <tr>
        <td style="width: 100%; background-color: #a6a6a6; vertical-align: middle; text-align: left;">
            9. โครงรูปและการเชื่อมโยงระบบ/อุปกรณ์คอมพิวเตอร์
        </td>
    </tr>
    <tr>
        <td style="text-align: center; vertical-align: middle;">
            ' . $imageHTML . '
        </td>
    </tr>
</table>



<br/><br/>
<table border="1" cellpadding="3" cellspacing="0" style="width: 100%;">
    <tr>
        <td style="border: 1px solid black; border-right: 1px solid black; width: 54%; vertical-align: middle; background-color: #a6a6a6">
           10. บุคลากรด้านเทคโนโลยีสารสนเทศที่มีอยู่ในปัจจุบัน
        </td>
    </tr>
</table>
<table border="1" cellpadding="3" cellspacing="0" style="width: 100%;">
    <tr>
        <td style="width: 70%; border: 1px solid black; text-align: center; font-weight: bold;">ตำแหน่ง</td>
        <td style="width: 30%; border: 1px solid black; text-align: center; font-weight: bold;">จำนวน</td>
    </tr>
' . generateItPersonnelTable($it_personnel)  . ' 

</table>
<br/><br/>

<table border="1" cellpadding="3" cellspacing="0" style="width: 100%;">
    <tr>
        <td style="border: 1px solid black; border-right: 1px solid black; width: 54%; vertical-align: middle; background-color: #a6a6a6">
            11. แผนการดำเนินงาน และระยะเวลาดำเนินการ
        </td>
    </tr>
</table>
    <table border="1" cellpadding="3" cellspacing="0" style="width: 100%;">
    <tr>
        <td style="width: 30%; border: 1px solid black; text-align: center; font-weight: bold;">ระยะเวลาดำเนินงาน</td>
        <td style="width: 70%; border: 1px solid black; font-weight: bold;">' . e($work_plan_duration) . '</td>
    </tr>
</table>
<br/><br/>
' . generateWorkPlanTable($work_plan_data) . '

<br/><br/>

<table cellpadding="3" cellspacing="0" style="width: 100%; page-break-inside: avoid;">
    <tr>
        <td style="border: 1px solid black; border-right: 1px solid black; width: 50%; background-color: #a6a6a6;">
            12. ความสอดคล้องกับนโยบายหรือแผนที่เกี่ยวข้อง
        </td>
        <td style="border-bottom: 1px solid black; width: 50%;"></td>
    </tr>
    <tr>
        <td colspan="2" style="border: 1px solid black; line-height: 1.8;">
            <span style="display: inline-block; min-width: 100%;">
                <span style="font-family: dejavusans;">' . (in_array('national_strategy', $policy_keys) ? '☑' : '☐') . '</span> สอดคล้องกับยุทธศาสตร์ชาติ/แผนปฏิรูปประเทศ
            </span><br>
            <span style="display: inline-block; min-width: 100%;">
                <span style="font-family: dejavusans;">' . (in_array('digital_economy_plan', $policy_keys) ? '☑' : '☐') . '</span> สอดคล้องกับแผนพัฒนาดิจิตอลเพื่อเศรษฐกิจและสังคม/แผนพัฒนารัฐบาลดิจิตอลของประเทศ
            </span><br>
            <span style="display: inline-block; min-width: 100%;">
                <span style="font-family: dejavusans;">' . (in_array('ministry_digital_plan', $policy_keys) ? '☑' : '☐') . '</span> สอดคล้องกับแผนพัฒนาดิจิตอลของกระทรวง
            </span><br>
            <span style="display: inline-block; min-width: 100%;">
                <span style="font-family: dejavusans;">' . (in_array('agency_digital_action_plan', $policy_keys) ? '☑' : '☐') . '</span> สอดคล้องกับแผนปฏิบัติการดิจิตอลของหน่วยงาน
            </span><br>
            <span style="display: inline-block; min-width: 100%;">
                <span style="font-family: dejavusans;">' . (in_array('other', $policy_keys) ? '☑' : '☐') . '</span> อื่น ๆ' . $other_text . '
            </span>
        </td>
    </tr>
</table>

<br/><br/>

<table cellpadding="3" cellspacing="0" style="width: 100%;">
    <tr>
        <td style="border: 1px solid black; width: 50%; vertical-align: middle; background-color: #a6a6a6">
            13. รายละเอียดอุปกรณ์/การพัฒนาระบบงาน ที่เสนอขอจัดหา
        </td>
        <td style="width: 50%;"></td>
    </tr>
    <tr><td></td></tr>
    <tr>
        <td style="border: 1px solid black; width: 35%; vertical-align: middle;">
            13.1 รายละเอียดอุปกรณ์/ลิขสิทธิ์ซอฟต์แวร์
        </td>
    </tr>
</table>

<table border="1" cellpadding="3" cellspacing="0" style="width: 100%;">
    <tr>
        <td style="width: 33%; text-align: center; font-weight: bold;">รายการ</td>
        <td style="width: 15%; text-align: center; font-weight: bold;">จำนวน</td>
        <td style="width: 15%; text-align: center; font-weight: bold;">ราคาต่อหน่วย (บาท)</td>
        <td style="width: 15%; text-align: center; font-weight: bold;">ราคารวม (บาท)</td>
        <td style="width: 22%; text-align: center; font-weight: bold;">เกณฑ์ ICT</td>
    </tr>
    ' . generateProcurementItemsTable($procurement_items, $data['total_budget']) . '
</table>
<br/><br/>

<table cellpadding="3" cellspacing="0" style="width: 100%;">
    <tr>
        <td style="border: 1px solid black; width: 35%; vertical-align: middle;">
            13.2 รายละเอียดการพัฒนาระบบงาน
        </td>
        <td style=" border-bottom: 1px solid black; width: 70%; vertical-align: middle;">
            (เฉพาะการจัดหาระบบ)
        </td>
    </tr>

</table>
<br/><br/>

<table cellpadding="3" cellspacing="0" style="width: 100%; ">
    <tr>
        <td style="border: 1px solid black; border-right: 1px solid black; width: 30%; vertical-align: middle;">
            13.2.1 ชื่อระบบงาน
        </td>
        <td style=" border-bottom: 1px solid black; width: 70%; vertical-align: middle;">
            
        </td>
    </tr>
    <tr>
        <td colspan="2" style="border: 1px solid black; vertical-align: middle;">
            ' . nl2br(e($data['system_name'])) . '
        </td>
    </tr>
</table>
<br/><br/>

<table cellpadding="3" cellspacing="0" style="width: 100%;">
    <tr>
        <td style="border: 1px solid black; border-right: 1px solid black; width: 35%; vertical-align: middle;">
            13.2.2 ขอบเขตและข้อกำหนดของระบบงาน
        </td>
        <td style=" border-bottom: 1px solid black; width: 65%; vertical-align: middle;">
        </td>
    </tr>
    <tr>
         <td colspan="2" style=" solid black; vertical-align: middle; white-space: pre-wrap; word-break: break-word;">
           ' . nl2br(e($data['system_scope'])) . '
        </td>
    </tr>
</table>
<br/><br/>

<table cellpadding="3" cellspacing="0" style="width: 100%; ">
    <tr>
         <td style="border: 1px solid black; border-right: 1px solid black; width: 43%; vertical-align: middle;">
            13.2.3 แนวคิดของระบบงาน (Conceptual Design)
        </td>
        <td style=" border-bottom: 1px solid black; width: 57%; vertical-align: middle;">
        </td>
    </tr>
    <tr>
         <td colspan="2" style=" solid black; vertical-align: middle; white-space: pre-wrap; word-break: break-word;">
           ' . nl2br(e($data['system_concept'])) . '
        </td>
    </tr>
</table>

<br/><br/>

    <table cellpadding="3" cellspacing="0" style="width: 100%; ">
    <tr>
         <td style="border: 1px solid black; border-right: 1px solid black; width: 43%; vertical-align: middle;">
            13.2.4 รายละเอียดค่าใช้จ่ายการพัฒนาระบบงาน
        </td>
        <td style=" border-bottom: 1px solid black; width: 57%; vertical-align: middle;">
        </td>
    </tr>
</table>
<br/><br/>
<table border="1" cellpadding="3" cellspacing="0" style="width:100%;">
    <tr>
        <th style="width:40%; text-align:center; font-weight:bold;">รายการค่าใช้จ่าย</th>
        <th style="width:15%; text-align:center; font-weight:bold;">ระยะเวลา (เดือน)</th>
        <th style="width:15%; text-align:center; font-weight:bold;">อัตรา (บาท)</th>
        <th style="width:15%; text-align:center; font-weight:bold;">จำนวน</th>
        <th style="width:15%; text-align:center; font-weight:bold;">รวมค่าใช้จ่าย</th>
    </tr>
    ' . generateSystemCostItemsTable($system_cost_items, $total_cost) . '
</table>
<div style="font-size:12px;"><u>หมายเหตุ</u> ให้จำแนกเป็นรายการค่าใช้จ่ายตามหลักเกณฑ์การคำนวณราคากลางงานพัฒนาระบบของกระทรวงดิจิทัลเพื่อเศรษฐกิจและสังคมและหลักเกณฑ์ราคากลางการจ้างที่ปรึกษาของกระทรวงการคลัง</div>
<br/>

<table cellpadding="3" cellspacing="0" style="width: 100%;">
    <tr>
        <td style="border: 1px solid black; border-right: 1px solid black; width: 30%; vertical-align: middle; background-color: #a6a6a6">
            13. วิธีการจัดหา
        </td>
        <td style="border-bottom: 1px solid black; width: 70%; vertical-align: middle;">
        </td>
    </tr>
    <tr>
        <td colspan="2" style="border: 1px solid black; vertical-align: middle; line-height: 2;">
            <span style="display: inline-block; min-width: 180px;">
                <span style="font-family: dejavusans;">' . (in_array("จัดซื้อ", $methods) ? "☑" : "☐") . '</span> จัดซื้อ
            </span>
            <span style="display: inline-block; min-width: 180px;">
                <span style="font-family: dejavusans;">' . (in_array("การจ้าง", $methods) ? "☑" : "☐") . '</span> การจ้าง
            </span>
            <span style="display: inline-block; min-width: 180px;">
                <span style="font-family: dejavusans;">' . (in_array("อื่น ๆ", $methods) ? "☑" : "☐") . '</span> อื่น ๆ
                ' . (!empty($otherDetail) ? " ระบุ : " . htmlspecialchars($otherDetail) : "") . '
            </span>
        </td>
    </tr>
</table>
<br/><br/>

<table cellpadding="3" cellspacing="0" style="width:100%; margin-top:10px;">
    <tr>
        <td style="border: 1px solid black; border-right: 1px solid black; width: 40%; vertical-align: middle; background-color: #a6a6a6">
        15. สถานที่ติดตั้งอุปกรณ์/ระบบงาน ตามข้อ 13</td>
    </tr>
    <tr>
        <td style="width:45%; border:1px solid black; text-align:center; font-weight:bold;">รายการ</td>
        <td style="width:20%; border:1px solid black; text-align:center; font-weight:bold;">จำนวน</td>
        <td style="width:35%; border:1px solid black; text-align:center; font-weight:bold;">สถานที่ติดตั้ง</td>
    </tr>
    ' . generateInstallationPlacesTable($installation_items) . '
</table>
<br/><br/>

';

// เขียนเนื้อหา HTML ลงใน PDF
$pdf->writeHTML($html2, true, false, true, false, '');
$pdf->AddPage();

$html3 .= '

<table cellpadding="3" cellspacing="0" style="width: 100%;">
    <tr>
        <td style="border: 1px solid black; border-right: 1px solid black; width: 30%; vertical-align: middle; background-color: #a6a6a6">
            16. ประโยชน์ที่คาดว่าจะได้รับ
        </td>
        <td style="border-bottom: 1px solid black; width: 70%; vertical-align: middle;">
        </td>
    </tr>
    <tr>
        <td colspan="2" style=" solid black; vertical-align: middle; white-space: pre-wrap; word-break: break-word;">
            ' . nl2br(htmlspecialchars($data['expected_benefits'])) . '
        </td>
    </tr>
</table>
<br/><br/><br/><br/>

<div style="font-size:16px; text-align:right; margin-top:15px;">
    ลงชื่อผู้รับผิดชอบโครงการ ............................................................<br/>
    ( ' . htmlspecialchars($data['responsible_person_name']) . ' )&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br/>
    ตำแหน่ง ' . htmlspecialchars($data['responsible_person_position']) . '&nbsp;&nbsp;&nbsp;&nbsp;<br/>
</div>

<br/>

<table cellpadding="3" cellspacing="0" style="width: 100%;">
    <tr>
        <td style="border: 1px solid black; width: 30%; vertical-align: middle; background-color: #a6a6a6">
            การลงนามรับรองโครงการ/กิจกรรม
        </td>
        <td style="border-bottom: 1px solid black; width: 70%; vertical-align: middle;"> </td>
    </tr>
<tr>
    <td colspan="2" style="border:1px solid black; vertical-align: middle; padding: 10px;">
        <div style="font-family: thsarabun; font-size: 16pt; line-height: 1; margin-bottom: 5px;">
            <span><span style="font-family: dejavusans;">☐</span> เห็นชอบ</span> &nbsp;&nbsp; 
            <span><span style="font-family: dejavusans;">☐ </span>ไม่เห็นชอบ</span>
        </div>

        <div style="font-family: thsarabun; font-size: 16pt; line-height: 1;">
            <span style="text-decoration: underline;"> โครงการ/กิจกรรม </span> ' . e($data['project_name']) . '<br/>
             งบประมาณ ' . number_format((float)$data['total_budget'], 2) . ' บาท
        </div>
        <br/><br/>

        <div style="font-family: thsarabun; font-size: 16pt; text-align: right; line-height: 1.2;">
            ลงชื่อ .................................................................................. &nbsp;&nbsp;&nbsp;&nbsp;<br/>
            (ผู้ช่วยศาสตราจารย์ ดร.อภิชาต ติรประเสริฐสิน)&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br/>
            รองอธิการบดีฝ่ายเทคโนโลยีดิจิทัลสารสนเทศและกิจการสภามหาวิทยาลัย &nbsp;&nbsp;&nbsp;<br/>
            ผู้บริหารเทคโนโลยีสารสนเทศระดับสูงมหาวิทยาลัยเทคโนโลยีราชมงคลอีสาน &nbsp;<br/>
            วันที่ ........... / ........... / ........... &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        </div>
    </td>
</tr>

</table>

';
$pdf->writeHTML($html3, true, false, true, false, '');


// --- ส่วนการส่งออก PDF ---
$filename = 'โครงงาน' . preg_replace('/[^a-zA-Z0-9ก-๙ _-]/u', '', $data['project_name']) . '.pdf';

ob_end_clean(); // ล้าง buffer เพื่อไม่ให้ส่งอะไรออกไปก่อน

$pdf->Output($filename, 'I');
