/*
 * Thai Pre Name
 * Version: 1.0
 */
// // array [[gender, prename_th, short_prename_th, prename_en]]
// gender = array( 0 => all, 1 => male, 2 => female );
var thaiPreNameDataFull = [
    [1, 'นาย', '-', 'Mr.'],
    [2, 'นางสาว', 'น.ส.', 'Miss'],
    [2, 'นาง', '-', 'Mrs.'],
    [1, 'เด็กชาย', 'ด.ช.', '-'],
    [2, 'เด็กหญิง', 'ด.ญ.', '-'],
    [0, 'ดอกเตอร์', 'ดร.', 'Doctor'],
    [1, 'นายดาบตำรวจ', '-', '-'],
    [2, 'ร้อยตำรวจโทหญิง', '-', '-'],
    [0, 'หม่อมหลวง', 'ม.ล.', '-'],
    [1, 'ร้อยตำรวจเอก', 'ร.ต.อ.', 'POLICE CAPTAIN (POL.CAPT.)'],
    [1, 'จ่าเอก', 'จ.อ.', 'PETTY OFFICER FIRST CLASS (PO1)'],
    [1, 'ว่าที่ร้อยตรี', 'ว่าที่ ร.ต.', '-'],
    [1, 'จ่าสิบเอก', 'จ.ส.อ.', 'Master Sergeant First Class (1MSGT)'],
    [1, 'ร้อยตรี', 'ร.ต.', 'Second Lieutenant (2LT)'],
    [1, 'พันจ่าอากาศเอก', 'พ.อ.อ.', 'Flight Sergeant Third Class (3 FS)'],
    [1, 'ว่าที่ร้อยโท', 'ว่าที่ ร.ท.', '-'],
    [1, 'ว่าที่ร้อยเอก', 'ว่าที่ ร.อ.', '-'],
    [1, 'ว่าที่พันตรี', 'ว่าที่ พ.ต.', '-'],
    [1, 'จ่าสิบตรี', 'จ.ส.ต.', 'Master Sergeant Third Class (3MSGT)'],
    [1, 'พันเอก', 'พ.อ.', 'Senior Colonel (COL)'],
    [1, 'สิบเอก', 'ส.อ.', 'Platoon Sergeant (PSG)'],
    [1, 'พลอากาศเอก', 'พล.อ.อ.', 'Air Chief Marshal (ACM)'],
    [1, 'พลอากาศโท', 'พล.อ.ท.', 'Air Marshal (AM)'],
    [1, 'พลอากาศตรี', 'พล.อ.ต.', 'Air Vice Marshal (AVM)'],
    [1, 'นาวาอากาศเอก', 'น.อ.', 'Group Captain (Gp Capt)'],
    [1, 'นาวาอากาศโท', 'น.ท.', 'Wing Commander (Wng Cdr)'],
    [1, 'นาวาอากาศตรี', 'น.ต.', 'Squadron Leader (Sqn Ldr)'],
    [1, 'เรืออากาศเอก', 'ร.อ.', 'Flight Lieutenant (Flt Lt)'],
    [1, 'เรืออากาศโท', 'ร.ท.', 'Flying Officer (Flg Off)'],
    [1, 'เรืออากาศตรี', 'ร.ต.', 'Pilot Officer(Plt Off)'],
    [1, 'พันจ่าอากาศโท', 'พ.อ.ท.', 'Flight Sergeant Second Class (2 FS)'],
    [1, 'พันจ่าอากาศตรี', 'พ.อ.ต.', 'Flight Sergeant First Class (1FS)'],
    [1, 'จ่าอากาศเอก', 'จ.อ.อ.', 'Sergeant (SGT)'],
    [1, 'จ่าอากาศโท', 'จ.ท.', 'Corporal (CPL)'],
    [1, 'จ่าอากาศตรี', 'จ.ต.', 'Leading Aircraft man (LAC)'],
    [1, 'พลเอก', 'พล.อ.', 'General (GEN)'],
    [1, 'พลโท', 'พล.ท.', 'Lieutenant General (LTG)'],
    [1, 'พลตรี', 'พล.ต.', 'Major General (MG)'],
    [1, 'พันโท', 'พ.ท.', 'Lieutenant Colonel'],
    [1, 'พันตรี', 'พ.ต.', 'Major (MAJ)'],
    [1, 'ร้อยเอก', 'ร.อ.', 'Captain (CPT/CAPT)'],
    [1, 'ร้อยโท', 'ร.ท.', 'First Lieutenant (1LT)'],
    [1, 'จ่าสิบโท', 'จ.ส.ท.', 'Master Sergeant Second Class (2MSGT)'],
    [1, 'สิบโท', 'ส.ท.', 'Staff Sergeant (SSG)'],
    [1, 'สิบตรี', 'ส.ต.', 'Lance Corporal (LCPL)'],
    [1, 'พลเรือเอก', 'พล.ร.อ.', 'Admiral (ADM)'],
    [1, 'พลเรือโท', 'พล.ร.ท.', 'Vice Admiral (VADM)'],
    [1, 'พลเรือตรี', 'พล.ร.ต.', 'Rear Admiral (RADM)'],
    [1, 'นาวาเอก', 'น.อ.', 'Captain (CAPT)'],
    [1, 'นาวาโท', 'น.ท.', 'Commander (CDR)'],
    [1, 'นาวาตรี', 'น.ต.', 'Lieutenant Commander (LCDR)'],
    [1, 'เรือเอก', 'ร.อ.', 'Lieutenant (LT)'],
    [1, 'เรือโท', 'ร.ท.', 'Junior Lieutenant (JLT)'],
    [1, 'เรือตรี', 'ร.ต.', 'Sub-Lieutenant (SUBLT)'],
    [1, 'พันจ่าเอก', 'พ.จ.อ.', 'CHIEF PETTY OFFICER FIRST CLASS (1 CPO)'],
    [1, 'พันจ่าโท', 'พ.จ.ท.', 'CHIEF PETTY OFFICER SECOND CLASS FIRST SERGEANT'],
    [1, 'พันจ่าตรี', 'พ.จ.ต.', 'Chief Petty Officer 3rd class(CPO 3)'],
    [1, 'จ่าโท', 'จ.ท.', 'PETTY OFFICER SECOND CLASS (2 PO)'],
    [1, 'จ่าตรี', 'จ.ต.', 'PETTY OFFICER THIRD CLASS (3 PO)'],
    [1, 'พลตำรวจเอก', 'พล.ต.อ.', 'POLICE GENERAL (POL.GEN.)'],
    [1, 'พลตำรวจโท', 'พล.ต.ท.', 'POLICE LIEUTENANT GENERAL (POL.LT.GEN. )'],
    [1, 'พลตำรวจตรี', 'พล.ต.ต.', 'POLICE MAJOR GENERAL (POL.MAJ.GEN.)'],
    [1, 'พันตำรวจเอก', 'พ.ต.อ.', 'POLICE COLONEL (POL.COL.)'],
    [1, 'พันตำรวจโท', 'พ.ต.ท.', 'POLICE LIEUTENANT COLONEL (POL.LT.COL.)'],
    [1, 'พันตำรวจตรี', 'พ.ต.ต.', 'POLICE MAJOR (POL.MAJ.)'],
    [1, 'ร้อยตำรวจโท', 'ร.ต.ท.', 'POLICE LIEUTENANT (POL.LT..)'],
    [1, 'ร้อยตำรวจตรี', 'ร.ต.ต.', 'POLICE SUB-LIEUTENANT (POL.SUB.LT)'],
    [1, 'จ่าสิบตำรวจ', 'จ.ส.ต.', 'POLICE SERGEANT MAJOR (POL.SGT.MAJ.)'],
    [1, 'สิบตำรวจเอก', 'ส.ต.อ.', 'POLICE SERGEANT (POL.SGT.)'],
    [1, 'สิบตำรวจโท', 'ส.ต.ท.', 'POLICE CORPORAL (POL.CPL.)'],
    [1, 'สิบตำรวจตรี', 'ส.ต.ต.', 'POLICE LANCE CORPORAL (POL.L/C)'],
    [1, 'พลตำรวจ', 'พลฯ', 'POLICEMAN CONSTABLE'],
    [1, 'พลทหาร', 'พลฯ', 'Private(Pvt.)'],
    [1, 'พลตำรวจพิเศษ', 'พลฯพิเศษ', '-'],
    [1, 'พลตำรวจสำรองพิเศษ', 'พลฯสำรองพิเศษ', '-'],
    [1, 'จ่า', '-', '-'],
    [1, 'นายแพทย์', 'น.พ.', 'Docter'],
    [2, 'แพทย์หญิง', 'พ.ญ.', 'Docter'],
    [0, 'ผู้ช่วยศาสตราจารย์ดอกเตอร์', 'ผศ.ดร.', '-'],
    [1, 'พันตำรวจเอก (พิเศษ)', '-', '-'],
    [2, 'พันตรี(หญิง)', '-', '-'],
    [2, 'ว่าที่ร้อยตรีหญิง', '-', '-'],
    [1, 'พลตำรวจสำรอง', 'พลฯสำรอง', '-'],
    [1, 'นักเรียนพลตำรวจ', 'นพต.', '-'],
    [0, 'หม่อมเจ้า', 'ม.จ.', '-'],
    [0, 'หม่อมราชวงศ์', 'ม.ร.ว.', '-'],
    [0, 'ผู้ช่วยศาสตราจารย์', 'ผศ.', '-'],
    [0, 'รองศาสตราจารย์', 'รศ.', '-'],
    [0, 'ศาสตราจารย์', 'ศจ.', '-'],
    [0, 'ศาสตราจารย์คุณหญิง', 'ศจ.คุณหญิง', '-'],
    [0, 'ศาสตราจารย์ดอกเตอร์', 'ศ.ดร.', '-'],
    [0, 'ว่าที่พลเอก', 'ว่าที่ พล.อ.', '-'],
    [0, 'ว่าที่พลตรี', 'ว่าที่ พล.ต.', '-'],
    [0, 'ว่าที่พันเอกพิเศษ', 'ว่าที่ พ.อ.พิเศษ', '-'],
    [0, 'ว่าที่พันเอก', 'ว่าที่ พ.อ.', '-'],
    [0, 'ว่าที่พันโท', 'ว่าที่ พ.ท.', '-'],
    [1, 'นักเรียนนายร้อย', 'นนร.', '-'],
    [0, 'ท่านผู้หญิงหม่อมราชวงศ์', 'ท่านผู้หญิง ม.ร.ว.', '-'],
    [0, 'ว่าที่พลเรือเอก', 'ว่าที่ พล.ร.อ.', '-'],
    [0, 'ว่าที่พลเรือโท', 'ว่าที่ พล.ร.ท.', '-'],
    [0, 'ว่าที่พลเรือตรี', 'ว่าที่ พล.ร.ต.', '-'],
    [0, 'ว่าที่นาวาเอกพิเศษ', 'ว่าที่ น.อ.พิเศษ', '-'],
    [0, 'ว่าที่นาวาเอก', 'ว่าที่ น.อ.', '-'],
    [0, 'ว่าที่นาวาโท', 'ว่าที่ น.ท.', '-'],
    [0, 'ว่าที่นาวาตรี', 'ว่าที่ น.ต.', '-'],
    [0, 'ว่าที่เรือเอก', 'ว่าที่ ร.อ.', '-'],
    [0, 'ว่าที่เรือโท', 'ว่าที่ ร.ท.', '-'],
    [1, 'ว่าที่เรือตรี', 'ว่าที่ ร.ต.', '-'],
    [0, 'ว่าที่พลอากาศเอก', 'ว่าที่ พล.อ.อ.', '-'],
    [0, 'ว่าที่พลอากาศโท', 'ว่าที่ พล.อ.ท.', '-'],
    [0, 'ว่าที่พลอากาศตรี', 'ว่าที่ พล.อ.ต.', '-'],
    [0, 'ว่าที่นาวาอากาศเอกพิเศษ', 'ว่าที่ น.อ.พิเศษ', '-'],
    [0, 'ว่าที่นาวาอากาศเอก', 'ว่าที่ น.อ.', '-'],
    [0, 'ว่าที่นาวาอากาศโท', 'ว่าที่ น.ท.', '-'],
    [0, 'ว่าที่นาวาอากาศตรี', 'ว่าที่ น.ต.', '-'],
    [0, 'ว่าที่เรืออากาศเอก', 'ว่าที่ ร.อ.', '-'],
    [0, 'ว่าที่เรืออากาศโท', 'ว่าที่ ร.ท.', '-'],
    [0, 'ว่าที่เรืออากาศตรี', 'ว่าที่ ร.ต.', '-'],
    [0, 'ว่าที่พลตำรวจเอก', 'ว่าที่ พล.ต.อ.', '-'],
    [0, 'ว่าที่พลตำรวจโท', 'ว่าที่ พล.ต.ท.', '-'],
    [0, 'ว่าที่พลตำรวจตรี', 'ว่าที่ พล.ต.ต.', '-'],
    [0, 'ว่าที่พันตำรวจเอก(พิเศษ)', 'ว่าที่ พ.ต.อ.พิเศษ', '-'],
    [0, 'ว่าที่พันตำรวจเอก', 'ว่าที่ พ.ต.อ.', '-'],
    [0, 'ว่าที่พันตำรวจโท', 'ว่าที่ พ.ต.ท.', '-'],
    [0, 'ว่าที่พันตำรวจตรี', 'ว่าที่ พ.ต.ต.', '-'],
    [0, 'ว่าที่ร้อยตำรวจเอก', 'ว่าที่ ร.ต.อ.', '-'],
    [0, 'ว่าที่ร้อยตำรวจโท', 'ว่าที่ ร.ต.ท.', '-'],
    [0, 'ว่าที่ร้อยตำรวจตรี', 'ว่าที่ ร.ต.ต.', '-'],
    [0, 'พลตำรวจสมัคร', 'พลฯสมัคร', '-'],
    [0, 'นายกองใหญ่', 'ก.ญ.', '-'],
    [0, 'นายกองเอก', 'ก.อ.', '-'],
    [0, 'นายกองโท', 'ก.ท.', '-'],
    [0, 'นายกองตรี', 'ก.ต.', '-'],
    [0, 'นายหมวดเอก', 'มว.อ.', '-'],
    [0, 'นายหมวดโท', 'มว.ท.', '-'],
    [0, 'นายหมวดตรี', 'มว.ต.', '-'],
    [0, 'นายหมู่ใหญ่', 'ม.ญ.', '-'],
    [0, 'นายหมู่เอก', 'ม.อ.', '-'],
    [0, 'นายหมู่โท', 'ม.ท.', '-'],
    [0, 'นายหมู่ตรี', 'ม.ต.', '-'],
    [0, 'สมาชิกเอก', '-', '-'],
    [0, 'สมาชิกโท', '-', '-'],
    [0, 'สมาชิกตรี', '-', '-'],
    [1, 'อาสาสมัครทหารพราน', 'อส.ทพ.', '-'],
    [0, 'พันตำรวจโทหม่อมเจ้า', 'พ.ต.ท.ม.จ.', '-'],
    [0, 'พันตำรวจเอกหม่อมเจ้า', 'พ.ต.อ.ม.จ.', '-'],
    [0, 'พลตำรวจตรีหม่อมราชวงศ์', 'พล.ต.ต.ม.ร.ว.', '-'],
    [0, 'พันตำรวจตรีหม่อมราชวงศ์', 'พ.ต.ต.ม.ร.ว.', '-'],
    [0, 'พันตำรวจโทหม่อมราชวงศ์', 'พ.ต.ท.ม.ร.ว.', '-'],
    [0, 'พันตำรวจเอกหม่อมราชวงศ์', 'พ.ต.อ.ม.ร.ว.', '-'],
    [0, 'ร้อยตำรวจเอกหม่อมราชวงศ์', 'ร.ต.อ.ม.ร.ว.', '-'],
    [0, 'พันตำรวจเอกหม่อมหลวง', 'พ.ต.อ.ม.ล.', '-'],
    [0, 'พันตำรวจโทหม่อมหลวง', 'พ.ต.ท.ม.ล.', '-'],
    [0, 'พันตำรวจตรีหม่อมหลวง', 'พ.ต.ต.ม.ล.', '-'],
    [0, 'พันตำรวจตรีหลวง', 'พ.ต.ต.หลวง', '-'],
    [0, 'พันตำรวจเอกดอกเตอร์', 'พ.ต.อ.ดร.', '-'],
    [0, 'ร้อยตำรวจเอกหม่อมหลวง', 'ร.ต.อ.ม.ล.', '-'],
    [2, 'พันตำรวจเอกหญิง ท่านผู้หญิง', 'พ.ต.อ.หญิง ท่านผู้หญิง', '-'],
    [0, 'พลตำรวจตรีหม่อมหลวง', 'พล.ต.ต.ม.ล.', '-'],
    [2, 'พล.ต.หญิง คุณหญิง', 'พล.ต.หญิง คุณหญิง', '-'],
    [0, 'ว่าที่สิบเอก', 'ว่าที่ ส.อ.', '-'],
    [2, 'ดาบตำรวจหญิง', 'ด.ต.หญิง', '-'],
    [2, 'สิบเอกหญิง', '-', '-'],
    [2, 'พันจ่าอากาศเอกหญิง', 'พ.อ.อ.หญิง', '-'],
    [0, 'จ่าสิบตำรวจตรี', '-', '-'],
    [2, 'จ่าสิบตำรวจหญิง', '-', '-'],
    [2, 'จ่าสิบเอกหญิง', '-', '-'],
    [1, 'พันอากาศเอก', '-', '-'],
    [2, 'ร้อยตรีหญิง', '-', '-'],
    [2, 'สิบตำรวจตรีหญิง', '-', '-'],
    [2, 'จ่าเอกหญิง', '-', '-'],
    [2, 'จ่าโทหญิง', '-', '-'],
    [0, 'จ่าอากาศ ', '-', '-'],
    [0, 'ดาบตำรวจ', '-', '-'],
    [1, 'พลทหารอาสาสมัคร', 'พล.อสส.', '-'],
    [2, 'สิบตำรวจเอกหญิง', 'ส.ต.อ.หญิง', '-'],
    [2, 'พลตำรวจหญิง', 'พลฯ(หญิง)', '-'],
    [1, 'พล ฯ', 'พล ฯ', '-'],
    [1, 'ร้อยตรีนายแพทย์', '-', '-'],
    [1, 'พันเอกนายแพทย์', '-', '-'],
    [0, 'คุณ', '-', '-'],
    // เสริม
    [2, 'คุณหญิง', '-', '-'],
    [2, 'ท่านผู้หญิงหม่อมหลวง', 'ท่านผู้หญิง ม.ล.', '-'],
    [1, 'ศาสตราจารย์นายแพทย์', 'ศจ.น.พ.', '-'],
    [2, 'แพทย์หญิงคุณหญิง', 'พ.ญ.คุณหญิง', '-'],
    [0, 'ทัณตแพทย์', 'ท.พ.', '-'],
    [2, 'ทัณตแพทย์หญิง', 'ท.ญ.', '-'],
    [1, 'สัตวแพทย์', 'สพ.', '-'],
    [2, 'สัตวแพทย์หญิง', 'สญ.', '-'],
    [1, 'เภสัชกรชาย', 'ภก.', '-'],
    [2, 'เภสัชกรหญิง', 'ภญ.', '-'],
    [0, 'หม่อม', '-', '-'],
    [0, 'รองอำมาตย์เอก', '-', '-'],
    [0, 'ท้าว', '-', '-'],
    [0, 'เจ้า', '-', '-'],
    [2, 'ท่านผู้หญิง', '-', '-'],
    [0, 'คุณพระ', '-', '-'],
    [0, 'รองเสวกตรี', '-', '-'],
    [0, 'เอกอัครราชฑูต', '-', '-'],
    [0, 'พลสารวัตร', '-', '-'],
    [0, 'รองอำมาตย์ตรี', '-', '-'],
    [0, 'จ่าสำรอง', '-', '-'],
    [0, 'พันเอกพิเศษ', 'พ.อ.พิเศษ', '-'],
    [0, 'นักเรียนนายสิบ', 'นนส.', '-'],
    [0, 'พลจ', 'พล.จ.', '-'],
    [0, 'พลฯ อาสาสมัคร', 'พลฯ อาสา', '-'],
    [0, 'ร้อยเอกหม่อมเจ้า', 'ร.อ.ม.จ.', '-'],
    [0, 'พลโทหม่อมเจ้า', 'พล.ท.ม.จ.', '-'],
    [0, 'ร้อยตรีหม่อมเจ้า', 'ร.ต.ม.จ.', '-'],
    [0, 'ร้อยโทหม่อมเจ้า', 'ร.ท.ม.จ.', '-'],
    [0, 'พันโทหม่อมเจ้า', 'พ.ท.ม.จ.', '-'],
    [0, 'พันเอกหม่อมเจ้า', 'พ.อ.ม.จ.', '-'],
    [0, 'พันตรีหม่อมราชวงศ์', 'พ.ต.ม.ร.ว.', '-'],
    [0, 'พันโทหม่อมราชวงศ์', 'พ.ท.ม.ร.ว.', '-'],
    [0, 'พันเอกหม่อมราชวงศ์', 'พ.อ.ม.ร.ว.', '-'],
    [0, 'จ่าสิบเอกหม่อมราชวงศ์', 'จ.ส.อ.ม.ร.ว.', '-'],
    [0, 'ร้อยเอกหม่อมราชวงศ์', 'ร.อ.ม.ร.ว.', '-'],
    [0, 'ร้อยตรีหม่อมราชวงศ์', 'ร.ต.ม.ร.ว.', '-'],
    [0, 'สิบเอกหม่อมราชวงศ์', 'ส.อ.ม.ร.ว.', '-'],
    [0, 'ร้อยโทหม่อมราชวงศ์', 'ร.ท.ม.ร.ว.', '-'],
    [0, 'พันเอก(พิเศษ)หม่อมราชวงศ์', 'พ.อ.(พิเศษ)ม.ร.ว.', '-'],
    [0, 'พลฯ หม่อมหลวง', 'พลฯม.ล.', '-'],
    [0, 'ร้อยเอกหม่อมหลวง', 'ร.อ.ม.ล.', '-'],
    [0, 'สิบโทหม่อมหลวง', 'ส.ท.ม.ล.', '-'],
    [0, 'พลโทหม่อมหลวง', 'พล.ท.ม.ล.', '-'],
    [0, 'ร้อยโทหม่อมหลวง', 'ร.ท.ม.ล.', '-'],
    [0, 'ร้อยตรีหม่อมหลวง', 'ร.ต.ม.ล.', '-'],
    [0, 'สิบเอกหม่อมหลวง', 'ส.อ.ม.ล.', '-'],
    [0, 'พลตรีหม่อมหลวง', 'พล.ต.ม.ล.', '-'],
    [0, 'พันตรีหม่อมหลวง', 'พ.ต.ม.ล.', '-'],
    [0, 'พันเอกหม่อมหลวง', 'พ.อ.ม.ล.', '-'],
    [0, 'พันโทหม่อมหลวง', 'พ.ท.ม.ล.', '-'],
    [0, 'จ่าสิบตรีหม่อมหลวง', 'จ.ส.ต.ม.ล.', '-'],
    [0, 'นักเรียนนายร้อยหม่อมหลวง', 'นนร.ม.ล.', '-'],
    [0, 'ว่าที่ร้อยตรีหม่อมหลวง', 'ว่าที่ร.ต.ม.ล.', '-'],
    [0, 'จ่าสิบเอกหม่อมหลวง', 'จ.ส.อ.ม.ล.', '-'],
    [1, 'ร้อยเอกนายแพทย์', 'ร.อ.น.พ.', '-'],
    [2, 'ร้อยเอกแพทย์หญิง', 'ร.อ.พ.ญ.', '-'],
    [1, 'ร้อยโทนายแพทย์', 'ร.ท.น.พ.', '-'],
    [1, 'พันตรีนายแพทย์', 'พ.ต.น.พ.', '-'],
    [1, 'ว่าที่ร้อยโทนายแพทย์', 'ว่าที่ ร.ท.น.พ.', '-'],
    [2, 'ร้อยโทแพทย์หญิง', 'ร.ท.พ.ญ.', '-'],
    [1, 'พลตรีนายแพทย์', 'พล.ต.น.พ.', '-'],
    [1, 'พันโทนายแพทย์', 'พ.ท.น.พ.', '-'],
    [1, 'จอมพล', '-', '-'],
    [0, 'พันโทหลวง', 'พ.ท.หลวง', '-'],
    [0, 'ศาสตราจารย์พันเอก', 'ศจ.พ.อ.', '-'],
    [0, 'พันตรีหลวง', 'พ.ต.หลวง', '-'],
    [0, 'พลโทหลวง', 'พล.ท.หลวง', '-'],
    [0, 'ร้อยโทดอกเตอร์', 'ร.ท.ดร.', '-'],
    [0, 'ร้อยเอกดอกเตอร์', 'ร.อ.ดร.', '-'],
    [0, 'สารวัตรทหาร', 'ส.ห.', '-'],
    [0, 'ร้อยตรีดอกเตอร์', 'ร.ต.ดร.', '-'],
    [2, 'พันตรีคุณหญิง', 'พ.ต.คุณหญิง', '-'],
    [0, 'จ่าสิบตรีหม่อมราชวงศ์', 'จ.ส.ต.ม.ร.ว.', '-'],
    [0, 'ศาสตราจารย์ร้อยเอก', 'ศจ.ร.อ.', '-'],
    [2, 'พันโทคุณหญิง', 'พ.ท.คุณหญิง', '-'],
    [2, 'ร้อยตรีแพทย์หญิง', 'ร.ต.พ.ญ.', '-'],
    [0, 'พลเอกหม่อมหลวง', 'พล.อ.มล.', '-'],
    [0, 'นาวาเอกพิเศษ', 'น.อ.พิเศษ', '-'],
    [1, 'พลฯทหารเรือ', 'พลฯ', '-'],
    [0, 'นักเรียนนายเรือ', 'นนร.', '-'],
    [0, 'นักเรียนจ่าทหารเรือ', 'นรจ.', '-'],
    [0, 'พลเรือจัตวา', 'พล.ร.จ.', '-'],
    [0, 'นาวาโทหม่อมเจ้า', 'น.ท.ม.จ.', '-'],
    [0, 'นาวาเอกหม่อมเจ้า', 'น.อ.ม.จ.', '-'],
    [0, 'นาวาตรีหม่อมเจ้า', 'น.ต.ม.จ.', '-'],
    [0, 'พลเรือตรีหม่อมราชวงศ์', 'พล.ร.ต.ม.ร.ว.', '-'],
    [0, 'นาวาเอกหม่อมราชวงศ์', 'น.อ.ม.ร.ว.', '-'],
    [0, 'นาวาโทหม่อมราชวงศ์', 'น.ท.ม.ร.ว.', '-'],
    [0, 'นาวาตรีหม่อมราชวงศ์', 'น.ต.ม.ร.ว.', '-'],
    [0, 'นาวาโทหม่อมหลวง', 'น.ท.ม.ล.', '-'],
    [0, 'นาวาตรีหม่อมหลวง', 'น.ต.ม.ล.', '-'],
    [0, 'พันจ่าเอกหม่อมหลวง', 'พ.จ.อ.ม.ล.', '-'],
    [2, 'นาวาตรีแพทย์หญิง', 'น.ต.พ.ญ.', '-'],
    [0, 'นาวาอากาศเอกหลวง', 'น.อ.หลวง', '-'],
    [0, 'พลเรือตรีหม่อมเจ้า', 'พล.ร.ต.ม.จ.', '-'],
    [0, 'นอมล', 'น.อ.ม.ล.', '-'],
    [1, 'นาวาตรีนายแพทย์', 'น.ต.น.พ.', '-'],
    [0, 'พลเรือตรีหม่อมหลวง', 'พล.ร.ต.ม.ล.', '-'],
    [0, 'นาวาอากาศเอกพิเศษ', 'น.อ.พิเศษ', '-'],
    [0, 'พลฯทหารอากาศ', 'พลฯ', '-'],
    [0, 'นักเรียนนายเรืออากาศ', 'นนอ.', '-'],
    [0, 'นักเรียนจ่าอากาศ', 'นจอ.', '-'],
    [0, 'นักเรียนพยาบาลทหารอากาศ', 'น.พ.อ.', '-'],
    [0, 'พันอากาศเอกหม่อมราชวงศ์', 'พ.อ.อ.ม.ร.ว.', '-'],
    [0, 'พลอากาศตรีหม่อมราชวงศ์', 'พล.อ.ต.ม.ร.ว.', '-'],
    [0, 'พลอากาศโทหม่อมหลวง', 'พล.อ.ท.ม.ล.', '-'],
    [0, 'เรืออากาศโทขุน', 'ร.ท.ขุน', '-'],
    [0, 'พันจ่าอากาศเอกหม่อมหลวง', 'พ.อ.อ.ม.ล.', '-'],
    [1, 'เรืออากาศเอกนายแพทย์', 'ร.อ.น.พ.', '-'],
    [0, 'พล.อ.อ.ม.ร.ว.', 'พล.อ.อ.ม.ร.ว.', '-'],
    [0, 'พลอากาศตรีหม่อมหลวง', 'พล.อ.ต.ม.ล.', '-'],
    [1, 'นักเรียนนายร้อยตำรวจ', 'นรต.', '-'],
    [1, 'นักเรียนนายสิบตำรวจ', 'นสต.', '-'],
    [0, 'พลตำรวจอาสาสมัคร', 'พลฯอาสา', '-'],
    [0, 'สมาชิกอาสารักษาดินแดน', 'อส.', '-'],
    [0, 'นักเรียนนายร้อยตำรวจหม่อมเจ้า', 'นรต.ม.จ.', '-'],
    [0, 'สิบตำรวจเอกหม่อมหลวง', 'ส.ต.อ.ม.ล.', '-'],
    [1, 'นักเรียนนายร้อยตำรวจหม่อมหลวง', 'นรต.ม.ล.', '-'],
    [0, 'ร้อยตำรวจโทหม่อมหลวง', 'ร.ต.ท.ม.ล.', '-'],
    [1, 'นายดาบตำรวจหม่อมหลวง', 'ด.ต.ม.ล.', '-'],
    [1, 'ศาสตราจารย์นายแพทย์พันตำรวจเอก', 'ศจ.น.พ.พ.ต.อ.', '-'],
    [1, 'พันตำรวจโทนายแพทย์', 'พ.ต.ท.น.พ.', '-'],
    [1, 'ร้อยตำรวจโทนายแพทย์', 'ร.ต.ท.น.พ.', '-'],
    [1, 'ร้อยตำรวจเอกนายแพทย์', 'ร.ต.อ.น.พ.', '-'],
    [1, 'พันตำรวจตรีนายแพทย์', 'พ.ต.ต.นพ.', '-'],
    [1, 'พันตำรวจเอกนายแพทย์', 'พ.ต.อ.น.พ.', '-'],
    [0, 'ร้อยตำรวจโทดอกเตอร์', 'ร.ต.ท.ดร.', '-']
];

