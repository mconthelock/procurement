import { downloadOrOpenFile } from "@amec/webasset/api/file";
import { createModal, setModal } from "@amec/webasset/components/modal";
import { readInput } from "@amec/webasset/excel";
import { showLoader } from "@amec/webasset/preloader";
import { showErrorMessage, showMessage } from "@amec/webasset/utils";
import { uploadOrigin } from "./data";
import { currentUser } from "@amec/webasset/api/amec";

export const modalUpload = {
	id: "modal-upload",
	inputFile: function () {
		return $("#excel-file");
	},
	selectedFileName: function () {
		return $("#selected-file-name");
	},
	show(isShow) {
		if (isShow) {
			this.inputFile().val("");
			this.selectedFileName().text("Please select an Excel file");
		}
		$("#" + this.id).prop("checked", isShow ? "checked" : false);
	},
	init: async function () {
		const modal = createModal({
			id: this.id,
			title: "Import Data by Excel Template",
			// headerDivider: false,
			footerDivider: false,
			closeBackdrop: false,
			className: "self-start mt-[1%]",
			body: `
                <div class="flex flex-col gap-5">
                    <div class="alert alert-warning shadow-sm">
                        <i class="fi fi-rr-triangle-warning text-xl"></i>

                        <div class="text-sm">
                            <div class="font-bold text-base">Important!</div>
                            <div>
                                Please fill in
                                <strong>Bulk Code</strong> and
                                <strong>Country</strong>
                                for each row.
                            </div>
                            <div class="font-bold text-red-700 mt-1">
                                ⚠ Rows without Bulk Code or Country will NOT be saved.
                            </div>
                        </div>
                    </div>
                    <!-- Upload Area -->
                    <div class="flex items-center gap-4 p-4 rounded-xl bg-base-200/50 border border-base-300">
                        <div class="flex items-center justify-center w-12 h-12 rounded-lg bg-primary/10">
                            <i class="fi fi-sr-file-excel text-2xl text-primary"></i>
                        </div>

                        <div class="flex-1 min-w-0">
                            <div class="font-semibold">
                                Excel File
                            </div>

                            <div
                                id="selected-file-name"
                                class="text-sm text-base-content/60 truncate"
                            >
                                Please select an Excel file
                            </div>
                        </div>

                        <label
                            for="excel-file"
                            class="btn btn-outline btn-sm cursor-pointer"
                        >
                            <i class="fi fi-sr-folder-open"></i>
                            Choose File
                        </label>

                        <input
                            type="file"
                            id="excel-file"
                            class="hidden"
                            accept=".xlsx,.xls"
                        />

                    </div>

                    <!-- Actions -->
                    <div class="flex justify-end gap-3">

                        <button
                            id="template-excel"
                            class="btn btn-outline"
                            type="button"
                        >
                            <i class="fi fi-sr-file-download text-lg"></i>
                            <span>Download Template</span>
                        </button>

                        <button
                            id="upload-excel"
                            class="btn btn-primary"
                            type="button"
                        >
                            <i class="fi fi-sr-file-upload text-lg"></i>
                            <span>Upload Excel</span>
                        </button>

                    </div>
                </div>

            `,
		});
		$("body").append(modal);
		this.bindEvent();
	},
	reset: function () {
		setModal({
			id: this.id,
			body: ``,
		});
	},
	bindEvent: function () {
		const self = this;
		/**
		 * @author Sutthipong Tangmongkhoncharoen(24008)
		 * @since 2026-09-07
		 * @description Handles the download of the Excel template for country origin.
		 */
		$(document).on("click", "#template-excel", async function () {
			try {
				await downloadOrOpenFile({
					baseDir: process.env.FILE_TEMPLATE,
					storedName: "country-origin-template.xlsx",
					mode: "download",
				});
			} catch (error) {
				console.error(error);
				showErrorMessage(error.message);
			}
		});
		/**
		 * @author Sutthipong Tangmongkhoncharoen(24008)
		 * @since 2026-09-07
		 * @description Handles the selection of an Excel file for upload.
		 */
		$(document).on("change", "#excel-file", function () {
			const file = this.files[0];
			if (!file) {
				self.selectedFileName().text("Please select an Excel file").removeClass("text-success");
				return;
			}

			const size = (file.size / 1024 / 1024).toFixed(2);
			self.selectedFileName().html(`
                <i class="fi fi-sr-file-excel text-success"></i>
                ${file.name}
                <span class="text-base-content/50">(${size} MB)</span>
            `);
		});

		/**
		 * @author Sutthipong Tangmongkhoncharoen(24008)
		 * @since 2026-09-08
		 * @description Handles the upload of the selected Excel file.
		 */
		$(document).on("click", "#upload-excel", async function () {
			try {
				showLoader();
				const file = self.inputFile()[0].files[0];
				if (!file) {
					showMessage("Please select an Excel file to upload.", "warning");
					return;
				}
				const user = await currentUser();
				const data = await readInput(file, {
					maxReadRow: 10000,
					headerRow: 1,
					startRow: 2,
					headerName: [
						{ key: "BULKCODE", header: "BULK Code", column: "A" },
						{ key: "ORIGIN_TYPE", header: "Type", column: "B" },
						{ key: "COUNTRY", header: "Country of Origin", column: "C" },
						{ key: "MFG_NAME", header: "Manufacturer Name", column: "D" },
						{ key: "MFG_ADDRESS", header: "Manufacturer Address", column: "E" },
					],
				});
				const mapData = data
					.map((row) => ({
						...row,
						CREATEBY: user.empno,
						ORIGIN_TYPE:
							row.ORIGIN_TYPE == "Trading"
								? 1
								: row.ORIGIN_TYPE == "Processing"
									? 2
									: row.ORIGIN_TYPE == "Manufacturer"
										? 3
										: null,
					}))
					.filter((row) => row.BULKCODE && row.COUNTRY);
				const res = await uploadOrigin(mapData);
				if (!res.status) {
					throw new Error(res.message);
				}
				showMessage("Upload successful.", "success");
				self.show(false);
			} catch (error) {
				console.error(error);
				showErrorMessage(error.message);
			} finally {
				showLoader({ show: false });
			}
		});
	},
};
