import { showbgLoader, showLoader } from "@amec/webasset/preloader";
import { initApp } from "../utils.js";

// Import Dependencies
import "../../style/partshortage/partshortage.css";
import { createTable } from "@amec/webasset/dataTable";
import { showMessage, showErrorMessage } from "@amec/webasset/utils";
import { setDatePicker } from "@amec/webasset/flatpickr";
import { currentUser } from "@amec/webasset/api/amec";
import { fetchUtils } from "@amec/webasset/api/fetch-utils";
import { appReady } from "../apps.js"; // Import appReady from apps.js
import { formatDbDateForDisplay, JobItemDTO } from "./JobItemDTO.js";

/**
 * convertScheduleCode converts a schedule code from the format YYYYMMJ to a more readable format.
 * @param {string|number} code - The schedule code to convert.
 * @returns {string} - The converted schedule code.
 */
function convertScheduleCode(code) {
	// แปลงเป็น String ก่อนป้องกัน error กรณีส่งค่าเป็น Number มา
	const strCode = String(code);

	// แยกส่วนนำหน้า (prefix) และตัวเลขตัวสุดท้าย (last digit)
	const prefix = strCode.slice(0, -1);
	const lastChar = strCode.slice(-1);

	// กำหนดเงื่อนไขการแปลงตัวสุดท้าย
	const suffixMap = {
		1: "X",
		2: "A",
		3: "Y",
		4: "B",
		5: "Z",
		6: "C",
	};

	// ถ้าตัวสุดท้ายตรงกับเงื่อนไข ให้เอา prefix มาต่อด้วยตัวอักษรใหม่
	if (suffixMap[lastChar]) {
		return prefix + suffixMap[lastChar];
	}

	// ถ้าไม่ตรงเงื่อนไขเลย ให้คืนค่าเดิม
	return strCode;
}

// Fetch shortage/headerprod API
const fetchShortageHeaderProd = async () => {
	try {
		const apiUrl = `${process.env.APP_API}/shortage/headerprod`;
		const response = await fetch(apiUrl);
		if (!response.ok) {
			throw new Error(`API Error: ${response.status}`);
		}
		const data = await response.json();
		return data;
	} catch (error) {
		console.error("Error fetching shortage/headerprod:", error);
		showErrorMessage(error);
		return null;
	}
};

// Fetch shortage/report API
const fetchShortageData = async () => {
	try {
		//const apiUrl = `${process.env.APP_API}/shortage/report`;
		const apiUrl = `${process.env.APP_API}/shortage/report-inv`;
		const response = await fetch(apiUrl);
		if (!response.ok) {
			throw new Error(`API Error: ${response.status}`);
		}
		const data = await response.json();
		if (data.status === "success" && data.items) {
			// แปลงชื่อคีย์จาก API ให้ตรงกับ Mock Data เดิม
			console.log("Fetched shortage/report data:", data.items);

			// ใช้คำสั่ง .map() แล้วส่ง Object แถวนั้นๆ โยนเข้าไปใน DTO
			const mappedData = data.items.map(
				(row, index) => new JobItemDTO(row, index),
			);

			return mappedData;
		}
		return [];
	} catch (error) {
		console.error("Error fetching shortage/report:", error);
		showErrorMessage(error);
		return null;
	}
};

/**
 * Initialize the table with dynamic headers based on shortageHeaderProdData.
 */
