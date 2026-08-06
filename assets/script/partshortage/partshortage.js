import { showbgLoader } from "@amec/webasset/preloader";
import { initApp } from "../utils.js";

// Import Dependencies
import "../../style/partshortage/partshortage.css";
import { createTable } from "@amec/webasset/dataTable";
import { showMessage } from "@amec/webasset/utils";
import { setDatePicker } from "@amec/webasset/flatpickr";
import { currentUser } from "@amec/webasset/api/amec";

$(async function () {
	try {
		await showbgLoader();
		await initApp({ submenu: ".navmenu-newinq" });
		// Fetch current user information
		const user = await currentUser();
		console.log("Current User:", user);
	} catch (error) {
		console.log(error);
	}
});

// 1. Generate 100 rows of Mock Data
const generateMockData = () => {
	const data = [];
	const descriptions = [
		"CONNECTOR",
		"GOVERNER ROPE",
		"WIRE ROPE",
		"RAIL (5 KG/ 2.5M.)",
		"RAIL T75-3B",
		"COMP.P.WEIGHT",
		"CONCRETE SCRAP",
	];
	const vendors = [
		{ code: "10003", name: "MITSUBISHI ELEC" },
		{ code: "70009", name: "MITSUBISHI ELEC" },
		{ code: "50274", name: "S.RUNGTHIP THAW" },
	];
	const shipModes = ["AIR", "SEA", "DHL", ""];

	let idCounter = 1;
	let noCounter = 1;

	for (let i = 0; i < 100; i++) {
		const onhand = Math.floor(Math.random() * 200); //onhand
		const allocate = Math.floor(Math.random() * 500) + 100; //allocate
		const balance = onhand - allocate;
		const totalShort = Math.abs(balance);
		const v = vendors[Math.floor(Math.random() * vendors.length)];

		let poqty = Math.floor(Math.random() * 5000) + 100;
		let poremain = poqty - Math.floor(Math.random() * 50);

		data.push({
			id: idCounter++,
			no: noCounter++,
			buyer: Math.random() > 0.5 ? 1 : 3,
			jobItem: Math.floor(Math.random() * 300) + 100,
			item: `C${Math.floor(Math.random() * 90000) + 10000}`,
			desc: descriptions[Math.floor(Math.random() * descriptions.length)],
			drawing: `X${Math.floor(Math.random() * 90)}CM-235`,
			onhand: onhand,
			allocate: allocate,
			balance: balance,
			before: 0,
			shortA: Math.floor(Math.random() * 10) === 1 ? totalShort : 0,
			shortB: 0,
			shortC: 0,
			shortX: Math.floor(Math.random() * 10) !== 1 ? totalShort : 0,
			total: totalShort,
			vcode: v.code,
			vname: v.name,
			po: `4126${Math.floor(Math.random() * 9000) + 1000}`,
			poqty: poqty,
			poremain: poremain,
			duedate: `20260${Math.floor(Math.random() * 5) + 1}${Math.floor(Math.random() * 20) + 10}`,
			etd: Math.random() > 0.5 ? "29-Apr-26" : "",
			eta: Math.random() > 0.5 ? "30-Apr-26" : "",
			shipmode: shipModes[Math.floor(Math.random() * shipModes.length)],
			arvamec: "",
			arvqty: Math.random() > 0.7 ? "1600" : "",
			invno: Math.random() > 0.7 ? "Plan" : "",
			comment:
				Math.random() > 0.8
					? "Pending confirmation\nfrom supplier."
					: "",
			nextreply: "",
			cause: Math.random() > 0.8 ? "JIT" : "",
			remark: "",
		});
	}
	return data;
};

const mockData = generateMockData();

