(function () {
	const amecdomain = (host, state) => {
		if (state == "local") return;
		const isdomain = host.indexOf("mitsubishielevatorasia.co.th");
		var s = host.split("/");
		if (isdomain == -1) {
			window.location.replace(
				"https://" + s[2] + ".mitsubishielevatorasia.co.th/" + s[3],
			);
		}

		const currenturl = window.location.href;
		const protocol = window.location.protocol;
		if (protocol == "http:") {
			const url = currenturl.replace(protocol, "https:");
			window.location.replace(url);
		}
	};

	const checkCookie = () => {
		var iscookie = "";
		const name = document.querySelector('meta[name="appname"]').content;
		const cookies = document.cookie.split(";");
		for (let cookie of cookies) {
			cookie = cookie.trim();
			if (cookie.startsWith(name + "=")) {
				iscookie = cookie.substring(name.length + 1);
			}
		}

		return iscookie;
	};

	// Swich Theme
	const savedTheme = localStorage.getItem("theme") || "light"; // ค่าเริ่มต้นเป็น 'light'
	document.documentElement.setAttribute("data-theme", savedTheme);
	document.documentElement.setAttribute("class", savedTheme);
	if (localStorage.getItem("pin") === "false") {
		document.documentElement.classList.add("sidebar-collapsed");
	}
	localStorage.setItem("theme", savedTheme);
	document.addEventListener("DOMContentLoaded", function () {
		if (savedTheme === "dark") {
			const themeToggle = document.getElementById("theme");
			if (themeToggle) themeToggle.checked = true;
		}
	});

	// Skip cross-document View Transition when leaving the app (e.g. redirect/logout to /form/authen)
	// so the pinned app-sidebar snapshot doesn't linger over the destination splash/login page.
	document.addEventListener(
		"click",
		(event) => {
			if (event.target?.closest?.(".logout, #delete-cookie")) {
				document.documentElement.classList.add("leaving-app");
			}
		},
		true,
	);

	window.addEventListener("pageswap", (event) => {
		if (!event.viewTransition) return;
		const destUrl = event.activation?.entry?.url || "";
		const appBase = (
			document.querySelector('meta[name="base_url"]')?.content || ""
		).replace(/\/+$/, "");
		if (
			document.documentElement.classList.contains("leaving-app") ||
			(destUrl &&
				appBase &&
				destUrl !== appBase &&
				!destUrl.startsWith(`${appBase}/`))
		) {
			event.viewTransition.skipTransition();
		}
	});

	// Register Service worker and Windows Notification
	if ("serviceWorker" in navigator) {
		window.addEventListener("load", () => {
			navigator.serviceWorker
				.register(`${host}/sw.js`, {
					scope: "./",
				})
				.then((reg) => {})
				.catch((err) =>
					console.error("Service Worker registration failed:", err),
				);
		});
	}

	const host = document.querySelector('meta[name="base_url"]').content;
	const state = document.querySelector('meta[name="appstatus"]').content;
	const appid = document.getElementById("appid");
	const domain = amecdomain(host, state);
	const cookie = checkCookie();
	if (cookie != "" && appid == 1) window.location.replace(`${host}home`);
})();
