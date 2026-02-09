-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: db
-- Generation Time: Feb 04, 2026 at 02:41 PM
-- Server version: 8.0.41
-- PHP Version: 8.2.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `MYSQL_DATABASE`
--

-- --------------------------------------------------------

--
-- Table structure for table `form_fields`
--

CREATE TABLE `form_fields` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `project_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `department_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `unit_name` varchar(255) NOT NULL,
  `responsible_person_name` varchar(255) NOT NULL,
  `responsible_person_position` varchar(255) NOT NULL,
  `responsible_person_phone` varchar(255) NOT NULL,
  `responsible_person_fax` varchar(255) NOT NULL,
  `responsible_person_email` varchar(255) NOT NULL,
  `budget_type` varchar(20) NOT NULL,
  `multi_range` varchar(255) DEFAULT NULL,
  `budget_year` varchar(10) DEFAULT NULL,
  `budget_amount` bigint DEFAULT NULL,
  `ict_budget_amount` bigint DEFAULT NULL,
  `funding_source` varchar(255) NOT NULL,
  `other_funding_source_detail` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `project_rationale` text NOT NULL,
  `project_objectives` text NOT NULL,
  `goal_quantitative` text NOT NULL,
  `goal_qualitative` text NOT NULL,
  `project_type` varchar(255) NOT NULL,
  `other_project_detail` text NOT NULL,
  `total_budget` bigint DEFAULT NULL,
  `system_name` text,
  `system_scope` text,
  `system_concept` text,
  `total_system_cost` double DEFAULT NULL,
  `total_cost` bigint DEFAULT NULL,
  `expected_benefits` text,
  `project_approver` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `form_fields`
--

