export async function getVendors(q = "") {
	return new Promise((resolve, reject) => {
		$.ajax({
			url: `${process.env.APP_API}/pursys/vendors/search/`,
			type: "POST",
			dataType: "json",
			data: q,
			success: function (response) {
				resolve(response);
			},
			error: function (xhr, status, error) {
				reject(error);
			},
		});
	});
}