async function initMyTable() {
	console.log("Initializing table with dynamic headers...OK");
	const tableId = "shortageTable";
	const tableEl = document.getElementById(tableId);
	const shortageHeaderProdData = await fetchShortageHeaderProd(); //get shortage header data from API
	const ReportData = await fetchShortageData(); //get shortage report data from API
	console.log(ReportData);
	document.getElementById("topic-bm").innerHTML =
		`Data B/M : ${convertScheduleCode(shortageHeaderProdData.header[0].SCHDMFG_N1)}`;

	// 2. สร้างโครงสร้าง HTML สำหรับ Thead
	let theadHTML = `
        <thead>
            <tr>
                <th rowspan="2">NO</th>
                <th rowspan="2">BUYER</th>
                <th rowspan="2">Job<br>Item</th>
                <th rowspan="2">ITEM</th>
                <th rowspan="2">DESCRIPTION</th>
                <th rowspan="2">DRAWING</th>
                <th rowspan="2">ONHAND</th>
                <th rowspan="2">ALLOCATE</th>
                <th rowspan="2">BALANCE</th>
                <th colspan="5" class="bg-purple-200 shadow-inner"><i class="fi fi-rr-time-quarter-past text-gray-600 mr-1"></i>SHORTAGE</th>
                <th rowspan="2">Total<br>Shortage</th>
                <th rowspan="2">Vender Code</th>
                <th rowspan="2">Vender Name</th>
                <th rowspan="2">PO</th>
				<th rowspan="2">PORD</th>
				<th rowspan="2">PLINE</th>
                <th rowspan="2">PO QTY</th>
                <th rowspan="2">PO REMAIN</th>
                <th rowspan="2">DUE DATE</th>
                <th colspan="10" class="px-4 py-3 text-center font-bold text-white bg-gradient-to-r via-indigo-500 to-purple-600 border-b border-transparent shadow-sm"><div class="flex items-center justify-center gap-2 drop-shadow-sm"><i class="fi fi-br-square-p text-gray-600 mr-1"></i>INCHARGE BY PUR DEPARTMENT</div></th>
            </tr>
            <tr class="text-left text-sm font-semibold text-amber-900 border-b border-amber-200">
    `;

	// 3. วนลูปเพื่อสร้างส่วนหัวของ SHORTAGE (แทนที่ @if ของ Blade)
	if (shortageHeaderProdData && shortageHeaderProdData.total_rows > 0) {
		const headerObj = shortageHeaderProdData.header[0];
		Object.values(headerObj)
			.slice(0, 5)
			.forEach((value, index) => {
				// เช็คว่าถ้าเป็นรายการแรก (index === 0) ให้เติมคำว่า "Before " เข้าไปข้างหน้า
				const displayValue =
					index === 0
						? `Before ${convertScheduleCode(value)}`
						: convertScheduleCode(value);
				theadHTML += `<th class="bg-purple-200">${displayValue}</th>`;
				// console.log(theadHTML);
			});
	} else {
		// ค่า Default กรณีไม่มีข้อมูล
		theadHTML += `
            <th class="bg-purple-200">Before YYYYMMJ</th>
            <th class="bg-purple-200">YYYYMMJ</th>
            <th class="bg-purple-200">YYYYMMJ</th>
            <th class="bg-purple-200">YYYYMMJ</th>
            <th class="bg-purple-200">YYYYMMJ</th>
        `;
	}

	// 4. ต่อด้วยส่วนหัวของ INCHARGE BY PUR DEPARTMENT
	theadHTML += `
                <th class="bg-amber-50 px-4 py-3 whitespace-nowrap"><i class="fi fi-rr-calendar-days text-gray-500 mr-1"></i>ETD</th>
                <th class="bg-amber-50 px-4 py-3 whitespace-nowrap"><i class="fi fi-rr-calendar-days text-gray-500 mr-1"></i>ETA</th>
                <th class="bg-amber-50 px-4 py-3 whitespace-nowrap"><i class="fi fi-rs-ship text-gray-500 mr-1"></i>SHIP MODE</th>
                <th class="bg-amber-50 px-4 py-3 whitespace-nowrap"><i class="fi fi-rr-calendar-days text-gray-500 mr-1"></i>ARV AMec</th>
                <th class="bg-amber-50 px-4 py-3 whitespace-nowrap">ARV Q'TY</th>
                <th class="bg-amber-50 px-4 py-3 whitespace-nowrap">Inv.No.</th>
                <th class="bg-amber-50 px-4 py-3 whitespace-nowrap">Comment from PUR.</th>
                <th class="bg-amber-50 px-4 py-3 whitespace-nowrap"><i class="fi fi-rr-calendar-days text-gray-500 mr-1"></i>Next reply</th>
                <th class="bg-amber-50 px-4 py-3 whitespace-nowrap">cause of<br>shortage</th>
                <th class="bg-amber-50 px-4 py-3 whitespace-nowrap text-fuchsia-600">REMARK</th>
            </tr>
        </thead>
    `;
	// 5. แทรกลงใน DOM ตารางเป้าหมาย
	tableEl.innerHTML = theadHTML;

	// 6. เรียกใช้การตั้งค่า DataTables ของคุณต่อจากนี้
	const table = await createTable(
		{
			data: ReportData,
			destroy: true,
			responsive: false,
			pageLength: 100,
			columnDefs: [
				{
					// Hide the "id" column (index 18) column PORD
					targets: [18],
					visible: false,
				},
				{
					// Disable ordering for columns 21-30 (ETD, ETA, SHIP MODE, ARV AMec, ARV Q'TY, Inv.No., Comment, Next reply, cause of shortage, REMARK)
					targets: [21, 22, 23, 24, 25, 26, 27, 28, 29, 30],
					orderable: false,
				},
			],
			columns: [
				{ data: "no", className: "sticky-column" },
				{ data: "buyer", className: "sticky-column" },
				{ data: "jobItem", className: "sticky-column" },
				{ data: "item", className: "sticky-column" },
				{ data: "desc", className: "sticky-column" },
				{ data: "drawing", className: "sticky-column" },
				{ data: "onhand" },
				{ data: "allocate" },
				{ data: "balance" },
				{ data: "before" },
				{ data: "shortA" },
				{ data: "shortB" },
				{ data: "shortC" },
				{ data: "shortX" },
				{ data: "total" },
				{ data: "vcode" },
				{ data: "vname" },
				{ data: "po", className: "font-bold" },
				{ data: "pord" },
				{ data: "pline" },
				{ data: "poqty" },
				{
					data: "poremain",
					createdCell: function (td) {
						td.classList.add("font-bold", "!text-red-600");
					},
				},
				{ data: "duedate" },
				{ data: "etd", className: "editable" },
				{ data: "eta", className: "editable" },
				{ data: "shipmode", className: "editable" },
				{ data: "arvamec", className: "editable" },
				{ data: "arvqty", className: "editable col-arvqty" },
				{ data: "invno", className: "editable" },
				{ data: "comment", className: "editable" },
				{ data: "nextreply", className: "editable" },
				{ data: "cause", className: "editable" },
				{ data: "remark", className: "editable" },
			],
			//เพิ่มฟังก์ชัน createdRow และ drawCallback สำหรับการจัดการ rowspan
			// row: คือ Element <tr> ของแถวนั้น (เป็น DOM Node)
			// data: คือ ข้อมูลดิบ (JSON object/array) ของแถวนั้น
			// dataIndex: คือ ลำดับ Index ของแถวนั้น
			createdRow: function (row, data, dataIndex) {
				console.log("Created Row Data:", data);
				/*if (data.arvQty < data.poremain) {
					$(row).addClass("bg-red-100 text-red-700 font-bold");
				}*/
			},
			drawCallback: function (settings) {
				var api = this.api();
				var rows = api.rows({ page: "current" }).nodes();

				// 1. รีเซ็ตตารางก่อนเพื่อป้องกันเลย์เอาต์พัง เวลากดเรียงข้อมูล (Sort) หรือเปลี่ยนหน้า
				$(rows).find("td").show().removeAttr("rowspan");

				// 2. ระบุ Index ของคอลัมน์ที่ต้องการ Merge
				// อ้างอิงตามลำดับ columns ของคุณ:
				//อ้างอิงตามลำดับ columns ของคุณ: 0=NO, 1=BUYER, 2=JobItem, 3=ITEM, 4=DESCRIPTION, 5=DRAWING, 6=ONHAND, 7=ALLOCATE, 8=BALANCE, 9=Before, 10=YYYYMMJ, 11=YYYYMMJ, 12=YYYYMMJ, 13=YYYYMMJ, 14=TotalShortage, 15=VenderCode, 16=VenderName
				var columnsToMerge = [
					1, 2, 3, 4, 5, 6, 7, 9, 10, 11, 12, 13, 14, 15, 16,
				];

				columnsToMerge.forEach(function (colIndex) {
					var lastValue = null;
					var lastCell = null;
					var rowspan = 1;

					// วนลูปเช็กข้อมูลในแต่ละคอลัมน์
					api.column(colIndex, { page: "current" })
						.data()
						.each(function (value, i) {
							var currentCell = $(rows)
								.eq(i)
								.find("td:eq(" + colIndex + ")");

							if (lastValue !== null && lastValue === value) {
								// ถ้าค่าเหมือนแถวบน ให้ซ่อน td นี้ทิ้ง
								$(currentCell).hide();
								rowspan++;
								// เพิ่ม rowspan ให้ td ตัวแรกสุดของกลุ่ม
								$(lastCell).attr("rowspan", rowspan);

								// ปรับแต่ง CSS ให้อักษรอยู่กึ่งกลางแนวตั้งเพื่อให้สวยงามเหมือนในรูป
								//$(lastCell).css("vertical-align", "middle");
								$(lastCell).css({
									"vertical-align": "top",
									"padding-top": "12px", // ขยับลงมาจากขอบบน 12px (ปรับตัวเลขได้ตามต้องการ)
								});
							} else {
								// ถ้าค่าเปลี่ยนไป ให้เริ่มนับกลุ่มใหม่
								lastValue = value;
								lastCell = currentCell;
								rowspan = 1;
							}
						});
				});
			},
			searching: true,
			info: true,
			dom: '<"flex flex-col sm:flex-row justify-between items-center mb-4 gap-4"f<"text-sm text-gray-500"i>>rt',
			language: {
				search: "",
				searchPlaceholder: "🔍 Search records...",
				//info: "Showing _TOTAL_ records",
			},
			initComplete: function () {
				$(".dataTables_filter input").addClass(
					"border border-slate-300 rounded-lg px-4 py-2 w-full sm:w-64 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent",
				);
				console.log("DataTable initialized and ready.");
				setTimeout(function () {
					table.columns.adjust().draw(); // <--- อันนี้ต้องเปลี่ยนเป็น this.api().columns.adjust().draw() ถ้า table ยัง return ไม่เสร็จ แต่คุณใช้ async/await อยู่ อาจจะใช้งานได้
				}, 250);
			},
		},
		{
			id: tableId,
			domScroll: { status: true },
			/*mergeRows: {
				status: true,
				column: [1, 2, 3, 4, 5, 6], // number | array of numbers e.g. 0 | [0, 1]
			},*/
		},
	);

	return table;
}