var thaiPreNameDataSmall = [
    [1, 'นาย', '-', 'Mr.'],
    [2, 'นางสาว', 'น.ส.', 'Miss'],
    [2, 'นาง', '-', 'Mrs.'],
    [1, 'เด็กชาย', 'ด.ช.', '-'],
    [2, 'เด็กหญิง', 'ด.ญ.', '-']
];

var thaiPreNameDataPrisoner = [
    [1, 'นักโทษชายหม่อมหลวง', 'น.ช.ม.ล.', '-'],
    [1, 'นักโทษชาย', 'น.ช.', '-'],
    [2, 'นักโทษหญิง', 'น.ญ.', '-'],
    [1, 'นักโทษชายจ่าสิบเอก', 'น.ช.จ.ส.อ.', '-'],
    [1, 'นักโทษชายจ่าเอก', 'น.ช.จ.อ.', '-'],
    [1, 'นักโทษชายพลทหาร', 'น.ช.พลฯ.', '-'],
    [1, 'นักโทษชายร้อยตรี', 'น.ช.ร.ต.', '-']
];

var thaiPreNameDataPriest = [
    [0, 'สมเด็จพระสังฆราชเจ้า', '-', '-'],
    [0, 'สมเด็จพระสังฆราช', '-', '-'],
    [0, 'สมเด็จพระราชาคณะ', '-', '-'],
    [0, 'รองสมเด็จพระราชาคณะ', '-', '-'],
    [0, 'พระราชาคณะ', '-', '-'],
    [0, 'พระเปรียญธรรม', '-', '-'],
    [0, 'พระหิรัญยบัฏ', '-', '-'],
    [0, 'พระสัญญาบัตร', '-', '-'],
    [0, 'พระราช', '-', '-'],
    [0, 'พระเทพ', '-', '-'],
    [0, 'พระปลัดขวา', '-', '-'],
    [0, 'พระปลัดซ้าย', '-', '-'],
    [0, 'พระครูปลัด', '-', '-'],
    [0, 'พระครูปลัดสุวัฒนญาณคุณ', '-', '-'],
    [0, 'พระครูปลัดอาจารย์วัฒน์', '-', '-'],
    [0, 'พระครูวิมลสิริวัฒน์', '-', '-'],
    [0, 'พระสมุห์', '-', '-'],
    [0, 'พระครูสมุห์', '-', '-'],
    [0, 'พระครู', '-', '-'],
    [0, 'พระครูใบฎีกา', '-', '-'],
    [0, 'พระครูธรรมธร', '-', '-'],
    [0, 'พระครูวิมลภาณ', '-', '-'],
    [0, 'พระครูศัพทมงคล', '-', '-'],
    [0, 'พระครูสังฆภารวิชัย', '-', '-'],
    [0, 'พระครูสังฆรักษ์', '-', '-'],
    [0, 'พระครูสังฆวิชัย', '-', '-'],
    [0, 'พระครูสังฆวิชิต', '-', '-'],
    [0, 'พระปิฎก', '-', '-'],
    [0, 'พระปริยัติ', '-', '-'],
    [0, 'เจ้าอธิการ', '-', '-'],
    [0, 'พระอธิการ', '-', '-'],
    [0, 'พระ', '-', '-'],
    [0, 'สามเณร', 'ส.ณ.', '-'],
    [0, 'พระปลัด', '-', '-'],
    [0, 'สมเด็จพระอริยวงศาคตญาณ', '-', '-'],
    [0, 'พระคาร์ดินัล', '-', '-'],
    [0, 'พระสังฆราช', '-', '-'],
    [0, 'พระคุณเจ้า', '-', '-'],
    [0, 'บาทหลวง', '-', '-'],
    [0, 'พระมหา', '-', '-'],
    [0, 'พระราชปัญญา', '-', '-'],
    [0, 'ภาราดา', 'ภาราดา', '-'],
    [0, 'พระศรีปริยัติธาดา', '-', '-'],
    [0, 'พระญาณโศภณ', '-', '-'],
    [0, 'สมเด็จพระมหาวีรวงศ์', '-', '-'],
    [0, 'พระโสภณธรรมาภรณ์', '-', '-'],
    [0, 'พระวิริวัฒน์วิสุทธิ์', '-', '-'],
    [0, 'พระญาณ', '-', '-'],
    [0, 'พระอัครสังฆราช', '-', '-'],
    [0, 'พระธรรม', '-', '-'],
    [0, 'พระสาสนโสภณ', '-', '-'],
    [0, 'พระธรรมโสภณ', '-', '-'],
    [0, 'พระอุดมสารโสภณ', '-', '-'],
    [0, 'พระครูวิมลญาณโสภณ', '-', '-'],
    [0, 'พระครูปัญญาภรณโสภณ', '-', '-'],
    [0, 'พระครูโสภณปริยัติคุณ', '-', '-'],
    [0, 'พระอธิธรรม', '-', '-'],
    [0, 'พระราชญาณ', '-', '-'],
    [0, 'พระสุธีวัชโรดม', '-', '-'],
    [0, 'รองเจ้าอธิการ', '-', '-'],
    [0, 'พระครูวินัยธร', '-', '-'],
    [0, 'พระศรีวชิราภรณ์', '-', '-'],
    [0, 'พระราชบัณฑิต', '-', '-'],
    [0, 'แม่ชี', 'แม่ชี', '-'],
    [0, 'นักบวช', '-', '-'],
    [0, 'พระรัตน', '-', '-'],
    [0, 'พระโสภณปริยัติธรรม', '-', '-'],
    [0, 'พระครูวิศาลปัญญาคุณ', '-', '-'],
    [0, 'พระศรีปริยัติโมลี', '-', '-'],
    [0, 'พระครูวัชรสีลาภรณ์', '-', '-'],
    [0, 'พระครูพิพัฒน์บรรณกิจ', '-', '-'],
    [0, 'พระครูวิบูลธรรมกิจ', '-', '-'],
    [0, 'พระครูพัฒนสารคุณ', '-', '-'],
    [0, 'พระครูสุวรรณพัฒนคุณ', '-', '-'],
    [0, 'พระครูพรหมวีรสุนทร', '-', '-'],
    [0, 'พระครูอุปถัมภ์นันทกิจ', '-', '-'],
    [0, 'พระครูวิจารณ์สังฆกิจ', '-', '-'],
    [0, 'พระครูวิมลสารวิสุทธิ์', '-', '-'],
    [0, 'พระครูไพศาลศุภกิจ', '-', '-'],
    [0, 'พระครูโอภาสธรรมพิมล', '-', '-'],
    [0, 'พระครูพิพิธวรคุณ', '-', '-'],
    [0, 'พระครูสุนทรปภากร', '-', '-'],
    [0, 'พระครูสิริชัยสถิต', '-', '-'],
    [0, 'พระครูเกษมธรรมานันท์', '-', '-'],
    [0, 'พระครูถาวรสันติคุณ', '-', '-'],
    [0, 'พระครูวิสุทธาจารวิมล', '-', '-'],
    [0, 'พระครูปภัสสราธิคุณ', '-', '-'],
    [0, 'พระครูวรสังฆกิจ', '-', '-'],
    [0, 'พระครูไพบูลชัยสิทธิ์', '-', '-'],
    [0, 'พระครูโกวิทธรรมโสภณ', '-', '-'],
    [0, 'พระครูสุพจน์วราภรณ์', '-', '-'],
    [0, 'พระครูไพโรจน์อริญชัย', '-', '-'],
    [0, 'พระครูสุนทรคณาภิรักษ์', '-', '-'],
    [0, 'พระสรภาณโกศล', '-', '-'],
    [0, 'พระครูประโชติธรรมรัตน์', '-', '-'],
    [0, 'พระครูจารุธรรมกิตติ์', '-', '-'],
    [0, 'พระครูพิทักษ์พรหมรังษี', '-', '-'],
    [0, 'พระศรีปริยัติบัณฑิต', '-', '-'],
    [0, 'พระครูพุทธิธรรมานุศาสน์', '-', '-'],
    [0, 'พระธรรมเมธาจารย์', '-', '-'],
    [0, 'พระครูกิตติกาญจนวงศ์', '-', '-'],
    [0, 'พระครูปลัดสัมพิพัฒนวิริยาจารย์', '-', '-'],
    [0, 'พระครูศีลกันตาภรณ์', '-', '-'],
    [0, 'พระครูประกาศพุทธพากย์', '-', '-'],
    [0, 'พระครูอมรวิสุทธิคุณ', '-', '-'],
    [0, 'พระครูสุทัศน์ธรรมาภิรม', '-', '-'],
    [0, 'พระครูอุปถัมภ์วชิโรภาส', '-', '-'],
    [0, 'พระครูสุนทรสมณคุณ', '-', '-'],
    [0, 'พระพรหมมุนี', '-', '-'],
    [0, 'พระครูสิริคุณารักษ์', '-', '-'],
    [0, 'พระครูวิชิตพัฒนคุณ', '-', '-'],
    [0, 'พระครูพิบูลโชติธรรม', '-', '-'],
    [0, 'พระพิศาลสารคุณ', '-', '-'],
    [0, 'พระรัตนมงคลวิสุทธ์', '-', '-'],
    [0, 'พระครูโสภณคุณานุกูล', '-', '-'],
    [0, 'พระครูผาสุกวิหารการ', '-', '-'],
    [0, 'พระครูวชิรวุฒิกร', '-', '-'],
    [0, 'พระครูกาญจนยติกิจ', '-', '-'],
    [0, 'พระครูบวรรัตนวงศ์', '-', '-'],
    [0, 'พระราชพัชราภรณ์', '-', '-'],
    [0, 'พระครูพิพิธอุดมคุณ', '-', '-'],
    [0, 'พระครูพิบูลสมณธรรม', '-', '-'],
    [0, 'องสุตบทบวร', '-', '-'],
    [0, 'พระครูจันทเขมคุณ', '-', '-'],
    [0, 'พระครูศีลสารวิสุทธิ์', '-', '-'],
    [0, 'พระครูสุธรรมโสภิต', '-', '-'],
    [0, 'พระครูอุเทศธรรมนิวิฐ', '-', '-'],
    [0, 'พระครูบรรณวัตร', '-', '-'],
    [0, 'พระครูวิสุทธาจาร', '-', '-'],
    [0, 'พระครูสุนทรวรวัฒน์', '-', '-'],
    [0, 'พระเทพชลธารมุนี ศรีชลบุราจารย์', '-', '-'],
    [0, 'พระครูโสภณสมุทรคุณ', '-', '-'],
    [0, 'พระราชเมธาภรณ์', '-', '-'],
    [0, 'พระครูศรัทธาธรรมโสภณ', '-', '-'],
    [0, 'พระครูสังฆบริรักษ์', '-', '-'],
    [0, 'พระมหานายก', '-', '-'],
    [0, 'พระครูโอภาสสมาจาร', '-', '-'],
    [0, 'พระครูศรีธวัชคุณาภรณ์', '-', '-'],
    [0, 'พระครูโสภิตวัชรกิจ', '-', '-'],
    [0, 'พระราชวชิราภรณ์', '-', '-'],
    [0, 'พระครูสุนทรวรธัช', '-', '-'],
    [0, 'พระครูอาทรโพธิกิจ', '-', '-'],
    [0, 'พระครูวิบูลกาญจนกิจ', '-', '-'],
    [0, 'พระพรหมวชิรญาณ', '-', '-'],
    [0, 'พระครูสุพจน์วรคุณ', '-', '-'],
    [0, 'พระราชาวิมลโมลี', '-', '-'],
    [0, 'พระครูอมรธรรมนายก', '-', '-'],
    [0, 'พระครูพิศิษฎ์ศาสนการ', '-', '-'],
    [0, 'พระครูเมธีธรรมานุยุต', '-', '-'],
    [0, 'พระครูปิยสีลสาร', '-', '-'],
    [0, 'พระครูสถิตบุญวัฒน์', '-', '-'],
    [0, 'พระครูนิเทศปิยธรรม', '-', '-'],
    [0, 'พระครูวิสุทธิ์กิจจานุกูล', '-', '-'],
    [0, 'พระครูสถิตย์บุญวัฒน์', '-', '-'],
    [0, 'พระครูประโชติธรรมานุกูล', '-', '-'],
    [0, 'พระเทพญาณกวี', '-', '-'],
    [0, 'พระครูพิพัฒน์ชินวงศ์', '-', '-'],
    [0, 'พระครูสมุทรขันตยาภรณ์', '-', '-'],
    [0, 'พระครูภาวนาวรกิจ', '-', '-'],
    [0, 'พระครูศรีศาสนคุณ', '-', '-'],
    [0, 'พระครูวิบูลย์ธรรมศาสก์', '-', '-'],
    [1, 'พระภิกษุ', '-', '-'],
    [0, 'หลวงนาคราช', '-', '-'],
    [2, 'ซิสเตอร์', '-', '-']
];

