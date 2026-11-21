import dayjs from "dayjs";
import ExcelJS from "exceljs";

export const cloneRows = async (worksheet, sourceRowNum, targetRowNum) => {
	const sourceRow = worksheet.getRow(sourceRowNum);
	const newRow = worksheet.insertRow(targetRowNum);
	sourceRow.eachCell({ includeEmpty: true }, (cell, colNumber) => {
		const newCell = newRow.getCell(colNumber);
		if (cell.style) {
			newCell.style = { ...cell.style };
		}
	});
	newRow.height = sourceRow.height;
};

export const exportExcel = async (data, template, options = {}) => {
	try {
		const opt = {
			filename: `export.xlsx`,
			rowstart: 2,
			...options,
		};
		const file = template.buffer;
		const workbook = new ExcelJS.Workbook();
		await workbook.xlsx.load(file).then(async (workbook) => {
			const sheet_data = workbook.worksheets[1];
			const columns = await exportFormat(sheet_data);
			const sheet = workbook.worksheets[0];
			const colCount = sheet.columnCount;

			let color = opt.rowstart;
			let target = opt.rowstart + 2;

			let i = 0;
			for (const el of data) {
				cloneRows(sheet, color, target);
				for (let j = 1; j <= colCount; j++) {
					const format = columns.find((item) => item[1] == j);
					if (format == undefined || format[3] == null) continue;

					let value = "";
					if (format[2] == "Func") {
						const param = format[4] ? JSON.parse(format[4]) : {};
						value = eval(format[3])(el, param);
						sheet.getCell(target, format[1]).value = value;
					} else if (format[2] == "Formula") {
						value = {
							formula: format[3].replaceAll("{x}", target - 2),
						};
						sheet.getCell(target, format[1]).value = value;
					} else {
						if (format[3].includes(".")) {
							const keys = format[3].split(".");
							const item = el[keys[0]];
							if (item !== undefined) {
								if (Array.isArray(item)) {
									// prettier-ignore
									value = item !== undefined ? item[0][keys[1]] : "";
								} else {
									value =
										item !== undefined ? item[keys[1]] : "";
								}
							}
						} else {
							// prettier-ignore
							value = el[format[3]] !== undefined ? el[format[3]] : "";
						}
						//Format Data
						if (format[2] === "Date" && value) {
							// prettier-ignore
							sheet.getCell(target, format[1]).value = dayjs(value).add(7, 'hour').toDate();
							sheet.getCell(target, format[1]).numFmt = format[4]
								? format[4]
								: "yyyy-mm-dd";
						} else if (format[2] === "Datetime" && value) {
							// prettier-ignore
							sheet.getCell(target, format[1]).value = dayjs(value).add(7, 'hour').toDate();
							sheet.getCell(target, format[1]).numFmt = format[4]
								? format[4]
								: "yyyy-mm-dd hh:mm:ss";
						} else if (format[2] === "Account") {
							const digit = format[4] ? parseInt(format[4]) : 0;
							// prettier-ignore
							sheet.getCell(target, format[1]).value = value !== "" ? parseFloat(value) : 0;
							sheet.getCell(target, format[1]).numFmt =
								`_(* #,##0${digit > 0 ? "." + "0".repeat(digit) : ""}_);_(* (#,##0${digit > 0 ? "." + "0".repeat(digit) : ""})_);_(* "-"??_);_(@_)`;
						} else {
							sheet.getCell(target, format[1]).value = value;
							sheet.getCell(target, format[1]).numFmt = "General";
						}
					}
				}
				target = target + 1;
				color = color == opt.rowstart ? color + 1 : opt.rowstart;
				// });
			}
			if (opt.static) {
				for (let rw of opt.static) {
					sheet.getCell(rw.cols).value = rw.text;
				}
			}

			// Excute more options (if any)
			if (opt.execute != null && typeof opt.execute == "function") {
				await opt.execute(workbook, sheet);
			}

			sheet.spliceRows(opt.rowstart, 2);
			// Remove all sheets except the first one
			while (workbook.worksheets.length > 1)
				workbook.removeWorksheet(workbook.worksheets[1].id);
			await workbook.xlsx.writeBuffer().then(function (buffer) {
				const blob = new Blob([buffer], {
					type: "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet",
				});
				const link = document.createElement("a");
				link.href = URL.createObjectURL(blob);
				link.download = opt.filename;
				link.click();
			});
		});
	} catch (error) {
		console.log(error);
		throw error;
	}
};

