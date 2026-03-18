import { showLoader } from "@amec/webasset/preloader";
import { showMessage } from "@amec/webasset/utils";
import { getCategories } from "../service/index.js";
import $ from "jquery";
window.$ = window.jQuery = $;

const API_URL = `${process.env.MOCK_API}/categories`;

$(document).ready(async () => {
	try {
		await showLoader();

		// 1. โหลดข้อมูล Category เพื่อทำ Parent Dropdown
		const allCategories = await getCategories();
		renderParentOptions(allCategories);

		const id = $("#cat_id_hidden").val();
		if (id) {
			const data = await getCategories(id);
			fillCategoryForm(data);
		}

		// 2. Event Listeners
		$("#CATEGORY_PARENT").on("change", function () {
			calculateLevel();
		});

		initSubmit();
	} catch (error) {
		console.error(error);
		await showMessage("Error loading data", "error");
	} finally {
		await showLoader({ show: false });
	}
});
function renderParentOptions(data) {
	const $select = $("#CATEGORY_PARENT");
	const currentId = $("#cat_id_hidden").val();

	data.sort((a, b) => a.CATEGORY_LEVEL - b.CATEGORY_LEVEL);
	data.forEach((cat) => {
		if (cat.id == currentId) return; // ห้ามเลือกตัวเองเป็นแม่
		const indent = "— ".repeat(cat.CATEGORY_LEVEL - 1);
		const style =
			cat.CATEGORY_LEVEL === 1
				? "font-weight: bold; color: #3b82f6;"
				: "";
		$select.append(
			`<option value="${cat.CATEGORY_ID}" data-level="${cat.CATEGORY_LEVEL}" style="${style}">${indent}${cat.CATEGORY_NAME}</option>`,
		);
	});
}
function calculateLevel() {
	const $selected = $("#CATEGORY_PARENT option:selected");
	const parentLevel = $selected.data("level");
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
	$("#CATEGORY_LEVEL").val(data.CATEGORY_LEVEL || 1);
	$("#CATEGORY_LEVEL_DISPLAY").val(data.CATEGORY_LEVEL || 1);

	// แสดงรายการ Attributes เดิม
	if (data.REQUIRED_ATTRIBUTES) {
		$("#category_attr_tags").empty();
		data.REQUIRED_ATTRIBUTES.forEach((attr) =>
			window.addCategoryAttrTag(attr),
		);
	}
}

function initSubmit() {
	$("#categoryForm").on("submit", async function (e) {
		e.preventDefault();

		// รวบรวมข้อมูล Tags
		const requiredAttributes = $(".attr-tag-input")
			.map((i, el) => $(el).val().trim())
			.get()
			.filter((v) => v !== "");

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
				REQUIRED_ATTRIBUTES: requiredAttributes,
				CREATED_AT: id ? undefined : new Date().toISOString(),
				UPDATED_AT: new Date().toISOString(),
			};

			// จัดการเรื่อง ID สำหรับ Mock API
			if (!id) {
				payload.CATEGORY_ID = Math.floor(1000 + Math.random() * 9000);
			} else {
				payload.CATEGORY_ID = parseInt(id); // หรือดึงจากข้อมูลเดิม
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
			}
		} catch (error) {
			await showMessage(error.message, "error");
		} finally {
			await showLoader({ show: false });
		}
	});
}

window.addCategoryAttrTag = (val = "") => {
	const html = `
        <div class="flex items-center gap-1 bg-white border border-primary/30 pl-3 pr-1 py-1 rounded-full shadow-sm group hover:border-primary transition-all attr-tag-item">
            <input type="text" class="bg-transparent border-none outline-none text-xs font-bold text-primary w-24 attr-tag-input" 
                   placeholder="Spec Name..." value="${val}">
            
            <button type="button" class="btn btn-ghost btn-xs btn-circle text-error hover:bg-error/10" 
                    onclick="$(this).closest('.attr-tag-item').remove()">✕</button>
        </div>`;

	$("#category_attr_tags").append(html);
};
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