$(async function () {
	try {
		//await showbgLoader();
		await appReady; // Ensure the app is ready before proceeding
		showLoader({ show: true });
		// Fetch current user information
		const user = await currentUser();
		// console.log("Current User:", user);
		console.log("Current User:", user.empno);
		// Define which columns are dates to use Flatpickr
		const dateColumns = ["etd", "eta", "arvamec", "nextreply"];
		const table = await initMyTable(); // Initialize the table after fetching header data
		/**
		 * rezing window event to adjust columns when the window size changes.
		 * This is important for responsive tables to ensure that the column widths are recalculated.
		 */
		$(window).on("resize", function () {
			table.columns.adjust();
		});

		let activeInput = null;

		// Handle inline editing for editable cells
		$("#shortageTable tbody").on("click", "td.editable", function (e) {
			// Prevent multiple inputs from being active at the same time
			if (
				$(this).find(".inline-edit-input, .inline-edit-textarea")
					.length > 0
			)
				return;

			const cell = table.cell(this);
			const originalValue = cell.data() || "";
			const cellNode = cell.node();
			const colIndex = cell.index().column;
			const rowData = table.row(cell.index().row).data();
			console.log("Row Data:", rowData);
			const rowId = rowData.id;
			const colName = table.settings()[0].aoColumns[colIndex].data;
			console.log(
				`Row ID: ${rowId}, Column: ${colName}, Original Value: ${originalValue}`,
			);
			const poRemain = parseFloat(rowData.poremain) || 0;

			let isSaved = false; // Flag to prevent multiple saves
			// Handle Save Function
			const handleSave = (newValue) => {
				if (isSaved) return; // Prevent multiple saves
				isSaved = true;
				// Validate ARV Q'TY against PO REMAIN
				if (colName === "arvqty") {
					const arvQty = parseFloat(newValue) || 0; // Ensure it's a number

					if (arvQty > poRemain) {
						showMessage(
							`⚠️ จำนวน ARV Q'TY (${arvQty}) ไม่สามารถมากกว่า PO REMAIN (${poRemain}) ได้`,
							"warning",
							"toast-end",
						);
						if (typeof originalValue === "string") {
							cell.data(0).draw(false); // Reset to 0 if originalValue is not a number
						} else {
							cell.data(originalValue).draw(false); // Reset to original value
						}
						activeInput = null; // Reset the active input reference
						return; // Exit the function early to prevent saving
					}
					newValue = arvQty; // Ensure the value is stored as a number
				}
				// Update the cell data and redraw the table
				if (newValue !== originalValue) {
					cell.data(newValue).draw(false); // Update the cell with the new value
					$(cellNode).addClass("opacity-50 cursor-wait"); // Add a visual cue for saving
					updateDataBackend(rowId, colName, newValue, cellNode, cell); // Call the function to update the backend
				} else {
					cell.data(originalValue).draw(false); // Reset to original value if unchanged
				}
				activeInput = null; // Reset the active input reference
			};

			let input;

			// Check if the column is a date column to use Flatpickr
			if (dateColumns.includes(colName)) {
				input = $(
					`<input type="text" class="inline-edit-input fdate">`,
				).val(originalValue);
				$(cellNode).html(input);
				setDatePicker({
					dateFormat: "d-M-y",
					defaultDate: originalValue || null,
					onClose: function (selectedDates, dateStr, instance) {
						handleSave(dateStr);
					},
				});
				input[0]._flatpickr.open();
			} else if (colName === "shipmode") {
				const shipModeOptions = ["", "AIR", "SEA", "DHL"];
				input = $('<select class="inline-edit-input w-full"></select>');

				shipModeOptions.forEach((opt) => {
					const selected = opt === originalValue ? "selected" : "";
					const displayText = opt === "" ? "-- Select --" : opt;
					input.append(
						`<option value="${opt}" ${selected}>${displayText}</option>`,
					);
				});

				$(cellNode).html(input);
				input.focus();

				input.on("change blur", function () {
					handleSave($(this).val());
				});
			} else if (
				colName === "comment" ||
				colName === "remark" ||
				colName === "cause"
			) {
				//textarea for comment and remark and cause fields
				input = $(
					'<textarea class="inline-edit-textarea w-full" rows="3"></textarea>',
				).val(originalValue);
				$(cellNode).html(input);
				input.focus();

				input.on("keydown", function (e) {
					e.stopPropagation();
				});

				input.on("blur", function () {
					handleSave($(this).val());
				});
			} else {
				console.log("Editing text field:", colName);
				//text input for other editable fields
				input = $(`<input type="text" class="inline-edit-input">`).val(
					originalValue,
				);
				$(cellNode).html(input);
				input.focus();
				input[0].select();

				input.on("blur keypress", function (e) {
					if (e.type === "keypress" && e.which !== 13) return;
					handleSave($(this).val());
				});
			}

			activeInput = input;
		});

		/**
		 * updateDataBackend simulates an AJAX request to update the backend with the new data.
		 * @param {*} id
		 * @param {*} field
		 * @param {*} value
		 * @param {*} cellNode
		 * @param {*} cellObject
		 */
		function updateDataBackend(id, field, value, cellNode, cellObject) {
			setTimeout(async () => {
				const rowData = table.row(cellObject.index().row).data(); // Get the updated row data after the cell has been updated
				console.log("Cell Object:", cellObject);
				console.log("Cell Index:", cellObject.index().row); //แถวที่ถูกแก้ไข
				console.log("Row Data:", rowData);
				console.log("Cell Node Data:", cellObject.data()); //แสดงค่าที่ถูกแก้ไขแล้ว

				$(cellNode).removeClass("opacity-50 cursor-wait"); // Remove the visual cue for saving

				$(cellNode)
					.css("background-color", "#bbf7d0")
					.animate(
						{ backgroundColor: "transparent" },
						1000,
						function () {
							$(this).css("background-color", "");
						},
					);

				/**
				 * buildPurTrackingPayload constructs the payload for the API request based on the current field, row data, and value.
				 * @param {string} currentField
				 * @param {object} currentRowData
				 * @param {*} currentValue
				 * @returns {object|null}
				 */
				const buildPurTrackingPayload = (
					currentField,
					currentRowData,
					currentValue,
				) => {
					// Mapping of editable fields to API fields
					const fieldMap = {
						etd: "ETD",
						eta: "ETA",
						shipmode: "SHIP_MODE",
						arvamec: "ARV_AMEC",
						arvqty: "ARV_QTY",
						invno: "INV_NO",
						comment: "COMMENT_PUR",
						nextreply: "NEXT_REPLY",
						cause: "CAUSE_OF",
						remark: "REMARK",
					};

					const apiField = fieldMap[currentField];
					if (!apiField) return null;

					return {
						PONO: currentRowData.po,
						PORD: currentRowData.pord,
						PPROD: currentRowData.item,
						PLINE: currentRowData.pline,
						USER_UPDATE: user.empno,
						[apiField]: currentValue,
					};
				};

				// create data
				console.log(
					`Row ID: ${id} has no existing record. Proceeding to create a new record...`,
				);
				const createData = buildPurTrackingPayload(
					field,
					rowData,
					value,
				);
				// Call the API to create a new record
				if (createData) {
					const apiUrl = `${process.env.APP_API}/shortage/short-pur-tracking`;
					try {
						const result = await fetchUtils({
							url: apiUrl,
							method: "POST",
							data: createData,
						});
						showMessage("Data saved successfully", "success");
					} catch (error) {
						console.error("Error creating data:", error);
					}
				}
			}, 400);
		}
	} catch (error) {
		console.log(error);
	} finally {
		// 🌟 2. ปิดหน้าจอ Loading หลังจากโหลดข้อมูลเสร็จสิ้น
		showLoader({ show: false });
	}
});
