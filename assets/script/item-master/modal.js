import { createModal, setModal } from "@amec/webasset/components/modal";

export const modalItemMaster = {
	id: "modal-item-master",
	show(isShow) {
		$("#" + this.id).prop("checked", isShow ? "checked" : false);
	},
	init: async function () {
		const modal = createModal({
			id: this.id,
			headerDivider: false,
			footerDivider: false,
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
	},
};
