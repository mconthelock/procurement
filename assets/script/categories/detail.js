import { showLoader } from "@amec/webasset/preloader";
import { showMessage } from "@amec/webasset/utils";
import { getCategories } from "../service/index.js";

const API_URL = `${process.env.MOCK_API}/categories`;

$(document).ready(async () => {
	try {
		const id = $("#cat_id_hidden").val();
		if (id) {
			await showLoader();
			const data = await getCategories(id);
			fillCategoryForm(data);
		}
		initSubmit();
	} catch (error) {
		console.error(error);
		await showMessage("Error loading category data");
	} finally {
		await showLoader({ show: false });
	}
});

function fillCategoryForm(data) {
	$("#CATEGORY_NAME").val(data.CATEGORY_NAME);
	$("#DESCRIPTION").val(data.DESCRIPTION);
	$("#CATEGORY_OWNER").val(data.CATEGORY_OWNER);
	$("#CATEGORY_STATUS").val(
		data.CATEGORY_STATUS !== undefined ? data.CATEGORY_STATUS : 1,
	);
}

function initSubmit() {
	$("#categoryForm").on("submit", async function (e) {
		e.preventDefault();

		// --- Validation ---
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

			const payload = {
				CATEGORY_NAME: $("#CATEGORY_NAME").val().trim(),
				DESCRIPTION: $("#DESCRIPTION").val().trim(),
				CATEGORY_OWNER: $("#CATEGORY_OWNER").val().trim(),
				CATEGORY_STATUS: parseInt($("#CATEGORY_STATUS").val()),
				UPDATED_AT: new Date().toISOString(),
			};

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
				throw new Error("Failed to save category");
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