INSERT INTO `form_fields` (`id`, `user_id`, `project_name`, `department_name`, `unit_name`, `responsible_person_name`, `responsible_person_position`, `responsible_person_phone`, `responsible_person_fax`, `responsible_person_email`, `budget_type`, `multi_range`, `budget_year`, `budget_amount`, `ict_budget_amount`, `funding_source`, `other_funding_source_detail`, `project_rationale`, `project_objectives`, `goal_quantitative`, `goal_qualitative`, `project_type`, `other_project_detail`, `total_budget`, `system_name`, `system_scope`, `system_concept`, `total_system_cost`, `total_cost`, `expected_benefits`, `project_approver`) VALUES
(173, 10, 'จัดหาตอมพิวเตอร์เพื่อการศึกษา', 'มหาวิทยาลัยเทคโนโลยีราชมงคลอีสาน', 'งานบ้าน', 'สมคิด เดชมะเริง', 'นักศึกษา', '0987654321', '0234567890', 'user@gmail.com', 'multi', '2568-2569', NULL, NULL, NULL, 'อื่น ๆ', 'ไม่บอก', 'สวัสดีครับ ทดสอบระบบ PDF ,สวัสดีครับ ทดสอบระบบ PDF ,สวัสดีครับ ทดสอบระบบ PDF ,สวัสดีครับ ทดสอบระบบ PDF ,สวัสดีครับ ทดสอบระบบ PDF ,สวัสดีครับ ทดสอบระบบ PDF ,สวัสดีครับ ทดสอบระบบ PDF ,สวัสดีครับ ทดสอบระบบ PDF ,สวัสดีครับ ทดสอบระบบ PDF ,สวัสดีครับ ทดสอบระบบ PDF ,สวัสดีครับ ทดสอบระบบ PDF ,สวัสดีครับ ทดสอบระบบ PDF ,สวัสดีครับ ทดสอบระบบ PDF ,สวัสดีครับ ทดสอบระบบ PDF ,สวัสดีครับ ทดสอบระบบ PDF ,สวัสดีครับ ทดสอบระบบ PDF ,สวัสดีครับ ทดสอบระบบ PDF ,สวัสดีครับ ทดสอบระบบ PDF ,สวัสดีครับ ทดสอบระบบ PDF ,สวัสดีครับ ทดสอบระบบ PDF ,สวัสดีครับ ทดสอบระบบ PDF ,สวัสดีครับ ทดสอบระบบ PDF ,สวัสดีครับ ทดสอบระบบ PDF ,สวัสดีครับ ทดสอบระบบ PDF ,สวัสดีครับ ทดสอบระบบ PDF ,สวัสดีครับ ทดสอบระบบ PDF ,สวัสดีครับ ทดสอบระบบ PDF ,สวัสดีครับ ทดสอบระบบ PDF ,สวัสดีครับ ทดสอบระบบ PDF ,สวัสดีครับ ทดสอบระบบ PDF ,สวัสดีครับ ทดสอบระบบ PDF ,สวัสดีครับ ทดสอบระบบ PDF ,สวัสดีครับ ทดสอบระบบ PDF ,สวัสดีครับ ทดสอบระบบ PDF ,สวัสดีครับ ทดสอบระบบ PDF ,สวัสดีครับ ทดสอบระบบ PDF ,', 'สวัสดีครับ ทดสอบระบบ PDF ,สวัสดีครับ ทดสอบระบบ PDF ,สวัสดีครับ ทดสอบระบบ PDF ,สวัสดีครับ ทดสอบระบบ PDF ,สวัสดีครับ ทดสอบระบบ PDF ,สวัสดีครับ ทดสอบระบบ PDF ,สวัสดีครับ ทดสอบระบบ PDF ,สวัสดีครับ ทดสอบระบบ PDF ,สวัสดีครับ ทดสอบระบบ PDF ,สวัสดีครับ ทดสอบระบบ PDF ,สวัสดีครับ ทดสอบระบบ PDF ,สวัสดีครับ ทดสอบระบบ PDF ,สวัสดีครับ ทดสอบระบบ PDF ,สวัสดีครับ ทดสอบระบบ PDF ,สวัสดีครับ ทดสอบระบบ PDF ,สวัสดีครับ ทดสอบระบบ PDF ,สวัสดีครับ ทดสอบระบบ PDF ,สวัสดีครับ ทดสอบระบบ PDF ,สวัสดีครับ ทดสอบระบบ PDF ,สวัสดีครับ ทดสอบระบบ PDF ,', '1.สวัสดีครับ ทดสอบระบบ PDF\n2.สวัสดีครับ ทดสอบระบบ PDF\n3.สวัสดีครับ ทดสอบระบบ PDF\n4.สวัสดีครับ ทดสอบระบบ PDF\n5.สวัสดีครับ ทดสอบระบบ PDF\n6.สวัสดีครับ ทดสอบระบบ PDF\n7.สวัสดีครับ ทดสอบระบบ PDF\n8.สวัสดีครับ ทดสอบระบบ PDF\n9.สวัสดีครับ ทดสอบระบบ PDF\n10.สวัสดีครับ ทดสอบระบบ PDF\n11.สวัสดีครับ ทดสอบระบบ PDF\n12.สวัสดีครับ ทดสอบระบบ PDF\n13.สวัสดีครับ ทดสอบระบบ PDF\n14.สวัสดีครับ ทดสอบระบบ PDF', 'สวัสดีครับ ทดสอบระบบ PDF ,สวัสดีครับ ทดสอบระบบ PDF ,สวัสดีครับ ทดสอบระบบ PDF ,สวัสดีครับ ทดสอบระบบ PDF ,สวัสดีครับ ทดสอบระบบ PDF ,สวัสดีครับ ทดสอบระบบ PDF ,สวัสดีครับ ทดสอบระบบ PDF ,สวัสดีครับ ทดสอบระบบ PDF ,สวัสดีครับ ทดสอบระบบ PDF ,สวัสดีครับ ทดสอบระบบ PDF ,สวัสดีครับ ทดสอบระบบ PDF ,สวัสดีครับ ทดสอบระบบ PDF ,', 'อื่น ๆ', 'สวัสดีครับ ทดสอบระบบ PDF', 75000, 'สวัสดีครับ ทดสอบระบบ PDF เทสๆ', 'สวัสดีครับ ทดสอบระบบ PDF สวัสดีครับ ทดสอบระบบ PDF สวัสดีครับ ทดสอบระบบ PDF สวัสดีครับ ทดสอบระบบ PDF สวัสดีครับ ทดสอบระบบ PDF สวัสดีครับ ทดสอบระบบ PDF สวัสดีครับ ทดสอบระบบ PDF สวัสดีครับ ทดสอบระบบ PDF สวัสดีครับ ทดสอบระบบ PDF สวัสดีครับ ทดสอบระบบ PDF สวัสดีครับ ทดสอบระบบ PDF สวัสดีครับ ทดสอบระบบ PDF', 'สวัสดีครับ ทดสอบระบบ PDF สวัสดีครับ ทดสอบระบบ PDF สวัสดีครับ ทดสอบระบบ PDF สวัสดีครับ ทดสอบระบบ PDF สวัสดีครับ ทดสอบระบบ PDF สวัสดีครับ ทดสอบระบบ PDF สวัสดีครับ ทดสอบระบบ PDF สวัสดีครับ ทดสอบระบบ PDF สวัสดีครับ ทดสอบระบบ PDF สวัสดีครับ ทดสอบระบบ PDF สวัสดีครับ ทดสอบระบบ PDF', NULL, 50000, 'สวัสดีครับ ทดสอบระบบ PDF สวัสดีครับ ทดสอบระบบ PDF สวัสดีครับ ทดสอบระบบ PDF สวัสดีครับ ทดสอบระบบ PDF สวัสดีครับ ทดสอบระบบ PDF สวัสดีครับ ทดสอบระบบ PDF สวัสดีครับ ทดสอบระบบ PDF สวัสดีครับ ทดสอบระบบ PDF', 'สวัสดีครับ ทดสอบระบบ PDF สวัสดีครับ ทดสอบระบบ PDF สวัสดีครับ ทดสอบระบบ PDF สวัสดีครับ ทดสอบระบบ PDF สวัสดีครับ ทดสอบระบบ PDF สวัสดีครับ ทดสอบระบบ PDF สวัสดีครับ ทดสอบระบบ PDF สวัสดีครับ ทดสอบระบบ PDF สวัสดีครับ ทดสอบระบบ PDF'),
(175, 8, 'ครุภัณฑประจำห้องสำนักงานศูนย์อนุรักษ์และพัฒนาทรัพยากร ภาคตะวันออกเฉียงเหนือตอนกลาง ตำบลหนองระเวียง อำเภอเมืองนครราชสีมา จังหวัดนครราชสีมา จำนวน 1 ชุด', 'มหาวิทยาลัยเทคโนโลยีราชมงคลอีสาน', 'ศูนย์อนุรักษ์และพัฒนาทรัพยากรภาคตะวันออกเฉียงเหนือตอนกลาง', 'คิมหัน พันปักษา', 'นักวิชาการศึกษา', '0987654321', '0234567890', 'kimhan@gmail.com', 'single', NULL, '2568', 1000000, 200000, 'งบประมาณแผ่นดิน', '', 'โครงการอนุรักษ์พันธุกรรมพืชอันเนื่องมาจากพระราชดำริสมเด็จพระเทพรัตนราชสุดาฯ สยามบรมราชกุมารี (อพ.สธ.) เป็นโครงการที่สมเด็จพระกนิษฐาธิราชเจ้า กรมสมเด็จพระเทพรัตนราชสุดาฯ สยามบรมราชกุมารี ทรงสืบสานพระราชปณิธานในการอนุรักษ์ทรัพยากรของพระบาทสมเด็จพระบรมชนกาธิเบศร มหาภูมิพลอดุลยเดชมหาราช บรมนาถบพิตร ซึ่งทรงมีสายพระเนตรยาวไกล โดยที่พระบาทสมเด็จพระบรมชนกาธิเบศร มหาภูมิพลอดุลยเดชมหาราช บรมนาถบพิตร ทรงให้ความสำคัญและเห็นความสำคัญของการอนุรักษ์พันธุกรรมพืช เพื่อเป็นแหล่งศึกษา และทรงมีโครงการพระราชดำริที่เกี่ยวกับการอนุรักษ์พัฒนาทรัพยากร พัฒนาแหล่งน้ำ การอนุรักษ์และพัฒนา ตลอดจนอนุรักษ์ทรัพยากรป่าไม้ เป็นการอนุรักษ์และพัฒนาทรัพยากรธรรมชาติ มีหน่วยงานต่างๆ ร่วมสนองพระราชดำริ เพื่อการบริหารจัดการความรู้ ผลงานวิจัย นวัตกรรม สิ่งประดิษฐ์ ทรัพยากร และภูมิปัญญาของประเทศ สู่การใช้ประโยชน์เชิงพาณิชย์และสาธารณะด้วยยุทธวิธีที่เหมาะสม ที่เข้าถึงประชาชนและประชาสังคมอย่างแพร่หลาย ให้มีแนวทางดำเนินงานต่อเนื่องตามกรอบแผนแม่บท โดยเน้นการทำงานเข้าไปสร้างจิตสำนึกในการรักษาทรัพยากรตั้งแต่ในสถานศึกษา ดำเนินงานในระดับท้องถิ่นในการทำฐานข้อมูลทรัพยากรท้องถิ่น ซึ่งประกอบด้วย 3 ฐานทรัพยากร ได้แก่ ทรัพยากรชีวภาพ ทรัพยากรกายภาพ และทรัพยากรวัฒนธรรมและภูมิปัญญา จากฐานข้อมูลดังกล่าวจะนำไปสู่การอนุรักษ์และใช้ประโยชน์อย่างยั่งยืนบนพื้นฐานของการมีจิตสำนึกในการอนุรักษ์ทรัพยากรที่มีอยู่ในประเทศไทยต่อไป เนื่องด้วยเครื่องคอมพิวเตอร์สำนักงานศูนย์อนุรักษ์และพัฒนาทรัพยากรภาคตะวันออกเฉียงเหนือตอนกลาง ที่ใช้ดำเนินงานอยู่ในปัจจุบันนั้นจัดซื้อตั้งแต่ปีงบประมาณ พ.ศ. 2555 ส่งผลให้ครุภัณฑ์ที่ใช้ดำเนินงานนั้นสภาพชำรุด ใช้งานได้บางส่วน และส่งผลต่อประสิทธิภาพและความรวดเร็วในการดำเนินภารกิจของหน่วยงานข้างต้น ศูนย์อนุรักษ์ฯ พิจารณาและเห็นควรต้องจัดหาใหม่เพื่อทดแทนของเดิม ทั้งยังต้องรองรับหน่วยงานหรือบุคคลภายนอกหน่วยงานเพื่อให้บริการวิชาการ และการดำเนินงานตามกรอบกิจกรรมการดำเนินงาน อพ.สธ. (ภายใต้กรอบการดำเนินงาน 3 กรอบ 8 กิจกรรม) เพื่อให้บุคลากรสามารถใช้ปฏิบัติงานได้อย่างเต็มประสิทธิภาพ สามารถให้บริการวิชาการเกี่ยวกับโครงการอนุรักษ์พันธุกรรมพืชฯ สนองพระราชดำริ ตามพันธกิจและแผนยุทธศาสตร์ของมหาวิทยาลัยเทคโนโลยีราชมงคลอีสาน และโครงการอนุรักษ์พันธุกรรมพืชอันเนื่องมาจากพระราชดำริฯ (อพ.สธ.)', 'เพื่อเป็นครุภัณฑ์ทดแทนเครื่องคอมพิวเตอร์ เพื่อให้มีความสมบูรณ์พร้อมใช้งานตลอดเวลา ประจำหน่วยงานในสังกัดศูนย์อนุรักษ์และพัฒนาทรัพยากรภาคตะวันออกเฉียงเหนือตอนกลาง มหาวิทยาลัยเทคโนโลยีราชมงคลอีสาน จังหวัดนครราชสีมา เพื่อเพิ่มประสิทธิภาพในการทำงาน ให้การบริหารจัดการบริการวิชาการ การดำเนินงานตามกรอบการดำเนินงานของโครงการอนุรักษ์พันธุกรรมพืชอันเนื่องมาจากพระราชดำริ (อพ.สธ.) ที่เสนอพระราชดำริโดยมหาวิทยาลัยเทคโนโลยีราชมงคลอีสาน ให้เกิดประสิทธิภาพและเกิดประโยชน์สูงสุดแก่มหาวิทยาลัยและชุมชนใกล้เคียง', '1.เครื่องคอมพิวเตอร์ All-in-One สำหรับงานสำนักงาน จำนวน 7 เครื่อง\r\n2.เครื่องคอมพิวเตอร์ All-in-One สำหรับงานประมวลผล จำนวน 1 เครื่อง\r\n3.เครื่องคอมพิวเตอร์โน้ตบุ๊ก สำหรับงานสำนักงาน จำนวน 2 เครื่อง\r\n4.เครื่องพิมพ์เลเซอร์ หรือ LED สี ชนิด Network (แบบที่ 2) จำนวน 1 เครื่อง\r\n5.เครื่องพิมพ์ Multifunction เลเซอร์ หรือ LED ขาว-ดำ จำนวน 1 เครื่อง\r\n6.เครื่องสำรองไฟฟ้า (UPS) ขนาด 800 VA จำนวน 10 เครื่อง', 'ได้เครื่องคอมพิวเตอร์และอุปกรณ์สำหรับใช้งานที่มีประสิทธิภาพ เพื่อสนับสนุนการดำเนินงานให้บรรลุตามเป้าหมายของภารกิจโครงการอนุรักษ์พันธุกรรมพืชฯ อพ.สธ. - มทร.อีสาน', 'ขยายระบบเดิม', '', 6000000, 'แบบฟอร์มการจัดหาระบบคอมพิวเตอร์', 'การอนุรักษ์ทรัพยากรที่มีอยู่ในประเทศไทยต่อไป เนื่องด้วยเครื่องคอมพิวเตอร์สำนักงานศูนย์อนุรักษ์และพัฒนาทรัพยากรภาคตะวันออกเฉียงเหนือตอนกลาง ที่ใช้ดำเนินงานอยู่ในปัจจุบันนั้นจัดซื้อตั้งแต่ปีงบประมาณ พ.ศ. 2555 ส่งผลให้ครุภัณฑ์ที่ใช้ดำเนินงานนั้นสภาพชำรุด ใช้งานได้บางส่วน และส่งผลต่อประสิทธิภาพและความรวดเร็วในการดำเนินภารกิจของหน่วยงานข้างต้น ศูนย์อนุรักษ์ฯ พิจารณาและเห็นควรต้องจัดหาใหม่เพื่อทดแทนของเดิม ทั้งยังต้องรองรับหน่วยงานหรือบุคคลภายนอกหน่วยงานเพื่อให้บริการวิชาการ และการดำเนินงานตามกรอบกิจกรรมการดำเนินงาน อพ.สธ. (ภายใต้กรอบการดำเนินงาน 3 กรอบ 8 กิจกรรม) เพื่อให้บุคลากรสามารถใช้ปฏิบัติงานได้อย่างเต็มประสิทธิภาพ สามารถให้บริการวิชาการเกี่ยวกับโครงการอนุรักษ์พันธุกรรมพืชฯ สนองพระราชดำริ ตามพันธกิจและแผนยุทธศาสตร์ของมหาวิทยาลัยเทคโนโลยีราชมงคลอีสาน และโครงการอนุรักษ์พันธุกรรมพืชอันเนื่องมาจากพระราชดำริฯ (อพ.สธ.)', 'การอนุรักษ์ทรัพยากรที่มีอยู่ในประเทศไทยต่อไป เนื่องด้วยเครื่องคอมพิวเตอร์สำนักงานศูนย์อนุรักษ์และพัฒนาทรัพยากรภาคตะวันออกเฉียงเหนือตอนกลาง ที่ใช้ดำเนินงานอยู่ในปัจจุบันนั้นจัดซื้อตั้งแต่ปีงบประมาณ พ.ศ. 2555 ส่งผลให้ครุภัณฑ์ที่ใช้ดำเนินงานนั้นสภาพชำรุด ใช้งานได้บางส่วน และส่งผลต่อประสิทธิภาพและความรวดเร็วในการดำเนินภารกิจของหน่วยงานข้างต้น ศูนย์อนุรักษ์ฯ พิจารณาและเห็นควรต้องจัดหาใหม่เพื่อทดแทนของเดิม ทั้งยังต้องรองรับหน่วยงานหรือบุคคลภายนอกหน่วยงานเพื่อให้บริการวิชาการ และการดำเนินงานตามกรอบกิจกรรมการดำเนินงาน อพ.สธ. (ภายใต้กรอบการดำเนินงาน 3 กรอบ 8 กิจกรรม) เพื่อให้บุคลากรสามารถใช้ปฏิบัติงานได้อย่างเต็มประสิทธิภาพ สามารถให้บริการวิชาการเกี่ยวกับโครงการอนุรักษ์พันธุกรรมพืชฯ สนองพระราชดำริ ตามพันธกิจและแผนยุทธศาสตร์ของมหาวิทยาลัยเทคโนโลยีราชมงคลอีสาน และโครงการอนุรักษ์พันธุกรรมพืชอันเนื่องมาจากพระราชดำริฯ (อพ.สธ.)', NULL, 200003, 'การอนุรักษ์ทรัพยากรที่มีอยู่ในประเทศไทยต่อไป เนื่องด้วยเครื่องคอมพิวเตอร์สำนักงานศูนย์อนุรักษ์และพัฒนาทรัพยากรภาคตะวันออกเฉียงเหนือตอนกลาง ที่ใช้ดำเนินงานอยู่ในปัจจุบันนั้นจัดซื้อตั้งแต่ปีงบประมาณ พ.ศ. 2555 ส่งผลให้ครุภัณฑ์ที่ใช้ดำเนินงานนั้นสภาพชำรุด ใช้งานได้บางส่วน และส่งผลต่อประสิทธิภาพและความรวดเร็วในการดำเนินภารกิจของหน่วยงานข้างต้น ศูนย์อนุรักษ์ฯ พิจารณาและเห็นควรต้องจัดหาใหม่เพื่อทดแทนของเดิม ทั้งยังต้องรองรับหน่วยงานหรือบุคคลภายนอกหน่วยงานเพื่อให้บริการวิชาการ และการดำเนินงานตามกรอบกิจกรรมการดำเนินงาน อพ.สธ. (ภายใต้กรอบการดำเนินงาน 3 กรอบ 8 กิจกรรม) เพื่อให้บุคลากรสามารถใช้ปฏิบัติงานได้อย่างเต็มประสิทธิภาพ สามารถให้บริการวิชาการเกี่ยวกับโครงการอนุรักษ์พันธุกรรมพืชฯ สนองพระราชดำริ ตามพันธกิจและแผนยุทธศาสตร์ของมหาวิทยาลัยเทคโนโลยีราชมงคลอีสาน และโครงการอนุรักษ์พันธุกรรมพืชอันเนื่องมาจากพระราชดำริฯ (อพ.สธ.)', 'การอนุรักษ์ทรัพยากรที่มีอยู่ในประเทศไทยต่อไป เนื่องด้วยเครื่องคอมพิวเตอร์สำนักงานศูนย์อนุรักษ์และพัฒนาทรัพยากรภาคตะวันออกเฉียงเหนือตอนกลาง ที่ใช้ดำเนินงานอยู่ในปัจจุบันนั้นจัดซื้อตั้งแต่ปีงบประมาณ พ.ศ. 2555 ส่งผลให้ครุภัณฑ์ที่ใช้ดำเนินงานนั้นสภาพชำรุด ใช้งานได้บางส่วน และส่งผลต่อประสิทธิภาพและความรวดเร็วในการดำเนินภารกิจของหน่วยงานข้างต้น ศูนย์อนุรักษ์ฯ พิจารณาและเห็นควรต้องจัดหาใหม่เพื่อทดแทนของเดิม ทั้งยังต้องรองรับหน่วยงานหรือบุคคลภายนอกหน่วยงานเพื่อให้บริการวิชาการ และการดำเนินงานตามกรอบกิจกรรมการดำเนินงาน อพ.สธ. (ภายใต้กรอบการดำเนินงาน 3 กรอบ 8 กิจกรรม) เพื่อให้บุคลากรสามารถใช้ปฏิบัติงานได้อย่างเต็มประสิทธิภาพ สามารถให้บริการวิชาการเกี่ยวกับโครงการอนุรักษ์พันธุกรรมพืชฯ สนองพระราชดำริ ตามพันธกิจและแผนยุทธศาสตร์ของมหาวิทยาลัยเทคโนโลยีราชมงคลอีสาน และโครงการอนุรักษ์พันธุกรรมพืชอันเนื่องมาจากพระราชดำริฯ (อพ.สธ.)'),
(176, 8, 'ครุภัณฑ์ประจำห้องสำนักงานศูนย์อนุรักษ์และพัฒนาทรัพยากร ภาคตะวันออกเฉียงเหนือตอนกลาง ตำบลหนองระเวียง อำเภอเมืองนครราชสีมา จังหวัดนครราชสีมา จำนวน 1 ชุด', 'มหาวิทยาลัยเทคโนโลยีราชมงคลอีสาน', 'ศูนย์อนุรักษ์และพัฒนาทรัพยากรภาคตะวันออกเฉียงเหนือตอนกลาง', 'นายสมคิด เดชมะเริง', 'นักวิชาการศึกษา', '0987654321', '0234567890', 'user@gmail.com', 'single', NULL, '2568', 1500000, 20000, 'งบประมาณแผ่นดิน', '', 'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa', 'bbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbb', '1. a\r\n2. b\r\n3. c\r\n4. d\r\n5. f', 'ccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccc', 'จัดหาใหม่', '', 522222222, 'แบบฟอร์มการจัดหาระบบคอมพิวเตอร์', 'แบบฟอร์มการจัดหาระบบคอมพิวเตอร์แบบฟอร์มการจัดหาระบบคอมพิวเตอร์แบบฟอร์มการจัดหาระบบคอมพิวเตอร์แบบฟอร์มการจัดหาระบบคอมพิวเตอร์', 'แบบฟอร์มการจัดหาระบบคอมพิวเตอร์แบบฟอร์มการจัดหาระบบคอมพิวเตอร์แบบฟอร์มการจัดหาระบบคอมพิวเตอร์แบบฟอร์มการจัดหาระบบคอมพิวเตอร์vbvb', NULL, 56456, 'mmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmm', 'mmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmm');