var thaiPreNameDataRoyal = [
    [0, 'พระบาทสมเด็จพระเจ้าอยู่หัว', '-', '-'],
    [0, 'สมเด็จพระนางเจ้า', '-', '-'],
    [0, 'สมเด็จพระศรีนครินทราบรมราชชนนี', '-', '-'],
    [0, 'พลโทสมเด็จพระบรมโอรสาธิราช', '-', '-'],
    [0, 'พลตรีสมเด็จพระเทพรัตนราชสุดา', '-', '-'],
    [0, 'พันตรีพระเจ้าวรวงศ์เธอพระองค์เจ้า', 'พ.ต.พระเจ้าวรวงศ์เธอพระองค์เจ้า', '-'],
    [0, 'พันตรีพระเจ้าวรวงศ์เธอพระองค์', 'พ.ต.พระเจ้าวรวงศ์เธอพระองค์', '-'],
    [0, 'พระเจ้าวรวงศ์เธอพระองค์หญิง', '-', '-'],
    [0, 'พระเจ้าวรวงศ์เธอพระองค์เจ้า', '-', '-'],
    [0, 'สมเด็จพระราชชนนี', '-', '-'],
    [0, 'สมเด็จพระเจ้าพี่นางเธอเจ้าฟ้า', '-', '-'],
    [0, 'สมเด็จพระ', '-', '-'],
    [0, 'สมเด็จพระเจ้าลูกเธอ', '-', '-'],
    [0, 'สมเด็จพระเจ้าลูกยาเธอ', '-', '-'],
    [0, 'สมเด็จเจ้าฟ้า', '-', '-'],
    [0, 'พระเจ้าบรมวงศ์เธอ', '-', '-'],
    [0, 'พระเจ้าวรวงศ์เธอ', '-', '-'],
    [0, 'พระเจ้าหลานเธอ', '-', '-'],
    [0, 'พระเจ้าหลานยาเธอ', '-', '-'],
    [0, 'พระวรวงศ์เธอ', '-', '-'],
    [0, 'สมเด็จพระเจ้าภคินีเธอ', '-', '-'],
    [0, 'พระองค์เจ้า', '-', '-'],
    [0, 'พระยา', '-', '-'],
    [0, 'หลวง', '-', '-'],
    [1, 'ขุน', '-', '-'],
    [0, 'หมื่น', '-', '-'],
    [0, 'เจ้าคุณ', '-', '-'],
    [0, 'พระวรวงศ์เธอพระองค์เจ้า', '-', '-'],
    [1, 'เจ้าชาย', '-', '-'],
    [2, 'เจ้าหญิง', '-', '-'],
    [0, 'เสด็จเจ้า', '-', '-'],
    [0, 'สมเด็จเจ้า', '-', '-'],
    [0, 'เจ้าฟ้า', '-', '-'],
    [2, 'หม่อมเจ้าหญิง', 'ม.จ.หญิง', '-'],
    [0, 'ทูลกระหม่อม', '-', '-'],
    [2, 'เจ้านาง', '-', '-']
];

