/**
 * formatDbDateForDisplay formats a date string from the database format (YYYY-MM-DD or YYYYMMDD) to a more user-friendly display format.
 * example: 19-Aug-26, 19/08/2026, 2026-08-19, 19 Aug 2026, 19 ส.ค. 2569
 * console.log(formatDbDateForDisplay(dbDateWithTime));
 * Output: 19-Aug-26
 * const dbDateWithTime = "2026-08-19 14:30:45";
 * const dbDateOnly = "2026-08-19";
 * console.log(formatDbDateForDisplay(dbDateWithTime, format));
 * 'DD/MM/YYYY HH:MM' :     output 19/08/2026 14:30
 * 'YYYY-MM-DD HH:MM:SS' :  output 2026-08-19 14:30:45
 * 'TH HH:MM' :             output 19 ส.ค. 2569 14:30
 * formatDbDateForDisplay(dbDateOnly, 'TH HH:MM')
 * 'TH HH:MM' :  Output: 19 ส.ค. 2569
 * @param {string|Date} value - The date value to format.
 * @param {string} format - The desired display format.
 * @returns {string} - The formatted date string.
 */
export function formatDbDateForDisplay(value, format = "DD-MMM-YY") {
	if (!value) return "";

	const rawValue = String(value).trim();

	// รองรับทั้ง YYYY-MM-DD และ YYYYMMDD รวมถึงเวลาที่ต่อท้ายมาได้
	const dateMatch =
		rawValue.match(
			/^(\d{4})-(\d{2})-(\d{2})(?:[ T](\d{2}):(\d{2})(?::(\d{2}))?(?:\.\d+)?(?:Z|[+-]\d{2}:?\d{2})?)?/,
		) ||
		rawValue.match(
			/^(\d{4})(\d{2})(\d{2})(?:[ T](\d{2}):(\d{2})(?::(\d{2}))?(?:\.\d+)?(?:Z|[+-]\d{2}:?\d{2})?)?/,
		);
	if (!dateMatch) return rawValue;

	const year = dateMatch[1];
	const month = Number(dateMatch[2]) - 1;
	const day = Number(dateMatch[3]);

	// ดึงเวลาออกมา (ถ้าไม่มีเวลาส่งมา ตัวแปรจะเป็น undefined)
	const hour = dateMatch[4] || "";
	const minute = dateMatch[5] || "";
	const second = dateMatch[6] || "";

	if (month < 0 || month > 11) return rawValue;

	const monthNamesEn = [
		"Jan",
		"Feb",
		"Mar",
		"Apr",
		"May",
		"Jun",
		"Jul",
		"Aug",
		"Sep",
		"Oct",
		"Nov",
		"Dec",
	];
	const monthNamesTh = [
		"ม.ค.",
		"ก.พ.",
		"มี.ค.",
		"เม.ย.",
		"พ.ค.",
		"มิ.ย.",
		"ก.ค.",
		"ส.ค.",
		"ก.ย.",
		"ต.ค.",
		"พ.ย.",
		"ธ.ค.",
	];

	const paddedDay = String(day).padStart(2, "0");
	const paddedMonth = String(month + 1).padStart(2, "0");

	// เตรียมชุดข้อความเวลา (ประกอบร่างเมื่อมีชั่วโมงและนาที)
	const timeString = hour && minute ? ` ${hour}:${minute}` : "";
	const fullTimeString =
		hour && minute && second ? ` ${hour}:${minute}:${second}` : timeString;

	switch (format.toUpperCase()) {
		case "DD/MM/YYYY":
			return `${paddedDay}/${paddedMonth}/${year}`;
		case "DD/MM/YYYY HH:MM":
			return `${paddedDay}/${paddedMonth}/${year}${timeString}`;

		case "YYYY-MM-DD":
			return `${year}-${paddedMonth}-${paddedDay}`;
		case "YYYY-MM-DD HH:MM:SS":
			return `${year}-${paddedMonth}-${paddedDay}${fullTimeString}`;

		case "DD MMM YYYY":
			return `${paddedDay} ${monthNamesEn[month]} ${year}`;
		case "DD MMM YYYY HH:MM":
			return `${paddedDay} ${monthNamesEn[month]} ${year}${timeString}`;
		case "DD-MMM-YY":
			return `${paddedDay}-${monthNamesEn[month]}-${year.slice(-2)}`;

		case "TH":
			const thaiYear = Number(year) + 543;
			return `${day} ${monthNamesTh[month]} ${thaiYear}`;
		case "TH HH:MM":
			const thaiYearTime = Number(year) + 543;
			return `${day} ${monthNamesTh[month]} ${thaiYearTime}${timeString}`;

		default:
			return `${paddedDay}-${monthNamesEn[month]}-${year.slice(-2)}`;
	}
}

export class JobItemDTO {
	constructor(row, index) {
		// 1. จัดการ ID และ ลำดับ (สำคัญมากสำหรับ Table/Grid)
		// สร้าง ID จากข้อมูลที่ไม่ซ้ำกัน (เช่น PONO ผสม ITEM) หรือใช้ UUID แทน index
		/*this.id =
			row.PONO && row.ITEM && row.PLINE
				? `${row.PONO}-${row.ITEM}-${row.PLINE}`
				: crypto.randomUUID();*/
		this.id = index + 1; // ใช้ index เป็น ID ชั่วคราว (ควรปรับปรุงให้เป็น unique ID ในอนาคต)
		this.no = index + 1; // ลำดับสำหรับการแสดงผล (Display Index)
		// 2. กลุ่มข้อมูลข้อความ (String)
		this.buyer = row.BUYER ?? "";
		this.jobItem = row.JOBITEM ?? "";
		this.item = row.ITEM ?? "";
		this.desc = row.DESCRIPTION ?? "";
		this.drawing = row.DRAWING ?? "";
		this.vcode = row.VENCODE ?? "";
		this.vname = row.VNDNAM ?? "";
		this.po = row.PONO ?? "";
		this.pord = row.PORD ?? "";
		this.pline = row.PLINE ?? "";
		this.poqty = row.PO_RQ ?? "";
		this.poremain = row.REMAIN_PO ?? "";
		this.shipmode = row.SHIP_MODE ?? "";
		this.invno = row.INV_NO ?? "";
		this.comment = row.COMMENT_PUR ?? "";
		this.cause = row.CAUSE_OF ?? "";
		this.remark = row.REMARK ?? "";

		// 3. กลุ่มข้อมูลตัวเลข (Number)
		this.onhand = row.ONHAND ?? 0;
		this.allocate = row.ALLOCAT ?? 0;
		this.balance = row.BALANCE ?? 0;
		this.before = row.QTY_N5 ?? 0;
		this.shortA = row.QTY_N4 ?? 0;
		this.shortB = row.QTY_N3 ?? 0;
		this.shortC = row.QTY_N2 ?? 0;
		this.shortX = row.QTY_N1 ?? 0;
		this.total = row.TOTAL_SHORT ?? 0;
		this.arvqty = row.ARV_QTY ?? 0;

		// 4. กลุ่มข้อมูลวันที่ (Date & Time)
		this.duedate = row.DUEDATE ?? "";
		this.etd = formatDbDateForDisplay(row.ETD);
		this.eta = formatDbDateForDisplay(row.ETA);
		this.arvamec = formatDbDateForDisplay(row.ARV_AMEC);
		this.nextreply = formatDbDateForDisplay(row.NEXT_REPLY);
	}
}