-- --------------------------------------------------------

--
-- Table structure for table `installation_places`
--

CREATE TABLE `installation_places` (
  `id` int NOT NULL,
  `form_id` int NOT NULL,
  `item` varchar(255) DEFAULT NULL,
  `quantity` varchar(50) DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `installation_places`
--

INSERT INTO `installation_places` (`id`, `form_id`, `item`, `quantity`, `location`) VALUES
(45, 173, 'สวัสดีครับ ทดสอบระบบ PDF 1', '2', 'สวัสดีครับ ทดสอบระบบ PDF00'),
(46, 173, 'สวัสดีครับ ทดสอบระบบ PDF 2', '4', 'สวัสดีครับ ทดสอบระบบ PDFppp'),
(48, 175, 'แบบฟอร์มการจัดหาระบบคอมพิวเตอร์', '3', 'มหาวิทยาลัยเทคโนโลยีราชมงคลอีสาน'),
(49, 176, 'แบบฟอร์มการจัดหาระบบคอมพิวเตอร์', '3', 'ร.ร บ้านกรวดวิทยาคาร'),
(50, 176, 'แบบฟอร์มการจัดหาระบบคอมพิวเตอร์', '4', 'ร.ร บ้านกรวดวิทยาคาร');

-- --------------------------------------------------------

--
-- Table structure for table `it_personnel`
--

CREATE TABLE `it_personnel` (
  `id` int NOT NULL,
  `form_id` int DEFAULT NULL,
  `position_name` varchar(255) DEFAULT NULL,
  `quantity` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `it_personnel`
--

INSERT INTO `it_personnel` (`id`, `form_id`, `position_name`, `quantity`) VALUES
(33, 105, 'ผปแ', 56),
(34, 105, 'ิิกก', 55),
(35, 107, 'หหกด', 2),
(36, 108, 'ฟหก', 6656),
(37, 109, 'xcv', 45345),
(38, 110, 'sdfs', 4546),
(39, 111, 'dfg', 435345),
(40, 112, 'dfg', 435345),
(41, 113, 'sdcsd', 234),
(42, 114, 'sdf', 3545),
(43, 115, 'sdf', 3545),
(44, 116, 'sdf', 3545),
(45, 117, 'sdf', 3545),
(46, 118, 'sdf', 34),
(47, 119, 'asd', 324),
(48, 120, 'wfwfwf', 34224),
(49, 120, '4234', 23423),
(50, 121, 'ไม่มี', 1323),
(51, 121, 'aA', 511),
(52, 122, 'ฟหก', 34433),
(53, 123, 'asd', 0),
(54, 124, 'dfd', 545),
(55, 125, '5675', 675),
(56, 126, 'fdg', 435),
(57, 127, 'sdf', 12),
(58, 130, 'ฟหก', 12),
(59, 134, 'd', 3),
(60, 135, 'ฟหก', 574574),
(61, 135, 'fdgf', 4574),
(62, 136, 'asdasd', 234),
(63, 137, 'sads', 4534),
(64, 137, 'saf', 56),
(65, 138, 'asd', 324),
(66, 139, 'asd', 34),
(67, 140, 'asdsd', 234),
(68, 141, 'asdas', 4324),
(69, 142, 'asd', 3),
(70, 143, 'sdf', 453),
(71, 144, 'asd', 33),
(72, 145, 'asda', 234),
(73, 146, '5252', 45),
(74, 156, 'asd', 4),
(75, 157, 'sada', 34),
(76, 158, 'sad', 32),
(77, 159, 'ฟหก', 123),
(78, 161, 'นักศึกษา', 5),
(79, 162, 'ฟหก', 22),
(80, 163, 'sd', 323),
(81, 164, 'แบบฟอร์มการจัดหาระบบคอมพิวเตอร์', 222),
(82, 165, 'enctype=\"multipart/form-data\"', 33),
(83, 162, 'ฟหก', 21),
(84, 167, 'ฟหก', 22),
(85, 162, 'as', 23),
(86, 169, 'ชำนาญการ', 100),
(87, 170, '5252', 2),
(88, 171, 'ฟหก', 3),
(89, 172, 'fbb', 3),
(90, 172, 'vv', 44),
(91, 173, 'นักศึกษา', 5),
(92, 173, 'ครู', 3),
(93, 174, 'นักวิชาการศึกษา (ปริญญาตรี สาขาวิทยาการคอมพิวเตอร์)', 1),
(94, 175, 'นักวิชาการศึกษา (ปริญญาตรี สาขาวิทยาการคอมพิวเตอร์)', 2),
(95, 176, 'นักวิชาการศึกษา (ปริญญาตรี สาขาวิทยาการคอมพิวเตอร์)', 5);

-- --------------------------------------------------------

--
-- Table structure for table `methods_of_procurement`
--

CREATE TABLE `methods_of_procurement` (
  `id` int NOT NULL,
  `form_id` int NOT NULL,
  `method` varchar(255) NOT NULL,
  `other_detail` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `methods_of_procurement`
--

INSERT INTO `methods_of_procurement` (`id`, `form_id`, `method`, `other_detail`) VALUES
(42, 173, 'อื่น ๆ', 'สวัสดีครับ ทดสอบระบบ PDF'),
(44, 175, 'การจ้าง', NULL),
(45, 176, 'อื่น ๆ', 'เทสๆ');

-- --------------------------------------------------------

--
-- Table structure for table `multi_year_budget`
--

CREATE TABLE `multi_year_budget` (
  `id` int NOT NULL,
  `form_id` int NOT NULL,
  `budget_year` varchar(10) NOT NULL,
  `budget_amount` bigint DEFAULT NULL,
  `ict_budget_amount` bigint NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `multi_year_budget`
--

INSERT INTO `multi_year_budget` (`id`, `form_id`, `budget_year`, `budget_amount`, `ict_budget_amount`) VALUES
(75, 173, '2568', 10000, 5000);

-- --------------------------------------------------------

--
-- Table structure for table `news_announcements`
--

CREATE TABLE `news_announcements` (
  `id` int NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text,
  `category` enum('urgent','general') DEFAULT 'general',
  `file_path` varchar(255) DEFAULT NULL,
  `is_pinned` tinyint(1) DEFAULT '0',
  `status` enum('active','inactive') DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `news_announcements`
--

INSERT INTO `news_announcements` (`id`, `title`, `content`, `category`, `file_path`, `is_pinned`, `status`, `created_at`) VALUES
(2, 'xx', 'xxx', 'general', NULL, 0, 'active', '2026-02-04 14:32:08'),
(3, 'ss', 'ss', 'general', NULL, 0, 'active', '2026-02-04 14:32:17'),
(4, 'dd', 'dd', 'general', NULL, 1, 'active', '2026-02-04 14:32:22'),
(5, 'ff', 'ff', 'general', NULL, 0, 'active', '2026-02-04 14:32:25');

-- --------------------------------------------------------

--
-- Table structure for table `policy_alignment`
--

CREATE TABLE `policy_alignment` (
  `id` int NOT NULL,
  `form_id` int NOT NULL,
  `policy_key` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `other_detail` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `policy_alignment`
--

INSERT INTO `policy_alignment` (`id`, `form_id`, `policy_key`, `other_detail`) VALUES
(54, 105, '999', NULL),
(55, 105, '999', NULL),
(56, 105, '999', NULL),
(57, 107, '999', NULL),
(58, 107, '999', NULL),
(59, 107, '999', NULL),
(60, 108, '999', NULL),
(61, 109, '999', NULL),
(62, 110, '999', NULL),
(63, 111, '999', NULL),
(64, 112, '999', NULL),
(65, 113, '999', NULL),
(66, 114, '999', NULL),
(67, 115, '999', NULL),
(68, 116, '999', NULL),
(69, 117, '999', NULL),
(70, 118, '999', NULL),
(71, 119, '999', '234'),
(72, 120, '999', NULL),
(73, 120, '999', NULL),
(74, 120, '999', NULL),
(75, 121, '999', NULL),
(76, 121, '999', NULL),
(77, 121, '999', NULL),
(78, 122, '999', NULL),
(79, 123, '999', NULL),
(80, 124, '999', NULL),
(81, 125, '999', NULL),
(82, 126, '999', NULL),
(83, 127, '999', NULL),
(84, 127, '999', NULL),
(85, 128, '999', NULL),
(86, 129, '999', NULL),
(87, 130, '999', NULL),
(88, 134, '999', NULL),
(89, 135, '999', NULL),
(90, 135, '999', NULL),
(91, 136, '999', NULL),
(92, 137, '999', NULL),
(93, 137, '999', NULL),
(94, 137, '999', NULL),
(95, 138, 'national_strategy', NULL),
(96, 138, 'digital_economy_plan', NULL),
(97, 138, 'agency_digital_action_plan', NULL),
(98, 139, 'national_strategy', NULL),
(99, 139, 'digital_economy_plan', NULL),
(100, 139, 'agency_digital_action_plan', NULL),
(101, 140, 'national_strategy', NULL),
(102, 140, 'digital_economy_plan', NULL),
(103, 140, 'agency_digital_action_plan', NULL),
(104, 141, 'national_strategy', NULL),
(105, 141, 'digital_economy_plan', NULL),
(106, 141, 'agency_digital_action_plan', NULL),
(107, 142, 'national_strategy', NULL),
(108, 142, 'ministry_digital_plan', NULL),
(109, 143, 'ministry_digital_plan', NULL),
(110, 144, 'digital_economy_plan', NULL),
(111, 145, 'digital_economy_plan', NULL),
(112, 146, 'national_strategy', NULL),
(113, 146, 'digital_economy_plan', NULL),
(114, 146, 'agency_digital_action_plan', NULL),
(115, 156, 'national_strategy', NULL),
(116, 156, 'digital_economy_plan', NULL),
(117, 156, 'ministry_digital_plan', NULL),
(118, 157, 'national_strategy', NULL),
(119, 157, 'digital_economy_plan', NULL),
(120, 157, 'agency_digital_action_plan', NULL),
(121, 158, 'national_strategy', NULL),
(122, 158, 'ministry_digital_plan', NULL),
(123, 159, 'digital_economy_plan', NULL),
(124, 159, 'ministry_digital_plan', NULL),
(125, 161, 'ministry_digital_plan', NULL),
(126, 162, 'digital_economy_plan', NULL),
(127, 163, 'ministry_digital_plan', NULL),
(128, 164, 'digital_economy_plan', NULL),
(129, 165, 'digital_economy_plan', NULL),
(130, 162, 'digital_economy_plan', NULL),
(131, 167, 'digital_economy_plan', NULL),
(132, 162, 'ministry_digital_plan', NULL),
(133, 169, 'ministry_digital_plan', NULL),
(134, 170, 'national_strategy', NULL),
(135, 171, 'digital_economy_plan', NULL),
(136, 172, 'agency_digital_action_plan', NULL),
(137, 172, 'other', 'afg'),
(138, 173, 'national_strategy', NULL),
(139, 173, 'ministry_digital_plan', NULL),
(140, 173, 'other', 'สวัสดีครับ ทดสอบระบบ PDF'),
(141, 174, 'national_strategy', NULL),
(142, 174, 'digital_economy_plan', NULL),
(143, 174, 'agency_digital_action_plan', NULL),
(144, 175, 'national_strategy', NULL),
(145, 175, 'ministry_digital_plan', NULL),
(146, 175, 'agency_digital_action_plan', NULL),
(147, 176, 'digital_economy_plan', NULL),
(148, 176, 'ministry_digital_plan', NULL),
(149, 176, 'agency_digital_action_plan', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `procurement_items`
--

CREATE TABLE `procurement_items` (
  `id` int NOT NULL,
  `form_id` int NOT NULL,
  `item_name` text,
  `item_quantity` int DEFAULT NULL,
  `unit_price` decimal(10,2) DEFAULT NULL,
  `total_price` decimal(10,2) DEFAULT NULL,
  `item_specification` text,
  `item_additional_detail` text,
  `ict_criteria` text,
  `ict_standard_detail` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `procurement_items`
--

INSERT INTO `procurement_items` (`id`, `form_id`, `item_name`, `item_quantity`, `unit_price`, `total_price`, `item_specification`, `item_additional_detail`, `ict_criteria`, `ict_standard_detail`) VALUES
(31, 105, 'ผปแ', 5645, 4554.00, 45445.00, '4545', '454545', 'compliant', ''),
(32, 107, 'กหด', 525, 252.00, 52525.00, 'หกฟหก', 'ฟหกฟ', 'compliant', ''),
(33, 108, 'ฟหกฟ', 557, 5757.00, 57575.00, '75757', '5757', 'compliant', ''),
(34, 109, 'asdas', 34534, 3453.00, 4535.00, '353', '535', 'compliant', ''),
(35, 110, 'sad', 3242, 3424.00, 2342.00, '342', '2342', 'no_criteria', ''),
(36, 111, '345', 345, 345.00, 345.00, '345', '345', 'no_criteria', ''),
(37, 112, '345', 345, 345.00, 345.00, '345', '345', 'no_criteria', ''),
(38, 113, '234', 4234, 23423.00, 42.00, '234', '234', 'compliant', ''),
(39, 114, '345', 345, 345.00, 345.00, '345', '34545', 'compliant', ''),
(40, 115, '345', 345, 345.00, 345.00, '345', '34545', 'compliant', ''),
(41, 116, '345', 345, 345.00, 345.00, '345', '34545', 'compliant', ''),
(42, 117, '345', 345, 345.00, 345.00, '345', '34545', 'compliant', ''),
(43, 118, '34', 324, 234.00, 234.00, '234', '234', 'no_criteria', ''),
(44, 119, '234', 234, 234.00, 234.00, '234', '24', 'compliant', ''),
(45, 120, '234', 2342, 3423.00, 4234.00, '234', '234234', 'no_criteria', ''),
(46, 120, '324', 23423, 423423.00, 4234.00, '23423', '234234', 'compliant', ''),
(47, 121, 'ไม่มี', 1545, 4565.00, 5355.00, '252', '5252', 'compliant', ''),
(48, 121, 'ไม่มี', 23423, 234.00, 234234.00, '234', '234', 'no_criteria', ''),
(49, 122, 'sdsds', 32423, 423423.00, 4234.00, '234', '234234', 'compliant', ''),
(50, 123, 'asd', 435, 5345.00, 4353.00, '45353', '45345345', 'no_criteria', ''),
(51, 124, 'dsf', 45, 534534.00, 5.00, '45345', '345345', 'no_criteria', ''),
(52, 125, '567', 567, 567.00, 567.00, '5675', '67', 'compliant', ''),
(53, 126, '345', 345, 345.00, 345.00, '435', '345345', 'compliant', ''),
(54, 127, 'ไม่มี', 12, 123.00, 123.00, 'dsfg', 'sdf', 'no_criteria', ''),
(55, 128, 'sad', 34, 234.00, 234.00, '2342', '42342', 'no_criteria', ''),
(56, 129, 'asd', 324, 234.00, 23.00, '234', '234', 'compliant', ''),
(57, 130, 'ไม่มี', 123, 123.00, 123.00, '123123', '123', 'no_criteria', ''),
(58, 134, '3', 33, 3.00, 3.00, '3', '3', 'no_criteria', ''),
(59, 135, '2552', 5467, 56546.00, 54645.00, 'fgdhdsg', 'sdgs', 'no_criteria', ''),
(60, 136, 'asd', 3, 2342.00, 324.00, 'dsfsdf', 'sdfsd', 'no_criteria', ''),
(61, 137, '2552', 344, 34234.00, 32423.00, 'dfsdf', 'sdfsdf', 'compliant', ''),
(62, 137, 'sad', 34, 234.00, 234.00, 'dfsdf', 'dsfsdf', 'compliant', ''),
(63, 138, 'asdas', 34, 234.00, 234.00, 'sadasd', 'asdas', 'compliant', ''),
(64, 139, 'asd', 324, 3244.00, 3242.00, 'sd', 'asd', 'compliant', ''),
(65, 140, 'sdd', 2342, 2342.00, 234.00, 'dsfsd', 'sdf', '', ''),
(66, 141, 'asd', 45, 345.00, 345.00, '345', '345', 'compliant', ''),
(67, 142, 'asd', 324, 324.00, 234.00, 'asda', '324', 'compliant', ''),
(68, 143, 'dsf', 435, 345.00, 345.00, 'fedgdf', 'ggdfg', 'compliant', ''),
(69, 144, 'asd', 3, 324.00, 342.00, 'asdf', 'sfa', 'compliant', ''),
(70, 145, 'asdas', 34, 234.00, 234.00, 'asdfaf', 'dsfsdf', 'compliant', ''),
(71, 146, '2552', 345, 345.00, 345.00, 'dfgsdf', 'sdfs', 'compliant', ''),
(72, 156, 'fdgd', 435, 45.00, 345.00, 'edgs', 'gdgs', 'compliant', ''),
(73, 157, 'asd', 342, 345.00, 45.00, 'sdfs', 'sdfs', 'compliant', ''),
(74, 158, 'sdsds', 4, 345.00, 43.00, 'sdfss', 'dsfsdf', 'compliant', ''),
(75, 159, 'แบบฟอร์มการจัดหาระบบคอมพิวเตอร์ และอุปกรณ์', 3232, 5645456.00, 51512.00, 'แบบฟอร์มการจัดหาระบบคอมพิวเตอร์ และอุปกรณ์', 'แบบฟอร์มการจัดหาระบบคอมพิวเตอร์ และอุปกรณ์', 'compliant', ''),
(76, 161, 'แบบฟอร์มการจัดหาระบบคอมพิวเตอร์', 2, 32145.00, 4545.00, 'แบบฟอร์มการจัดหาระบบคอมพิวเตอร์', 'แบบฟอร์มการจัดหาระบบคอมพิวเตอร์', 'compliant', ''),
(77, 163, '23', 32, 2332.00, 23.00, 'asds', 'แบบฟอร์มการจัดหาระบบคอมพิวเตอร์', 'compliant', ''),
(78, 164, 'แบบฟอร์มการจัดหาระบบคอมพิวเตอร์', 2, 2.00, 1.00, 'แบบฟอร์มการจัดหาระบบคอมพิวเตอร์', 'แบบฟอร์มการจัดหาระบบคอมพิวเตอร์', 'compliant', ''),
(79, 165, 'enctype=\"multipart/form-data\"', 34, 344.00, 43.00, 'enctype=\"multipart/form-data\"', 'enctype=\"multipart/form-data\"', 'compliant', ''),
(80, 162, '12', 12, 12.00, 12.00, '12', '21', 'compliant', ''),
(81, 167, 'แบบฟอร์มการจัดหาระบบคอมพิวเตอร์ ', 22, 22.00, 22.00, 'แบบฟอร์มการจัดหาระบบคอมพิวเตอร์ ', 'แบบฟอร์มการจัดหาระบบคอมพิวเตอร์ ', 'compliant', ''),
(82, 162, 'แบบฟอร์มการจัดหาระบบคอมพิวเตอร์ ', 34, 324.00, 2342.00, 'แบบฟอร์มการจัดหาระบบคอมพิวเตอร์ ', 'แบบฟอร์มการจัดหาระบบคอมพิวเตอร์ ', 'compliant', ''),
(83, 169, 'คอมพิวเตอร์', 100, 24000.00, 24000.00, 'เทียบเท่า', 'ไม่มี', 'compliant', ''),
(84, 170, 'แบบฟอร์มการจัดหาระบบคอมพิวเตอร์ และอุปกรณ์', 234, 2323.00, 32.00, 'fds', 'แบบฟอร์มการจัดหาระบบคอมพิวเตอร์', 'compliant', ''),
(85, 171, 'sda', 23, 23.00, 4.00, 'asaf', 'asf', 'compliant', ''),
(86, 172, 'ds', 453, 345.00, 3453.00, 'sadca', 'cdscds', 'compliant', ''),
(87, 172, 'sd', 34, 234.00, 65.00, 'dfs', 'sdfs', 'compliant', ''),
(88, 173, 'สวัสดีครับ ทดสอบระบบ PDF 1', 10, 5000.00, 500.00, 'สวัสดีครับ ทดสอบระบบ PDF สวัสดีครับ ทดสอบระบบ PDF สวัสดีครับ ทดสอบระบบ PDF สวัสดีครับ ทดสอบระบบ PDF สวัสดีครับ ทดสอบระบบ PDF สวัสดีครับ ทดสอบระบบ PDF สวัสดีครับ ทดสอบระบบ PDF สวัสดีครับ ทดสอบระบบ PDF', 'สวัสดีครับ ทดสอบระบบ PDF สวัสดีครับ ทดสอบระบบ PDF สวัสดีครับ ทดสอบระบบ PDF สวัสดีครับ ทดสอบระบบ PDF สวัสดีครับ ทดสอบระบบ PDF สวัสดีครับ ทดสอบระบบ PDF', 'compliant', ''),
(89, 173, 'สวัสดีครับ ทดสอบระบบ PDF 2', 5, 2500.00, 25.00, 'สวัสดีครับ ทดสอบระบบ PDF สวัสดีครับ ทดสอบระบบ PDF สวัสดีครับ ทดสอบระบบ PDF สวัสดีครับ ทดสอบระบบ PDF สวัสดีครับ ทดสอบระบบ PDF', 'สวัสดีครับ ทดสอบระบบ PDF สวัสดีครับ ทดสอบระบบ PDF สวัสดีครับ ทดสอบระบบ PDF สวัสดีครับ ทดสอบระบบ PDF สวัสดีครับ ทดสอบระบบ PDF สวัสดีครับ ทดสอบระบบ PDF', 'compliant', ''),
(90, 174, 'เครื่องคอมพิวเตอร์ All-in-One สำหรับงานสำนักงาน', 7, 20000.00, 140000.00, '1. มีหน่วยประมวลผลกลาง (CPU) ไม่น้อยกว่า 4 แกนหลัก (4 core) และ 8 แกนเสมือน (😎 Thread)และมีเทคโนโลยีเพิ่มสัญญาณนาฬิกาได้ในกรณีที่ต้องใช้ความสามารถในการ ประมวลผลสูง (Turbo Boost หรือ Max Boost) โดยมีความเร็วสัญญาณนาฬิกาสูงสุด ไม่ น้อยกว่า 3.7 GHz จำนวน 1 หน่วย\n\n2. หน่วยประมวลผลกลาง (CPU) มีหน่วยความจำ แบบ Cache Memory รวมในระดับ (Level) เดียวกันขนาดไม่น้อยกว่า 4 MB\n3. มีหน่วยความจำหลัก (RAM) ชนิด DDR4 หรือดีกว่า มีขนาดไม่น้อยกว่า 8 GB\n4. มีหน่วยจัดเก็บข้อมูล ชนิด Solid State Drive ขนาดความจุไม่น้อยกว่า 250 GB จำนวน 1 หนวย\n5. มีช่องเชื่อมต่อระบบเครือข่าย (Network Interface) แบบ 10/100/1000 Base-T หรือดีกว่า จํานวนไม่น้อยกว่า 1 ของ\n6. มีของเชื่อมต่อ (Interface) แบบ USB 2.0 หรือดีกว่า ไม่น้อยกว่า 3 ของ\n7. มีแป้นพิมพ์และเมาส์\n8. มีจอแสดงภาพในตัว และมีขนาดไม่น้อยกว่า 21 นิ้ว ความละเอียดแบบ FHD (1920x1080)\n9. สามารถใช้งานได้ไม่น้อยกว่า Wi-Fi (IEEE 802.11 ac) และ Bluetooth\n10. มีระบบปฏิบัติการ สำหรับคอมพิวเตอร์ที่จัดหาที่มีลิขสิทธิ์ถูกต้องตามกฎหมายและสามารถ อับเกรดได้ตามระบบปฏิบัติการที่มหาวิทยาลัยจัดหา\n11. มีการรับประกันผลิตภัณฑ์ (อุปกรณ์ประกอบด้วย ตัวเครื่อง (Chassis), จอภาพ (Monitor) เป็นเวลาไม่น้อยกว่า 3 ปี', '1. ต้องทำการส่งมอบพร้อมติดตั้ง กล้อง Web Cam ระดับ FULL HD จำนวน 7 เครื่อง ให้กับ ทางหน่วยงาน เพื่อใช้ร่วมกับเครื่องคอมพิวเตอร์ที่ทำการจัดซื้อในครั้งนี้ โดยไม่คิดค่าใช้จ่าย ใด ๆ เพิ่มเติมกับทางหน่วยงาน\r\n2. ต้องดำเนินการส่งมอบพร้อมติดตั้งโปรแกรมระบบปฏิบัติการ สำหรับพร้อมใช้งาน\r\n3. ต้องส่งมอบรายละเอียด “ครุภัณฑ์เครื่องคอมพิวเตอร์ All in one สำหรับงานสำนักงาน” ทั้งหมด ซึ่งจะต้องมีข้อมูลดังต่อไปนี้เป็นอย่างน้อย ได้แก่ ชื่อ รุ่น ยี่ห้อ ราคาต่อหน่วย ชื่อบริษัทผู้ผลิต หมายเลขประจำเครื่อง (Serial No.) วันที่รับประกัน วันที่หมดรับประกัน ฯลฯ (ข้อมูลที่มีจริง) โดยแนบพร้อมวันส่งมอบ\r\n4. มีศูนย์บริการหลังการขายของเจ้าของผลิตภัณฑ์หรือศูนย์บริการที่ได้รับการแต่งตั้งจาก เจ้าของผลิตภัณฑ์ เพื่อประโยชน์ในการให้บริการหลังการขาย', 'compliant', ''),
(91, 175, 'เครื่องคอมพิวเตอร์ All-in-One สำหรับงานสำนักงาน', 7, 500000.00, 522000.00, '1.มีหน่วยประมวลผลกลาง (CPU) ไม่น้อยกว่า 4 แกนหลัก (4 Core) และ 8 แกนเสมือน (8 Thread) และมีเทคโนโลยีเพิ่มความเร็วสัญญาณนาฬิกาอัตโนมัติในกรณีที่ต้องใช้พลังประมวลผลสูง (Turbo Boost หรือ Max Boost) โดยมีความเร็วสัญญาณนาฬิกาสูงสุดไม่น้อยกว่า 3.7 GHz จำนวน 1 หน่วย\r\n2.หน่วยประมวลผลกลาง (CPU) มีหน่วยความจำแบบ Cache Memory รวมในระดับเดียวกัน (Level) ไม่น้อยกว่า 4 MB\r\n3.มีหน่วยความจำหลัก (RAM) ชนิด DDR4 หรือดีกว่า ขนาดไม่น้อยกว่า 8 GB\r\n4.มีหน่วยจัดเก็บข้อมูลชนิด Solid State Drive (SSD) ขนาดความจุไม่น้อยกว่า 250 GB จำนวน 1 หน่วย\r\n5.มีช่องเชื่อมต่อระบบเครือข่าย (Network Interface) แบบ 10/100/1000 Base-T หรือดีกว่า ไม่น้อยกว่า 1 ช่อง', 'การอนุรักษ์ทรัพยากรที่มีอยู่ในประเทศไทยต่อไป เนื่องด้วยเครื่องคอมพิวเตอร์สำนักงานศูนย์อนุรักษ์และพัฒนาทรัพยากรภาคตะวันออกเฉียงเหนือตอนกลาง ที่ใช้ดำเนินงานอยู่ในปัจจุบันนั้นจัดซื้อตั้งแต่ปีงบประมาณ พ.ศ. 2555 ส่งผลให้ครุภัณฑ์ที่ใช้ดำเนินงานนั้นสภาพชำรุด ใช้งานได้บางส่วน และส่งผลต่อประสิทธิภาพและความรวดเร็วในการดำเนินภารกิจของหน่วยงานข้างต้น ศูนย์อนุรักษ์ฯ พิจารณาและเห็นควรต้องจัดหาใหม่เพื่อทดแทนของเดิม ทั้งยังต้องรองรับหน่วยงานหรือบุคคลภายนอกหน่วยงานเพื่อให้บริการวิชาการ และการดำเนินงานตามกรอบกิจกรรมการดำเนินงาน อพ.สธ. (ภายใต้กรอบการดำเนินงาน 3 กรอบ 8 กิจกรรม) เพื่อให้บุคลากรสามารถใช้ปฏิบัติงานได้อย่างเต็มประสิทธิภาพ สามารถให้บริการวิชาการเกี่ยวกับโครงการอนุรักษ์พันธุกรรมพืชฯ สนองพระราชดำริ ตามพันธกิจและแผนยุทธศาสตร์ของมหาวิทยาลัยเทคโนโลยีราชมงคลอีสาน และโครงการอนุรักษ์พันธุกรรมพืชอันเนื่องมาจากพระราชดำริฯ (อพ.สธ.)', 'compliant', ''),
(92, 176, 'เครื่องคอมพิวเตอร์ All-in-One สำหรับงานสำนักงาน', 5, 300000.00, 10000.00, '1.มีหน่วยประมวลผลกลาง (CPU) ไม่น้อยกว่า 4 แกนหลัก (4 Core) และ 8 แกนเสมือน (8 Thread) และมีเทคโนโลยีเพิ่มความเร็วสัญญาณนาฬิกาอัตโนมัติในกรณีที่ต้องใช้พลังประมวลผลสูง (Turbo Boost หรือ Max Boost) โดยมีความเร็วสัญญาณนาฬิกาสูงสุดไม่น้อยกว่า 3.7 GHz จำนวน 1 หน่วย\r\n2.หน่วยประมวลผลกลาง (CPU) มีหน่วยความจำแบบ Cache Memory รวมในระดับเดียวกัน (Level) ไม่น้อยกว่า 4 MB\r\n3.มีหน่วยความจำหลัก (RAM) ชนิด DDR4 หรือดีกว่า ขนาดไม่น้อยกว่า 8 GB\r\n4.มีหน่วยจัดเก็บข้อมูลชนิด Solid State Drive (SSD) ขนาดความจุไม่น้อยกว่า 250 GB จำนวน 1 หน่วย\r\n5.มีช่องเชื่อมต่อระบบเครือข่าย (Network Interface) แบบ 10/100/1000 Base-T หรือดีกว่า ไม่น้อยกว่า 1 ช่อง', 'การอนุรักษ์ทรัพยากรที่มีอยู่ในประเทศไทยต่อไป เนื่องด้วยเครื่องคอมพิวเตอร์สำนักงานศูนย์อนุรักษ์และพัฒนาทรัพยากรภาคตะวันออกเฉียงเหนือตอนกลาง ที่ใช้ดำเนินงานอยู่ในปัจจุบันนั้นจัดซื้อตั้งแต่ปีงบประมาณ พ.ศ. 2555 ส่งผลให้ครุภัณฑ์ที่ใช้ดำเนินงานนั้นสภาพชำรุด ใช้งานได้บางส่วน และส่งผลต่อประสิทธิภาพและความรวดเร็วในการดำเนินภารกิจของหน่วยงานข้างต้น ศูนย์อนุรักษ์ฯ พิจารณาและเห็นควรต้องจัดหาใหม่เพื่อทดแทนของเดิม ทั้งยังต้องรองรับหน่วยงานหรือบุคคลภายนอกหน่วยงานเพื่อให้บริการวิชาการ และการดำเนินงานตามกรอบกิจกรรมการดำเนินงาน อพ.สธ. (ภายใต้กรอบการดำเนินงาน 3 กรอบ 8 กิจกรรม) เพื่อให้บุคลากรสามารถใช้ปฏิบัติงานได้อย่างเต็มประสิทธิภาพ สามารถให้บริการวิชาการเกี่ยวกับโครงการอนุรักษ์พันธุกรรมพืชฯ สนองพระราชดำริ ตามพันธกิจและแผนยุทธศาสตร์ของมหาวิทยาลัยเทคโนโลยีราชมงคลอีสาน และโครงการอนุรักษ์พันธุกรรมพืชอันเนื่องมาจากพระราชดำริฯ (อพ.สธ.)', 'compliant', ''),
(93, 176, 'แบบฟอร์มการจัดหาระบบคอมพิวเตอร์ และอุปกรณ์', 3, 434444.00, 6555.00, '1. fffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffff\r\n2. fffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffff\r\n3. fffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffff\r\n4. fffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffff', '1. hhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhh\r\n2. hhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhh\r\n3. hhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhh\r\n4. hhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhh', 'not_compliant', 'ddddd');

-- --------------------------------------------------------

--
-- Table structure for table `status_items`
--

CREATE TABLE `status_items` (
  `id` int NOT NULL,
  `form_id` int NOT NULL,
  `item_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `location` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `install_year` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `status_items`
--

INSERT INTO `status_items` (`id`, `form_id`, `item_name`, `location`, `install_year`) VALUES
(105, 173, 'รายการที่ 1', 'บ้านนา', '2566'),
(106, 173, 'รายการที่ 2', 'บ้านนา', '2566'),
(110, 175, 'เครื่องคอมพิวเตอร์ All-in-One สำหรับงานสำนักงาน จำนวน 7 เครื่อง', 'สำนักวานศูนย์อนุรักษ์ฯ', '2555'),
(111, 175, 'เครื่องคอมพิวเตอร์ All-in-One สำหรับงานสำนักงาน จำนวน 7 เครื่อง', 'สำนักวานศูนย์อนุรักษ์ฯ', '2555'),
(112, 175, 'เครื่องคอมพิวเตอร์ All-in-One สำหรับงานสำนักงาน จำนวน 7 เครื่อง', 'สำนักวานศูนย์อนุรักษ์ฯ', '2555'),
(113, 176, 'เครื่องคอมพิวเตอร์ All-in-One สำหรับงานสำนักงาน จำนวน 7 เครื่อง', 'สำนักวานศูนย์อนุรักษ์ฯ', '2568'),
(114, 176, 'เครื่องคอมพิวเตอร์ All-in-One สำหรับงานสำนักงาน จำนวน 5 เครื่อง', 'สำนักวานศูนย์อนุรักษ์ฯ', '2568');

-- --------------------------------------------------------

--
-- Table structure for table `system_cost_items`
--

CREATE TABLE `system_cost_items` (
  `id` int NOT NULL,
  `form_id` int NOT NULL,
  `cost_item` text,
  `cost_duration` int DEFAULT NULL,
  `cost_rate` bigint DEFAULT NULL,
  `cost_amount` int DEFAULT NULL,
  `cost_total` decimal(15,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `system_cost_items`
--

INSERT INTO `system_cost_items` (`id`, `form_id`, `cost_item`, `cost_duration`, `cost_rate`, `cost_amount`, `cost_total`) VALUES
(54, 173, 'สวัสดีครับ ทดสอบระบบ PDF 1', 8, 5000, 5, NULL),
(55, 173, 'สวัสดีครับ ทดสอบระบบ PDF 2', 4, 2000, 2, NULL),
(57, 175, 'โครงการอนุรักษ์พันธุกรรมพืชอันเนื่องมาจากพระราชดำริฯ', 5, 2000, 30000, NULL),
(58, 175, 'มหาวิทยาลัยเทคโนโลยีราชมงคลอีสาน', 4, 5000, 10000, NULL),
(59, 176, 'sadas', 12, 22555, 2, 51111.00),
(60, 176, 'ghhghg', 10, 566, 6, 20000.00);

-- --------------------------------------------------------

--
-- Table structure for table `uploaded_images`
--

CREATE TABLE `uploaded_images` (
  `id` int NOT NULL,
  `form_id` int NOT NULL,
  `image_url` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `uploaded_images`
--

INSERT INTO `uploaded_images` (`id`, `form_id`, `image_url`) VALUES
(6, 173, 'uploaded_files/img_687ef8c3ee31d3.07053992.jpg'),
(8, 175, 'uploaded_files/img_6890dabc6bc880.17242227.jpg'),
(9, 176, 'uploaded_files/img_68acd75dec9aa9.27658301.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int NOT NULL,
  `prename` varchar(50) NOT NULL,
  `firstname` varchar(100) NOT NULL,
  `lastname` varchar(100) NOT NULL,
  `agency` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(255) NOT NULL,
  `approve` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `is_active` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `prename`, `firstname`, `lastname`, `agency`, `email`, `phone`, `password`, `role`, `approve`, `created_at`, `is_active`) VALUES
(1, 'นาย', 'สมคิด', 'เดชมะเริง', 'admin', 'admin@gmail.com', '0987654321', '$2y$10$2wTzxLi6QYB4aw2W.2tKm.o9XfVrH6ijxOxcJX/gYAFHFuvR7ASyW', 'admin', 'อนุมัติแล้ว', '2025-03-30 22:23:27', 1),
(3, 'นาย', 'สดใส', 'จังเลย', 'โรงเรียนหนึ่ง', 'sodsai@gmail.com', '0987654321', '$2y$10$jQcN2jQSkoGeGBFaLJ0dxOc5hOm.ca2LINIjUZkkQt76uzA8D8gpm', 'member', 'อนุมัติแล้ว', '2025-03-31 00:27:32', 0),
(8, 'นาย', 'ไอแซ็ค', 'นิ้วสั้น', 'โรงเรียนสอง', 'user@gmail.com', '0987654321', '$2y$10$3QBz2BQdBZV1lBCgZWsnpuL1qi6nm47mO4e9m2i0maONLo48Q.t/i', 'member', 'อนุมัติแล้ว', '2025-04-25 01:43:23', 1),
(10, 'นางสาว', 'สามสิบ', 'กันยา', 'โรงเรียนสาม', 'mineiei12@gmail.com', '0634578888', '$2y$10$nWu61an0XtT6FGxwnr0X8egXotFn0XSeuXS5GiQD1MbAlVijAap5.', 'member', 'อนุมัติแล้ว', '2025-06-14 16:37:08', 1),
(11, 'นาย', 'บรรจง', 'สงสัย', 'โรงเรียนสี่', 'banjong.so@rmuti.ac.th', '0987654321', '$2y$10$LQj.qnRdYsNdpCQGE3BlE.jSLfuKgaGOFiCH3wJ1GUW67OuyJabwW', 'member', 'รออนุมัติ', '2025-09-12 05:18:04', 1);

-- --------------------------------------------------------

--
-- Table structure for table `work_plan`
--

CREATE TABLE `work_plan` (
  `id` int NOT NULL,
  `form_id` int DEFAULT NULL,
  `activity_no` int DEFAULT NULL,
  `month_no` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `work_plan`
--

INSERT INTO `work_plan` (`id`, `form_id`, `activity_no`, `month_no`) VALUES
(206, 105, 1, 1),
(207, 105, 1, 2),
(208, 105, 1, 3),
(209, 105, 2, 3),
(210, 105, 2, 4),
(211, 105, 2, 5),
(212, 105, 3, 5),
(213, 105, 3, 6),
(214, 105, 3, 7),
(215, 105, 4, 7),
(216, 105, 4, 8),
(217, 105, 4, 9),
(218, 105, 4, 10),
(219, 105, 4, 11),
(220, 105, 4, 12),
(221, 105, 5, 11),
(222, 105, 5, 12),
(223, 110, 1, 1),
(224, 110, 1, 2),
(225, 110, 1, 3),
(226, 110, 1, 4),
(227, 110, 1, 5),
(228, 110, 1, 6),
(229, 110, 1, 7),
(230, 110, 2, 5),
(231, 110, 2, 6),
(232, 110, 2, 7),
(233, 110, 2, 8),
(234, 110, 2, 9),
(235, 110, 3, 8),
(236, 110, 3, 9),
(237, 110, 3, 10),
(238, 110, 3, 11),
(239, 110, 4, 10),
(240, 110, 4, 11),
(241, 110, 4, 12),
(242, 110, 5, 11),
(243, 110, 5, 12),
(244, 120, 1, 1),
(245, 120, 1, 2),
(246, 120, 1, 3),
(247, 120, 2, 4),
(248, 120, 2, 5),
(249, 120, 2, 6),
(250, 120, 3, 7),
(251, 120, 3, 8),
(252, 120, 3, 9),
(253, 120, 4, 10),
(254, 120, 4, 11),
(255, 120, 4, 12),
(256, 120, 5, 12),
(257, 121, 1, 1),
(258, 121, 1, 2),
(259, 121, 1, 3),
(260, 121, 1, 4),
(261, 121, 2, 4),
(262, 121, 2, 5),
(263, 121, 3, 5),
(264, 121, 3, 6),
(265, 121, 3, 7),
(266, 121, 3, 8),
(267, 121, 4, 8),
(268, 121, 4, 9),
(269, 121, 4, 10),
(270, 121, 4, 11),
(271, 121, 4, 12),
(272, 121, 5, 12),
(273, 130, 1, 1),
(274, 130, 1, 2),
(275, 130, 1, 3),
(276, 130, 2, 3),
(277, 130, 2, 4),
(278, 130, 2, 5),
(279, 130, 3, 6),
(280, 130, 3, 7),
(281, 130, 3, 8),
(282, 130, 3, 9),
(283, 130, 4, 10),
(284, 130, 4, 11),
(285, 130, 4, 12),
(286, 130, 5, 12),
(287, 136, 1, 1),
(288, 136, 1, 2),
(289, 136, 2, 1),
(290, 136, 2, 2),
(291, 136, 3, 1),
(292, 136, 3, 2),
(293, 136, 3, 3),
(294, 136, 4, 1),
(295, 136, 4, 2),
(296, 136, 4, 3),
(297, 136, 4, 4),
(298, 136, 5, 9),
(299, 136, 5, 10),
(300, 136, 5, 11),
(301, 136, 5, 12),
(302, 137, 1, 1),
(303, 137, 1, 2),
(304, 137, 2, 1),
(305, 137, 2, 2),
(306, 137, 3, 1),
(307, 137, 3, 2),
(308, 137, 3, 3),
(309, 137, 4, 1),
(310, 137, 4, 2),
(311, 137, 4, 3),
(312, 137, 4, 4),
(313, 137, 5, 3),
(314, 137, 5, 4),
(315, 137, 5, 5),
(316, 137, 5, 6),
(317, 137, 5, 7),
(318, 137, 5, 8),
(319, 137, 5, 9),
(320, 137, 5, 10),
(321, 137, 5, 11),
(322, 137, 5, 12),
(323, 138, 1, 1),
(324, 138, 1, 2),
(325, 138, 2, 1),
(326, 138, 2, 2),
(327, 138, 3, 1),
(328, 138, 3, 2),
(329, 138, 3, 3),
(330, 138, 4, 1),
(331, 138, 4, 2),
(332, 138, 4, 3),
(333, 138, 4, 4),
(334, 138, 5, 3),
(335, 138, 5, 4),
(336, 138, 5, 5),
(337, 138, 5, 6),
(338, 138, 5, 7),
(339, 138, 5, 8),
(340, 138, 5, 9),
(341, 138, 5, 10),
(342, 138, 5, 11),
(343, 138, 5, 12),
(344, 139, 1, 1),
(345, 139, 1, 2),
(346, 139, 2, 1),
(347, 139, 2, 2),
(348, 139, 3, 1),
(349, 139, 3, 2),
(350, 139, 3, 3),
(351, 139, 4, 1),
(352, 139, 4, 2),
(353, 139, 4, 3),
(354, 139, 4, 4),
(355, 139, 5, 3),
(356, 139, 5, 4),
(357, 139, 5, 5),
(358, 139, 5, 6),
(359, 139, 5, 7),
(360, 139, 5, 8),
(361, 139, 5, 9),
(362, 139, 5, 10),
(363, 139, 5, 11),
(364, 139, 5, 12),
(365, 140, 1, 1),
(366, 140, 1, 2),
(367, 140, 2, 1),
(368, 140, 2, 2),
(369, 140, 3, 1),
(370, 140, 3, 2),
(371, 140, 3, 3),
(372, 140, 4, 1),
(373, 140, 4, 2),
(374, 140, 4, 3),
(375, 140, 4, 4),
(376, 140, 5, 3),
(377, 140, 5, 4),
(378, 140, 5, 5),
(379, 140, 5, 6),
(380, 140, 5, 7),
(381, 140, 5, 8),
(382, 140, 5, 9),
(383, 140, 5, 10),
(384, 140, 5, 11),
(385, 140, 5, 12),
(386, 141, 1, 1),
(387, 141, 1, 2),
(388, 141, 2, 1),
(389, 141, 2, 2),
(390, 141, 3, 1),
(391, 141, 3, 2),
(392, 141, 3, 3),
(393, 141, 4, 1),
(394, 141, 4, 2),
(395, 141, 4, 3),
(396, 141, 4, 4),
(397, 141, 5, 3),
(398, 141, 5, 4),
(399, 141, 5, 5),
(400, 141, 5, 6),
(401, 141, 5, 7),
(402, 141, 5, 8),
(403, 141, 5, 9),
(404, 141, 5, 10),
(405, 141, 5, 11),
(406, 141, 5, 12),
(407, 142, 1, 1),
(408, 142, 1, 2),
(409, 142, 2, 1),
(410, 142, 2, 2),
(411, 142, 3, 1),
(412, 142, 3, 2),
(413, 142, 3, 3),
(414, 142, 3, 4),
(415, 142, 4, 3),
(416, 142, 4, 4),
(417, 142, 4, 5),
(418, 142, 4, 6),
(419, 142, 5, 5),
(420, 142, 5, 6),
(421, 142, 5, 7),
(422, 142, 5, 8),
(423, 142, 5, 9),
(424, 142, 5, 10),
(425, 142, 5, 11),
(426, 142, 5, 12),
(427, 143, 1, 1),
(428, 143, 1, 2),
(429, 143, 1, 3),
(430, 143, 2, 1),
(431, 143, 2, 2),
(432, 143, 2, 3),
(433, 143, 3, 1),
(434, 143, 3, 2),
(435, 143, 3, 3),
(436, 143, 3, 4),
(437, 143, 4, 3),
(438, 143, 4, 4),
(439, 143, 4, 5),
(440, 143, 4, 6),
(441, 143, 5, 6),
(442, 143, 5, 7),
(443, 143, 5, 8),
(444, 143, 5, 9),
(445, 143, 5, 10),
(446, 143, 5, 11),
(447, 143, 5, 12),
(448, 144, 1, 1),
(449, 144, 1, 2),
(450, 144, 1, 3),
(451, 144, 2, 2),
(452, 144, 2, 3),
(453, 144, 2, 4),
(454, 144, 3, 3),
(455, 144, 3, 4),
(456, 144, 3, 5),
(457, 144, 4, 4),
(458, 144, 4, 5),
(459, 144, 4, 6),
(460, 144, 5, 5),
(461, 144, 5, 6),
(462, 144, 5, 7),
(463, 144, 5, 8),
(464, 144, 5, 9),
(465, 144, 5, 10),
(466, 144, 5, 11),
(467, 144, 5, 12),
(468, 145, 1, 1),
(469, 145, 1, 2),
(470, 145, 1, 3),
(471, 145, 2, 2),
(472, 145, 2, 3),
(473, 145, 2, 4),
(474, 145, 3, 3),
(475, 145, 3, 4),
(476, 145, 3, 5),
(477, 145, 4, 4),
(478, 145, 4, 5),
(479, 145, 4, 6),
(480, 145, 5, 5),
(481, 145, 5, 6),
(482, 145, 5, 7),
(483, 145, 5, 8),
(484, 145, 5, 9),
(485, 145, 5, 10),
(486, 145, 5, 11),
(487, 145, 5, 12),
(488, 146, 1, 1),
(489, 146, 1, 2),
(490, 146, 2, 1),
(491, 146, 2, 2),
(492, 146, 2, 3),
(493, 146, 3, 1),
(494, 146, 3, 2),
(495, 146, 3, 3),
(496, 146, 3, 4),
(497, 146, 4, 3),
(498, 146, 4, 4),
(499, 146, 4, 5),
(500, 146, 4, 6),
(501, 146, 5, 5),
(502, 146, 5, 6),
(503, 146, 5, 7),
(504, 146, 5, 8),
(505, 146, 5, 9),
(506, 146, 5, 10),
(507, 146, 5, 11),
(508, 146, 5, 12),
(509, 156, 1, 1),
(510, 156, 1, 2),
(511, 156, 1, 3),
(512, 156, 2, 3),
(513, 156, 2, 4),
(514, 156, 2, 5),
(515, 156, 3, 5),
(516, 156, 3, 6),
(517, 156, 3, 7),
(518, 156, 4, 7),
(519, 156, 4, 8),
(520, 156, 4, 9),
(521, 156, 4, 10),
(522, 156, 5, 10),
(523, 156, 5, 11),
(524, 156, 5, 12),
(525, 157, 1, 1),
(526, 157, 1, 2),
(527, 157, 1, 3),
(528, 157, 2, 3),
(529, 157, 2, 4),
(530, 157, 2, 5),
(531, 157, 3, 5),
(532, 157, 3, 6),
(533, 157, 3, 7),
(534, 157, 4, 7),
(535, 157, 4, 8),
(536, 157, 4, 9),
(537, 157, 5, 9),
(538, 157, 5, 10),
(539, 157, 5, 11),
(540, 157, 5, 12),
(541, 158, 1, 1),
(542, 158, 1, 2),
(543, 158, 1, 3),
(544, 158, 2, 1),
(545, 158, 2, 2),
(546, 158, 2, 3),
(547, 158, 3, 1),
(548, 158, 3, 2),
(549, 158, 3, 3),
(550, 158, 3, 4),
(551, 158, 3, 5),
(552, 158, 4, 5),
(553, 158, 4, 6),
(554, 158, 4, 7),
(555, 158, 4, 8),
(556, 158, 4, 9),
(557, 158, 5, 8),
(558, 158, 5, 9),
(559, 158, 5, 10),
(560, 158, 5, 11),
(561, 158, 5, 12),
(562, 159, 1, 1),
(563, 159, 1, 2),
(564, 159, 2, 1),
(565, 159, 2, 2),
(566, 159, 2, 3),
(567, 159, 2, 4),
(568, 159, 3, 2),
(569, 159, 3, 3),
(570, 159, 3, 4),
(571, 159, 3, 5),
(572, 159, 3, 6),
(573, 159, 4, 6),
(574, 159, 4, 7),
(575, 159, 4, 8),
(576, 159, 4, 9),
(577, 159, 5, 9),
(578, 159, 5, 10),
(579, 159, 5, 11),
(580, 159, 5, 12),
(581, 161, 1, 1),
(582, 161, 1, 2),
(583, 161, 1, 3),
(584, 161, 1, 4),
(585, 161, 2, 3),
(586, 161, 2, 4),
(587, 161, 2, 5),
(588, 161, 2, 6),
(589, 161, 3, 4),
(590, 161, 3, 5),
(591, 161, 3, 6),
(592, 161, 3, 7),
(593, 161, 3, 8),
(594, 161, 3, 9),
(595, 161, 4, 8),
(596, 161, 4, 9),
(597, 161, 4, 10),
(598, 161, 4, 11),
(599, 161, 4, 12),
(600, 161, 5, 11),
(601, 161, 5, 12),
(602, 162, 1, 1),
(603, 162, 1, 2),
(604, 162, 1, 3),
(605, 162, 1, 4),
(606, 162, 2, 4),
(607, 162, 2, 5),
(608, 162, 2, 6),
(609, 162, 3, 6),
(610, 162, 3, 7),
(611, 162, 3, 8),
(612, 162, 3, 9),
(613, 162, 4, 9),
(614, 162, 4, 10),
(615, 162, 5, 11),
(616, 162, 5, 12),
(617, 169, 1, 1),
(618, 169, 1, 2),
(619, 169, 1, 3),
(620, 169, 2, 3),
(621, 169, 2, 4),
(622, 169, 2, 5),
(623, 169, 3, 4),
(624, 169, 3, 5),
(625, 169, 3, 6),
(626, 169, 4, 7),
(627, 169, 4, 8),
(628, 169, 4, 9),
(629, 169, 5, 9),
(630, 169, 5, 10),
(631, 169, 5, 11),
(632, 172, 1, 1),
(633, 172, 2, 2),
(634, 172, 3, 3),
(635, 172, 4, 4),
(636, 172, 5, 5),
(637, 172, 5, 6),
(638, 172, 5, 7),
(639, 172, 5, 8),
(640, 172, 5, 9),
(641, 172, 5, 10),
(642, 172, 5, 11),
(643, 172, 5, 12),
(644, 173, 1, 1),
(645, 173, 1, 2),
(646, 173, 1, 3),
(647, 173, 2, 1),
(648, 173, 2, 2),
(649, 173, 2, 3),
(650, 173, 2, 4),
(651, 173, 2, 5),
(652, 173, 3, 2),
(653, 173, 3, 3),
(654, 173, 3, 4),
(655, 173, 3, 5),
(656, 173, 3, 6),
(657, 173, 3, 7),
(658, 173, 4, 4),
(659, 173, 4, 5),
(660, 173, 4, 6),
(661, 173, 4, 7),
(662, 173, 4, 8),
(663, 173, 4, 9),
(664, 173, 4, 10),
(665, 173, 4, 11),
(666, 173, 4, 12),
(667, 173, 5, 9),
(668, 173, 5, 10),
(669, 173, 5, 11),
(670, 173, 5, 12),
(671, 174, 1, 1),
(672, 174, 1, 2),
(673, 174, 2, 1),
(674, 174, 2, 2),
(675, 174, 3, 1),
(676, 174, 3, 2),
(677, 174, 3, 3),
(678, 174, 4, 1),
(679, 174, 4, 2),
(680, 174, 4, 3),
(681, 174, 4, 4),
(682, 174, 5, 3),
(683, 174, 5, 4),
(684, 174, 5, 5),
(685, 174, 5, 6),
(686, 174, 5, 7),
(687, 174, 5, 8),
(688, 174, 5, 9),
(689, 174, 5, 10),
(690, 174, 5, 11),
(691, 174, 5, 12),
(692, 175, 1, 1),
(693, 175, 1, 2),
(694, 175, 1, 3),
(695, 175, 1, 4),
(696, 175, 2, 1),
(697, 175, 2, 2),
(698, 175, 2, 3),
(699, 175, 2, 4),
(700, 175, 3, 1),
(701, 175, 3, 2),
(702, 175, 3, 3),
(703, 175, 3, 4),
(704, 175, 3, 5),
(705, 175, 3, 6),
(706, 175, 4, 3),
(707, 175, 4, 4),
(708, 175, 4, 5),
(709, 175, 4, 6),
(710, 175, 4, 7),
(711, 175, 4, 8),
(712, 175, 5, 5),
(713, 175, 5, 6),
(714, 175, 5, 7),
(715, 175, 5, 8),
(716, 175, 5, 9),
(717, 175, 5, 10),
(718, 175, 5, 11),
(719, 175, 5, 12),
(720, 176, 1, 1),
(721, 176, 1, 2),
(722, 176, 2, 3),
(723, 176, 2, 4),
(724, 176, 3, 5),
(725, 176, 3, 6),
(726, 176, 4, 7),
(727, 176, 4, 8),
(728, 176, 4, 9),
(729, 176, 5, 10),
(730, 176, 5, 11),
(731, 176, 5, 12);

-- --------------------------------------------------------

--
-- Table structure for table `work_plan_duration`
--

CREATE TABLE `work_plan_duration` (
  `id` int NOT NULL,
  `form_id` int DEFAULT NULL,
  `duration_text` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `work_plan_duration`
--

INSERT INTO `work_plan_duration` (`id`, `form_id`, `duration_text`) VALUES
(14, 105, '2555'),
(15, 110, '453'),
(16, 120, '234'),
(17, 121, '2555'),
(18, 130, '2555'),
(19, 136, '1 มค - 5พย'),
(20, 137, '1 มค - 5พย'),
(21, 138, '2555'),
(22, 139, '2555'),
(23, 140, '1 มค - 5พย'),
(24, 141, '2555'),
(25, 142, '2555'),
(26, 143, '2555'),
(27, 144, '2555'),
(28, 145, '1 มค - 5พย'),
(29, 146, '2555'),
(30, 156, '2555'),
(31, 157, '2555'),
(32, 158, '1 มค - 5พย'),
(33, 159, '1 มค - 5พย'),
(34, 161, '1 มค - 5พย'),
(35, 162, '1 มค - 5พย'),
(36, 169, '1 มค - 5พย'),
(37, 172, '1 มค - 5พย'),
(38, 173, '1 มค - 5พย'),
(39, 174, '1 ตุลาคม พ ศ 2567 ถึง 30 กันยายน พ ศ 2568'),
(40, 175, '1 ตุลาคม พ ศ 2567 ถึง 30 กันยายน พ ศ 2568'),
(41, 176, '1 มค - 5พย');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `form_fields`
--
ALTER TABLE `form_fields`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `installation_places`
--
ALTER TABLE `installation_places`
  ADD PRIMARY KEY (`id`),
  ADD KEY `form_id` (`form_id`);

--
-- Indexes for table `it_personnel`
--
ALTER TABLE `it_personnel`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `methods_of_procurement`
--
ALTER TABLE `methods_of_procurement`
  ADD PRIMARY KEY (`id`),
  ADD KEY `form_id` (`form_id`);

--
-- Indexes for table `multi_year_budget`
--
ALTER TABLE `multi_year_budget`
  ADD PRIMARY KEY (`id`),
  ADD KEY `form_id` (`form_id`);

--
-- Indexes for table `news_announcements`
--
ALTER TABLE `news_announcements`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `policy_alignment`
--
ALTER TABLE `policy_alignment`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `procurement_items`
--
ALTER TABLE `procurement_items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `status_items`
--
ALTER TABLE `status_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `form_id` (`form_id`);

--
-- Indexes for table `system_cost_items`
--
ALTER TABLE `system_cost_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `form_id` (`form_id`);

--
-- Indexes for table `uploaded_images`
--
ALTER TABLE `uploaded_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `form_id` (`form_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `work_plan`
--
ALTER TABLE `work_plan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `work_plan_duration`
--
ALTER TABLE `work_plan_duration`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `form_fields`
--
ALTER TABLE `form_fields`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=177;

--
-- AUTO_INCREMENT for table `installation_places`
--
ALTER TABLE `installation_places`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT for table `it_personnel`
--
ALTER TABLE `it_personnel`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=96;

--
-- AUTO_INCREMENT for table `methods_of_procurement`
--
ALTER TABLE `methods_of_procurement`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT for table `multi_year_budget`
--
ALTER TABLE `multi_year_budget`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=77;

--
-- AUTO_INCREMENT for table `news_announcements`
--
ALTER TABLE `news_announcements`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `policy_alignment`
--
ALTER TABLE `policy_alignment`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=150;

--
-- AUTO_INCREMENT for table `procurement_items`
--
ALTER TABLE `procurement_items`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=94;

--
-- AUTO_INCREMENT for table `status_items`
--
ALTER TABLE `status_items`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=115;

--
-- AUTO_INCREMENT for table `system_cost_items`
--
ALTER TABLE `system_cost_items`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- AUTO_INCREMENT for table `uploaded_images`
--
ALTER TABLE `uploaded_images`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `work_plan`
--
ALTER TABLE `work_plan`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=732;

--
-- AUTO_INCREMENT for table `work_plan_duration`
--
ALTER TABLE `work_plan_duration`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `installation_places`
--
ALTER TABLE `installation_places`
  ADD CONSTRAINT `installation_places_ibfk_1` FOREIGN KEY (`form_id`) REFERENCES `form_fields` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `methods_of_procurement`
--
ALTER TABLE `methods_of_procurement`
  ADD CONSTRAINT `methods_of_procurement_ibfk_1` FOREIGN KEY (`form_id`) REFERENCES `form_fields` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `multi_year_budget`
--
ALTER TABLE `multi_year_budget`
  ADD CONSTRAINT `multi_year_budget_ibfk_1` FOREIGN KEY (`form_id`) REFERENCES `form_fields` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `status_items`
--
ALTER TABLE `status_items`
  ADD CONSTRAINT `status_items_ibfk_1` FOREIGN KEY (`form_id`) REFERENCES `form_fields` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `system_cost_items`
--
ALTER TABLE `system_cost_items`
  ADD CONSTRAINT `system_cost_items_ibfk_1` FOREIGN KEY (`form_id`) REFERENCES `form_fields` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `uploaded_images`
--
ALTER TABLE `uploaded_images`
  ADD CONSTRAINT `uploaded_images_ibfk_1` FOREIGN KEY (`form_id`) REFERENCES `form_fields` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