// Gender (all, male, female)
// DataGroup (small, full)
// DataGroupEx ([prisoner, priest, royal])
// DataIgnore ([])
function thaiPreName(Gender, DataGroup, DataGroupEx, DataIgnore) {

    Gender = typeof Gender !== 'undefined' ? Gender : 'all';
    DataGroup = typeof DataGroup !== 'undefined' ? DataGroup : 'small';
    DataGroupEx = typeof DataGroupEx !== 'undefined' ? DataGroupEx : null;
    DataIgnore = typeof DataIgnore !== 'undefined' ? DataIgnore : null;

    var outData = Array();

    // main data group
    if (DataGroup == 'small') {
        outData = thaiPreNameDataSmall;
    } else if (DataGroup == 'full') {
        outData = thaiPreNameDataFull;
    } else {
        return false;
    }

    // extra data group
    if (DataGroupEx != null) {
        for (var i = 0; i < DataGroupEx.length; i++) {
            if (DataGroupEx[i] == 'prisoner') {
                outData = outData.concat(thaiPreNameDataPrisoner);
            } else if (DataGroupEx[i] == 'priest') {
                outData = outData.concat(thaiPreNameDataPriest);
            } else if (DataGroupEx[i] == 'royal') {
                outData = outData.concat(thaiPreNameDataRoyal);
            }

        }
    }

    var result = Array();
    var index = 0;

    // filter data
    for (var i = 0; i < outData.length; i++) {
        // check gender
        if (Gender == 'male') {
            if (outData[i][0] == 2) {
                continue;
            }
        } else if (Gender == 'female') {
            if (outData[i][0] == 1) {
                continue;
            }
        }

        // check ignore data
        var check = true;
        if (DataIgnore != null) {
            for (var j = 0; j < DataIgnore.length; j++) {
                if (outData[i][1] == DataIgnore[j]) {
                    check = false;
                    break;
                }
            }
        }

        if (check == false) {
            continue;
        }

        result[index] = outData[i];
        index += 1;
    } // end filter

    return result;
}