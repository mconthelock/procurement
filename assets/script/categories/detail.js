import { showLoader } from "@amec/webasset/preloader";
import { showMessage } from "@amec/webasset/utils";
import { getCategories } from "../service/index.js";

const API_URL = `${process.env.MOCK_API}/categories`;

$(document).ready(async () => {
	try {
		await showLoader();

		// 1. โหลด Category ทั้งหมดมาสร้างรายการ Parent Options ก่อน
		const allCategories = await getCategories();
		renderParentOptions(allCategories);

		const id = $("#cat_id_hidden").val();
		if (id) {
			const data = await getCategories(id);
			fillCategoryForm(data);
		}

		// 2. ผูก Event เมื่อมีการเลือก Parent ให้เปลี่ยน Level อัตโนมัติ
		$("#CATEGORY_PARENT").on("change", function () {
			calculateLevel();
		});

		initSubmit();
	} catch (error) {
		console.error(error);
		await showMessage("Error loading data");
	} finally {
		await showLoader({ show: false });
	}
});
function renderParentOptions(data) {
	const $select = $("#CATEGORY_PARENT");
	const currentId = $("#cat_id_hidden").val();

	// เรียงลำดับเพื่อให้ Root มาก่อน
	data.sort((a, b) => a.CATEGORY_LEVEL - b.CATEGORY_LEVEL);

	data.forEach((cat) => {
		// ห้ามเลือกตัวเองเป็นแม่
		if (cat.id == currentId) return;

		const indent = "— ".repeat(cat.CATEGORY_LEVEL - 1);
		const style =
			cat.CATEGORY_LEVEL === 1
				? "font-weight: bold; color: #3b82f6;"
				: "";

		$select.append(`
            <option value="${cat.CATEGORY_ID}" data-level="${cat.CATEGORY_LEVEL}" style="${style}">
                ${indent}${cat.CATEGORY_NAME}
            </option>
        `);
	});
}
function calculateLevel() {
	const $selected = $("#CATEGORY_PARENT option:selected");
	const parentLevel = $selected.data("level");

	// ถ้าไม่มีแม่ = Level 1, ถ้ามีแม่ = Level แม่ + 1
	const newLevel = parentLevel ? parseInt(parentLevel) + 1 : 1;

	$("#CATEGORY_LEVEL").val(newLevel);
	$("#CATEGORY_LEVEL_DISPLAY").val(newLevel);
}

function fillCategoryForm(data) {
	$("#CATEGORY_NAME").val(data.CATEGORY_NAME);
	$("#DESCRIPTION").val(data.DESCRIPTION);
	$("#CATEGORY_OWNER").val(data.CATEGORY_OWNER);
	$("#CATEGORY_STATUS").val(data.CATEGORY_STATUS ?? 1);
	$("#CATEGORY_PARENT").val(data.CATEGORY_PARENT || "");

	// แสดง Level ปัจจุบัน
	$("#CATEGORY_LEVEL").val(data.CATEGORY_LEVEL || 1);
	$("#CATEGORY_LEVEL_DISPLAY").val(data.CATEGORY_LEVEL || 1);
}

function initSubmit() {
	$("#categoryForm").on("submit", async function (e) {
		e.preventDefault();

		// --- Validation --- (Code เดิมของคุณ)
		const errors = [];
		$(".input, .select").removeClass("border-error");
		if (!$("#CATEGORY_NAME").val().trim()) {
			errors.push("Category Name is required");
			$("#CATEGORY_NAME").addClass("border-error");
		}
		if (!$("#CATEGORY_OWNER").val().trim()) {
			errors.push("Department Owner Code is required");
			$("#CATEGORY_OWNER").addClass("border-error");
		}
		if (errors.length > 0) {
			await showMessage(errors.join("<br>"));
			return;
		}

		try {
			await showLoader();
			const id = $("#cat_id_hidden").val();
			const parentValue = $("#CATEGORY_PARENT").val();

			const payload = {
				CATEGORY_NAME: $("#CATEGORY_NAME").val().trim(),
				DESCRIPTION: $("#DESCRIPTION").val().trim(),
				CATEGORY_OWNER: $("#CATEGORY_OWNER").val().trim(),
				CATEGORY_STATUS: parseInt($("#CATEGORY_STATUS").val()),
				CATEGORY_LEVEL: parseInt($("#CATEGORY_LEVEL").val()),
				CATEGORY_PARENT: parentValue ? parseInt(parentValue) : null,
				CREATED_AT: id ? undefined : new Date().toISOString(),
			};

			if (!id) {
				payload.CATEGORY_ID = Math.floor(1000 + Math.random() * 9000);
			} else {
				payload.CATEGORY_ID = parseInt(id);
			}

			const method = id ? "PUT" : "POST";
			const url = id ? `${API_URL}/${id}` : API_URL;

			const res = await fetch(url, {
				method: method,
				headers: { "Content-Type": "application/json" },
				body: JSON.stringify(payload),
			});

			if (res.ok) {
				await showMessage(
					id ? "Category updated!" : "New Category added!",
					"success",
				);
				window.location.href = `${process.env.APP_ENV}/Categories`;
			} else {
				throw new Error("Failed to save");
			}
		} catch (error) {
			await showMessage(error.message);
		} finally {
			await showLoader({ show: false });
		}
	});
}

// Soft Delete (Deactivate)
window.deleteCategory = async function (id) {
	if (confirm("Are you sure you want to deactivate this category?")) {
		try {
			await showLoader();
			const currentRes = await fetch(`${API_URL}/${id}`);
			const currentData = await currentRes.json();

			const payload = {
				...currentData,
				CATEGORY_STATUS: 0,
				UPDATED_AT: new Date().toISOString(),
			};

			const response = await fetch(`${API_URL}/${id}`, {
				method: "PUT",
				headers: { "Content-Type": "application/json" },
				body: JSON.stringify(payload),
			});

			if (response.ok) {
				await showMessage("Category deactivated.");
				window.location.href = `${process.env.APP_ENV}/Categories`;
			}
		} catch (error) {
			await showMessage(error.message);
		} finally {
			await showLoader({ show: false });
		}
	}
};