export const exportFormat = (sheet) => {
	const data_array = [];
	sheet.eachRow({ includeEmpty: false }, function (row, rowNumber) {
		const row_values = [];
		row.eachCell({ includeEmpty: true }, function (cell, colNumber) {
			row_values.push(cell.value);
		});
		data_array.push(row_values);
	});
	return data_array;
};

export const getTemplate = async (filename) => {
	const data = {
		path: `${process.env.FILE_TEMPLATE}/${filename}`,
		name: filename,
	};
	return new Promise((resolve, reject) => {
		$.ajax({
			url: `${process.env.APP_API}/files/template/read/`,
			type: "POST",
			dataType: "json",
			data: data,
			success: function (res) {
				const binaryData = atob(res.content);
				const buffer = new Uint8Array(binaryData.length);
				for (let i = 0; i < binaryData.length; i++) {
					buffer[i] = binaryData.charCodeAt(i);
				}
				res.buffer = buffer;
				resolve(res);
			},
			error: function (error) {
				reject(error);
			},
		});
	});
};

export const exportApprovedVendorList = async (
	vendors = [],
	groups = [],
	options = {},
) => {
	const workbook = new ExcelJS.Workbook();
	workbook.creator = "AMEC Procurement System";
	workbook.created = new Date();

	const sheet = workbook.addWorksheet("Approved List", {
		pageSetup: {
			paperSize: 9, // A4
			orientation: "landscape",
			fitToPage: true,
			fitToWidth: 1,
			fitToHeight: 0,
		},
		views: [{ state: "frozen", ySplit: 6 }],
	});

	const thinBorder = {
		top: { style: "thin", color: { argb: "FF000000" } },
		left: { style: "thin", color: { argb: "FF000000" } },
		bottom: { style: "thin", color: { argb: "FF000000" } },
		right: { style: "thin", color: { argb: "FF000000" } },
	};

	const medBorder = {
		top: { style: "medium", color: { argb: "FF000000" } },
		left: { style: "medium", color: { argb: "FF000000" } },
		bottom: { style: "medium", color: { argb: "FF000000" } },
		right: { style: "medium", color: { argb: "FF000000" } },
	};

	// Row 1: Document Title & Revision Date
	sheet.mergeCells("A1:I1");
	const titleCell = sheet.getCell("A1");
	titleCell.value = "APPROVED LIST OF SUPPLIERS AND SUB-CONTRACTORS";
	titleCell.font = {
		name: "Arial",
		size: 14,
		bold: true,
		underline: true,
	};
	titleCell.alignment = { vertical: "middle", horizontal: "left" };

	sheet.mergeCells("N1:P1");
	const revCell = sheet.getCell("N1");
	revCell.value = `DATE: ${dayjs().format("DD-MMM-YYYY").toUpperCase()}`;
	revCell.font = { name: "Arial", size: 9, bold: true };
	revCell.alignment = { vertical: "middle", horizontal: "right" };
	sheet.getRow(1).height = 24;

	// Rows 2-4: Approval Stamp Boxes (DIM <- DEM <- SEM <- Prepared By)
	const stampBoxes = [
		{ col: "J", label: "DIM" },
		{ col: "L", label: "DEM" },
		{ col: "N", label: "SEM" },
		{ col: "P", label: "Prepared By" },
	];
	stampBoxes.forEach(({ col, label }) => {
		const hdr = sheet.getCell(`${col}2`);
		hdr.value = label;
		hdr.font = { name: "Arial", size: 9, bold: true };
		hdr.alignment = { vertical: "middle", horizontal: "center" };
		hdr.border = thinBorder;

		sheet.mergeCells(`${col}3:${col}4`);
		const box = sheet.getCell(`${col}3`);
		box.value = "";
		box.border = thinBorder;
	});
	// Arrows between stamp boxes
	["K", "M", "O"].forEach((col) => {
		sheet.mergeCells(`${col}3:${col}4`);
		const arrow = sheet.getCell(`${col}3`);
		arrow.value = "←";
		arrow.font = { name: "Arial", size: 12, bold: true };
		arrow.alignment = { vertical: "middle", horizontal: "center" };
	});

	sheet.getRow(2).height = 18;
	sheet.getRow(3).height = 22;
	sheet.getRow(4).height = 22;

	// Row 5: Company Name
	sheet.mergeCells("A5:H5");
	const compCell = sheet.getCell("A5");
	compCell.value = "MITSUBISHI ELEVATOR ASIA CO., LTD.";
	compCell.font = { name: "Arial", size: 11, bold: true };
	compCell.alignment = { vertical: "middle", horizontal: "left" };
	sheet.getRow(5).height = 20;

	// Row 6: Table Headers
	const headers = [
		{ header: "Status", width: 8 },
		{ header: "REF.\nNO.", width: 7 },
		{ header: "SUPPLIER NAME", width: 34 },
		{ header: "ADDRESS", width: 42 },
		{ header: "TEL. NO.", width: 17 },
		{ header: "FAX NO.", width: 17 },
		{ header: "CONTACT PERSON", width: 24 },
		{ header: "CATEGORY", width: 24 },
		{ header: "CLASS / ORIGIN", width: 18 },
		{ header: "VENDOR CODE", width: 20 },
		{ header: "APPROVED\nDATE", width: 13 },
		{ header: "CA NO.", width: 14 },
		{ header: "BA NO.", width: 14 },
		{ header: "TAX ID / SWIFT", width: 18 },
		{ header: "ISO14001/2015\nPOLICY NO.", width: 16 },
		{ header: "INFORMED\nISO14001 POLICY", width: 16 },
	];

	headers.forEach((h, idx) => {
		const col = sheet.getColumn(idx + 1);
		col.width = h.width;
		const cell = sheet.getCell(6, idx + 1);
		cell.value = h.header;
		cell.font = { name: "Arial", size: 9, bold: true };
		cell.alignment = {
			vertical: "middle",
			horizontal: "center",
			wrapText: true,
		};
		cell.fill = {
			type: "pattern",
			pattern: "solid",
			fgColor: { argb: "FFF2F2F2" },
		};
		cell.border = medBorder;
	});
	sheet.getRow(6).height = 30;
	sheet.autoFilter = "A6:P6";

	// Group multi-code vendors using PURSYS.VENDORS_CODE groups
	const codeToGroup = new Map();
	(groups || []).forEach((g) => {
		(g.MEMBERS || []).forEach((m) => {
			codeToGroup.set(String(m.VND_CODE), g);
		});
	});

	const consolidated = [];
	const seenGroups = new Set();

	vendors.forEach((v) => {
		const code = String(v.VND_CODE || "").trim();
		const grp = codeToGroup.get(code);

		if (grp) {
			if (seenGroups.has(grp.GROUP_ID)) return;
			seenGroups.add(grp.GROUP_ID);

			const memberCodes = (grp.MEMBERS || []).map((m) => String(m.VND_CODE));
			const matchedRows = vendors.filter((row) =>
				memberCodes.includes(String(row.VND_CODE || "").trim()),
			);
			const primaryMember = (grp.MEMBERS || []).find((m) => m.IS_PRIMARY === "Y");
			const primaryRow =
				matchedRows.find(
					(r) => String(r.VND_CODE) === String(primaryMember?.VND_CODE),
				) ||
				matchedRows[0] ||
				v;

			consolidated.push({
				row: primaryRow,
				supplierName: grp.GROUP_NAME || primaryRow.VND_NAME || "-",
				codesText: memberCodes.join(", "),
			});
		} else {
			consolidated.push({
				row: v,
				supplierName: v.VND_NAME || "-",
				codesText: code,
			});
		}
	});

	// Populate data rows (starting at Row 7)
	consolidated.forEach((entry, idx) => {
		const r = entry.row;
		const rowNum = 7 + idx;

		const statusStr = String(r.VND_STATUS || "").toUpperCase();
		const revMode =
			statusStr === "INACTIVE" || statusStr === "DELETED"
				? "D"
				: r.UPDATE_AT
					? "U"
					: "A";

		const addressStr = [
			r.VND_ADDRESS1,
			r.VND_ADDRESS2,
			r.VND_CITY,
			r.VND_STATE,
			r.VND_COUNTRY,
		]
			.filter(Boolean)
			.join(", ");

		const classOrigin = [r.VND_CLASS, r.VND_ORIGIN].filter(Boolean).join(" / ");
		const approvedDate = r.VND_REGISTED
			? dayjs(r.VND_REGISTED).format("DD-MMM-YY")
			: "-";

		const values = [
			revMode,
			idx + 1,
			entry.supplierName,
			addressStr || "-",
			r.VND_PHONE || "-",
			r.VND_FAX || "-",
			r.VND_CONTACTNAME || "-",
			r.VND_CATEGORY || "-",
			classOrigin || "-",
			entry.codesText,
			approvedDate,
			r.VND_CANO || "-",
			r.VND_BANO || "-",
			r.VND_TAXNO || "-",
			r.ISO14001_NO || "-",
			r.ISO14001_DATE ? dayjs(r.ISO14001_DATE).format("DD-MMM-YY") : "-",
		];

		const excelRow = sheet.getRow(rowNum);
		values.forEach((val, colIdx) => {
			const cell = excelRow.getCell(colIdx + 1);
			cell.value = val;
			cell.font = { name: "Arial", size: 9, bold: colIdx === 0 };
			cell.border = thinBorder;
			cell.alignment = {
				vertical: "middle",
				horizontal:
					colIdx === 0 || colIdx === 1 || colIdx >= 9 ? "center" : "left",
				wrapText: true,
			};

			// Status cell color coding matching official template
			if (colIdx === 0) {
				const fillColor =
					revMode === "A"
						? "FF92D050"
						: revMode === "U"
							? "FFDDEBF7"
							: "FFFCE4D6";
				cell.fill = {
					type: "pattern",
					pattern: "solid",
					fgColor: { argb: fillColor },
				};
			}
		});
		excelRow.height = 28;
	});

	// Footer Legend Row
	const footerRowNum = 7 + consolidated.length + 1;
	sheet.mergeCells(`A${footerRowNum}:E${footerRowNum}`);
	const legendCell = sheet.getCell(`A${footerRowNum}`);
	legendCell.value = "Change: A = Add, U = Update, D = Delete";
	legendCell.font = { name: "Arial", size: 8, italic: true };

	// Write & trigger browser download
	const buffer = await workbook.xlsx.writeBuffer();
	const blob = new Blob([buffer], {
		type: "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet",
	});
	const url = URL.createObjectURL(blob);
	const link = document.createElement("a");
	link.href = url;
	link.download =
		options.filename ||
		`Approved_List_of_Suppliers_${dayjs().format("YYYYMMDD")}.xlsx`;
	document.body.appendChild(link);
	link.click();
	document.body.removeChild(link);
	URL.revokeObjectURL(url);
};