// เมื่อใช้ Import แล้ว DataTable จะผูกกับ jQuery ($) โดยอัตโนมัติ
$(document).ready(async function () {
	// Define which columns are dates to use Flatpickr
	const dateColumns = ["etd", "eta", "arvamec", "nextreply"];
	const table = await createTable(
		{
			data: mockData,
			destroy: true,
			responsive: false,
			paging: false,
			// ใช้ columnDefs เพื่อระบุคอลัมน์ที่ต้องการปิดการจัดเรียง (orderable: false)
			columnDefs: [
				// คอลัมน์ที่ 21-30 คือกลุ่ม INCHARGE BY PUR DEPARTMENT
				{
					targets: [21, 22, 23, 24, 25, 26, 27, 28, 29, 30],
					orderable: false,
				},
			],
			//orderCellsTop: false, // Enable ordering on the top row of the header
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
				{ data: "po" },
				{ data: "poqty" },
				{ data: "poremain" },
				{ data: "duedate" },
				{ data: "etd", className: "editable" },
				{ data: "eta", className: "editable" },
				{ data: "shipmode", className: "editable" },
				{ data: "arvamec", className: "editable" },
				{ data: "arvqty", className: "editable" },
				{ data: "invno", className: "editable" },
				{ data: "comment", className: "editable" },
				{ data: "nextreply", className: "editable" },
				{ data: "cause", className: "editable" },
				{ data: "remark", className: "editable" },
			],
			createdRow: function (row, data, dataIndex) {
				if (data.poremain !== "" && parseInt(data.poremain) < 500) {
					$(row).addClass("row-green");
				}
				if (data.serious !== "") {
					$("td:eq(3)", row).addClass("bg-yellow-100");
				}
			},
			searching: true,
			info: true,
			dom: '<"flex flex-col sm:flex-row justify-between items-center mb-4 gap-4"f<"text-sm text-gray-500"i>>rt',
			language: {
				search: "",
				searchPlaceholder: "🔍 Search records...",
				info: "Showing _TOTAL_ records",
			},
			initComplete: function () {
				$(".dataTables_filter input").addClass(
					"border border-slate-300 rounded-lg px-4 py-2 w-full sm:w-64 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent",
				);
				console.log("DataTable initialized and ready.");
				setTimeout(function () {
					table.columns.adjust().draw();
				}, 250);
			},
		},
		{ id: "shortageTable", domScroll: { status: true } },
	);
	/*const table = $("#shortageTable").DataTable({
		data: mockData,
		scrollX: true, // Enable horizontal scrolling
		destroy: true,
		//scrollY: "60vh",
		scrollY: "calc(100vh - 300px)", // Adjust height as needed
		scrollCollapse: true,
		paging: false,
		columns: [
			{ data: "no" },
			{ data: "buyer" },
			{ data: "jobItem" },
			{ data: "item" },
			{ data: "desc" },
			{ data: "drawing" },
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
			{ data: "po" },
			{ data: "poqty" },
			{ data: "poremain" },
			{ data: "duedate" },
			{ data: "etd", className: "editable" },
			{ data: "eta", className: "editable" },
			{ data: "shipmode", className: "editable" },
			{ data: "arvamec", className: "editable" },
			{ data: "arvqty", className: "editable" },
			{ data: "invno" , className: "editable"  },
			{ data: "comment", className: "editable" },
			{ data: "nextreply", className: "editable" },
			{ data: "cause" },
			{
				data: "remark",
				className: "editable text-fuchsia-600 font-semibold",
			},
		],
		createdRow: function (row, data, dataIndex) {
			if (data.poremain !== "" && parseInt(data.poremain) < 500) {
				$(row).addClass("row-green");
			}
			if (data.serious !== "") {
				$("td:eq(3)", row).addClass("bg-yellow-100");
			}
		},
		searching: true,
		info: true,
		dom: '<"flex flex-col sm:flex-row justify-between items-center mb-4 gap-4"f<"text-sm text-gray-500"i>>rt',
		language: {
			search: "",
			searchPlaceholder: "🔍 Search records...",
			info: "Showing _TOTAL_ records",
		},
		initComplete: function () {
			$(".dataTables_filter input").addClass(
				"border border-slate-300 rounded-lg px-4 py-2 w-full sm:w-64 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent",
			);
			setTimeout(function () {
				table.columns.adjust().draw();
			}, 250);
		},
	});*/

	// Use CSS `position: sticky` for left columns instead of FixedColumns.
	// This avoids cloning header panes and prevents duplicated headers with
	// multi-row <thead> while providing a performant sticky-left effect.
	/*(function applyStickyLeft(tableApi, leftCount = 6) {
		const $container = $(tableApi.table().container());
		// DataTables with scrolling uses separate tables for header/body.
		const $scrollHead = $container.find(
			".dataTables_scrollHeadInner table",
		);
		const $scrollBodyTable = $container.find(
			".dataTables_scrollBody table",
		);

		function calcAndApply() {
			// Hide any thead inside the scrollBody table to avoid duplicate headers
			$scrollBodyTable.find("thead").hide();

			// Reset any previous inline styles on header/body tables only
			$scrollHead
				.find("th")
				.css({ position: "", left: "", zIndex: "", background: "" });
			$scrollBodyTable
				.find("td")
				.css({ position: "", left: "", zIndex: "", background: "" });

			let leftOffsets = [];
			let cum = 0;
			// Calculate offsets using DataTables column headers (respects colspans)
			for (let j = 0; j < leftCount; j++) {
				const hdrNode = tableApi.column(j).header();
				const $hdr = $(hdrNode);
				const w = $hdr.outerWidth() || 0;
				leftOffsets.push(cum);
				cum += w;
			}

			for (let i = 0; i < leftCount; i++) {
				const left = leftOffsets[i];

				// Only apply sticky to body cells. Leave header rendering to DataTables'
				// scrollHead table to avoid cloning/duplication issues.
				$scrollBodyTable.find("tbody tr").each(function () {
					const $td = $(this).find("td").eq(i);
					if ($td.length) {
						$td.css({
							position: "sticky",
							left: left + "px",
							zIndex: 100,
							background: "#fff",
						});
					}
				});

				// Add a subtle divider on the right edge of the last sticky column
				if (i === leftCount - 1) {
					$scrollBodyTable.find("tbody tr").each(function () {
						const $td = $(this).find("td").eq(i);
						if ($td.length)
							$td.css({ boxShadow: "2px 0 0 rgba(0,0,0,0.06)" });
					});
				}
			}
		}

		// Apply on init, draw, and window resize
		calcAndApply();
		tableApi.on("draw.dt", function () {
			calcAndApply();
		});
		$(window).on("resize.partshortage", function () {
			setTimeout(calcAndApply, 50);
		});
	})(table, 6);*/

	/**
	 * rezing window event to adjust columns when the window size changes.
	 * This is important for responsive tables to ensure that the column widths are recalculated.
	 */
	$(window).on("resize", function () {
		table.columns.adjust();
	});

	let activeInput = null;

	$("#shortageTable tbody").on("click", "td.editable", function (e) {
		if (
			$(this).find(".inline-edit-input, .inline-edit-textarea").length > 0
		)
			return;

		const cell = table.cell(this);
		const originalValue = cell.data() || "";
		const cellNode = cell.node();
		const colIndex = cell.index().column;
		const rowData = table.row(cell.index().row).data();
		const rowId = rowData.id;
		const colName = table.settings()[0].aoColumns[colIndex].data;
		console.table(cell);
		console.log(
			`Row ID: ${rowId}, Column: ${colName}, Original Value: ${originalValue}`,
		);
		let isSaved = false;

		const handleSave = (newValue) => {
			if (isSaved) return;
			isSaved = true;

			if (newValue !== originalValue) {
				cell.data(newValue).draw(false);
				$(cellNode).addClass("opacity-50 cursor-wait");
				updateDataBackend(rowId, colName, newValue, cellNode, cell);
			} else {
				cell.data(originalValue).draw(false);
			}
			activeInput = null;
		};

		let input;

		if (dateColumns.includes(colName)) {
			input = $(
				`<input type="text" class="inline-edit-input fdate">`,
			).val(originalValue);
			$(cellNode).html(input);
			setDatePicker({
				dateFormat: "d-M-y",
				onClose: function (selectedDates, dateStr, instance) {
					handleSave(dateStr);
				},
			});
			/*flatpickr(input[0], {
				dateFormat: "d-M-y",
				defaultDate: originalValue,
				allowInput: true,
				appendTo: document.body,
				onClose: function (selectedDates, dateStr, instance) {
					handleSave(dateStr);
				},
			});*/
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
		} else if (colName === "comment" || colName === "remark") {
			//textarea for comment and remark
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
		setTimeout(() => {
			console.log(
				`[Mock AJAX Request] Update Row ID: ${id}, Field: ${field}, Value: ${value}`,
			);
			$(cellNode).removeClass("opacity-50 cursor-wait");

			$(cellNode)
				.css("background-color", "#bbf7d0")
				.animate({ backgroundColor: "transparent" }, 1000, function () {
					$(this).css("background-color", "");
				});

			showToast("Data saved successfully");
		}, 400);
	}

	function showToast(message) {
		const toast = $("#toast");
		$("#toast-message").text(message);

		toast
			.removeClass("-translate-y-20 opacity-0")
			.addClass("translate-y-0 opacity-100");

		setTimeout(() => {
			toast
				.removeClass("translate-y-0 opacity-100")
				.addClass("-translate-y-20 opacity-0");
		}, 3000);
	}
});
