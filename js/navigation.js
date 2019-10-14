/**
 * File navigation.js.
 *
 * Plugin : bsWalker.js
 * GitHub Repository : https://github.com/LebCit/bsWalker.js
 * Author: LebCit
 * Author URI: https://github.com/LebCit
 * Description: A lightweight JavaScript Walker, with no dependencies, to implement Bootstrap 4.0+ multilevel dropdown navigation in WordPress.
 * Bootstrap Navbar JS Walker.
 * Navigation support for multilevel dropdown menus.
 */
; (function () {

	"use strict"; // Start of use strict

	/**
	 * Helper function to fade in with vanilla JavaScript.
	 * @param {Object} el - The element.
	 * @property {boolean} smooth - Smooth fade-in animation.
	 * @param {string} displayStyle - Display style of element.
	 * @see {@link https://www.ilearnjavascript.com/plainjs-fadein-fadeout/ - I Learn Javascript}
	 */
	const fadeIn = (el, smooth = true, displayStyle = "block") => {
		el.style.opacity = 0;
		el.style.display = displayStyle;
		if (smooth) {
			let opacity = 0;
			let request;

			const animation = () => {
				el.style.opacity = opacity += 0.04;
				if (opacity >= 1) {
					opacity = 1;
					cancelAnimationFrame(request);
				}
			};

			const rAf = () => {
				request = requestAnimationFrame(rAf);
				animation();
			};
			rAf();

		} else {
			el.style.opacity = 1;
		}
	};

	let el = document.getElementById("mainNav");
	// Wait for the whole page to be loaded including styles.
	window.addEventListener("load", () => {
		fadeIn(el);
	}, false);


	/**
	 * Helper function to set multiple attributes at once.
	 * @param {Object} el - The element.
	 * @param {Object[]} attrs - The element's attributes.
	 * @see {@link https://stackoverflow.com/a/46372063 - Stack Overflow}
	 */
	function setAttributes(el, attrs) {
		Object.keys(attrs).forEach(key => el.setAttribute(key, attrs[key]));
	}

	let mainParentMenuItem = document.querySelectorAll(".navbar-nav > li"),
		parentMenuItem = document.querySelectorAll(".navbar-nav .menu-item-has-children"),
		subMenu = document.querySelectorAll(".navbar-nav .menu-item-has-children .sub-menu");

	mainParentMenuItem.forEach(item => {
		item.classList.add("nav-item");
		item.firstChild.classList.add("nav-link");
	});

	parentMenuItem.forEach(item => {
		item.classList.add("dropdown");
		item.firstChild.classList.add("dropdown-toggle");
		let parentMenuItemId = item.id.slice(10);
		setAttributes(item.firstChild, {
			"id": "menu-item-dropdown-" + parentMenuItemId,
			"href": "#",
			"data-toggle": "dropdown",
			"aria-haspopup": "true",
			"aria-expanded": "false"
		});
	});

	subMenu.forEach(ulElement => {
		ulElement.classList.add("dropdown-menu");
		let parentMenuItemId = ulElement.parentElement.id.slice(10);
		setAttributes(ulElement, {
			"aria-labelledby": "menu-item-dropdown-" + parentMenuItemId,
			"role": "menu"
		});
		let subMenuMainItem = ulElement.querySelectorAll("li");
		subMenuMainItem.forEach(itemChildren => {
			itemChildren.classList.add("nav-item"); // Blue background on hover/click.
			itemChildren.firstChild.classList.add("dropdown-item");
		});
	});

	// Multilevel dropdown.
	let subParentMenuItem = document.querySelectorAll(".navbar-nav .menu-item-has-children .sub-menu > li.menu-item-has-children");
	subParentMenuItem.forEach(subItem => {
		subItem.classList.remove("dropdown");
		subItem.classList.add("dropdown-submenu");
		subItem.firstChild.addEventListener("click", function (event) {
			event.preventDefault();
			event.stopPropagation();
			this.nextElementSibling.classList.toggle("show");
			if (!this.nextElementSibling.classList.contains("show")) {
				let parentItem = this.parentElement.querySelectorAll(".show");
				parentItem.forEach(element => {
					element.classList.remove("show");
				});
			}
			let mainParentItem = this.closest("li.nav-item.dropdown.show");
			let show = mainParentItem.lastElementChild.querySelectorAll(".show");
			document.addEventListener("click", (event) => {
				if (mainParentItem !== event.target && !mainParentItem.contains(event.target)) {
					show.forEach(element => {
						element.classList.remove("show");
					});
				}
			}, false);
			mainParentItem.firstChild.addEventListener("click", (event) => {
				if (event.target) {
					show.forEach(element => {
						element.classList.remove("show");
					});
				}
			}, false);
		}, false);
	});

	// For Mobile Menu Only.
	let btn = document.querySelector(".navbar-toggler");
	btn.addEventListener("click", function () {
		document.body.style.overflowY = "hidden";
		this.offsetParent.style.height = "100%";
		this.offsetParent.style.overflowY = "scroll";
		if (this.nextElementSibling.classList.contains("show")) {
			document.body.style.overflowY = "scroll";
			this.offsetParent.style.height = "";
			this.offsetParent.style.overflowY = "hidden";
		}
	}, false);

})(); // End of use strict