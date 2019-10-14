/**
 * File customizer.js.
 *
 * Theme Customizer enhancements for a better user experience.
 *
 * Contains handlers to make Theme Customizer preview reload changes asynchronously.
 */

(function ($) {
	// Site description.
	wp.customize("blogdescription", function (value) {
		value.bind(function (to) {
			$(".site-description").text(to);
		});
	});

	// Header text color.
	wp.customize("header_textcolor", function (value) {
		value.bind(function (to) {
			if ("blank" === to) {
				$(".site-title, .site-description").css({
					clip: "rect(1px, 1px, 1px, 1px)",
					position: "absolute"
				});
			} else {
				$(".site-title, .site-description").css({
					clip: "auto",
					position: "relative"
				});
				$(".site-title, .site-description").css({
					color: to
				});
			}
		});
	});

	// Header image.
	wp.customize("header_image", function (value) {
		value.bind(function (newval) {
			$(".site-header").css("background-image", "url(" + newval + ")");
		});
	});

	// Wait for the preview to be ready !
	wp.customize.bind("preview-ready", function () {

		// Fire custom js code after WP Customizer selective refresh has been made.
		if (
			"undefined" !== typeof wp &&
			wp.customize &&
			wp.customize.selectiveRefresh
		) {
			wp.customize.selectiveRefresh.bind("partial-content-rendered", function (
				navMenuPartial
			) {
				if ("menu-1" === navMenuPartial.context.theme_location) {
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

					/**
					 * After menu's selective refresh on tablet or mobile, show it to see modifications.
					 * This will also add a click() on desktop view, making the menu visible
					 * when view changes from desktop to tablet or mobile.
					 * To prevent this behaviour, the click() effect is removed when listening to view changes.
					 * @see mainNavCollapse
					 */
					let btn = document.querySelector(".navbar-toggler");
					if (!btn.classList.contains("collapsed")) {
						btn.click();
					}
				}
			});

			wp.customize.selectiveRefresh.bind("partial-content-rendered", function (
				siteTitle
			) {
				if ("blogname" === siteTitle.partial.id) {
					$("h1.site-title").slabText({
						"fontRatio": 0.3
					});
				}
			});

			// Set the previous previewed device to null.
			let previousPreviewedDevice = null;

			// Listen for a previewed-device message send from the Customizer.
			wp.customize.preview.bind('previewed-device', function (previewedDevice) {
				let body = $(document.body);
				if (previousPreviewedDevice) {
					body.removeClass(previousPreviewedDevice);
				}
				body.addClass(previewedDevice);
				previousPreviewedDevice = previewedDevice;

				/**
				 * Keep Edit Shortcut for site title after Slab when previewed device changes in Customizer.
				 * Target blogname shortcut and clone it withDataAndEvents and deepWithDataAndEvents.
				 * @see https://stackoverflow.com/a/9549716
				 * Then detect any device changes and prepend the clone to site title after 750 ms.
				 */
				let blognameShortcut = $(".customize-partial-edit-shortcut-blogname");
				let blognameShortcutClone = blognameShortcut.clone(true, true);
				if (previewedDevice) {
					setTimeout(function () {
						$(".site-title").prepend(blognameShortcutClone);
					}, 750);
				}

				/**
				 * Collapse the menu if view changes from tablet or mobile to desktop.
				 * This is to prevent the menu from being displayed
				 * if view changes from tablet or mobile to desktop
				 * then from desktop to tablet or mobile.
				 * @see mainNavCollapse
				 */
				let btn = document.querySelector(".navbar-toggler");
				if (previewedDevice === "desktop") {
					btn.classList.add("collapsed");
					btn.nextElementSibling.classList.remove("show");
					document.querySelector("#mainNav").style.height = "";
				}
			});			

			// Listen for a pane-visible message send from the Customizer.
			wp.customize.preview.bind('pane-visible', function (paneVisible) {
				let blognameShortcut = $(".customize-partial-edit-shortcut-blogname");
				let blognameShortcutClone = blognameShortcut.clone(true, true);
				/**
				 * Shortcut icons are created after preview-ready.
				 * paneVisibilble is true on first load but we don't listen to it,
				 * so it doesn't affect the true value of false/true logic.
				 * When paneVisible is false, blognameShortcut is previously created,
				 * a deep clone of blognameShortcut is prepended to site title,
				 * on desktop view only, with a setTimeout to insure that
				 * it will persist in the DOM even if shortcuts are removed
				 * when paneVisible is false.
				 * Then, when paneVisible is true, on desktop view only,
				 * the deep clone in the DOM is prepended to site title,
				 * with a setTimeout to insure that it will persist.
				 */
				if (paneVisible === false && $("body").hasClass("desktop")) {
					setTimeout(function () {
						$(".site-title").prepend(blognameShortcutClone);
					}, 750);
				} else if (paneVisible === true && $("body").hasClass("desktop")) {
					setTimeout(function () {
						$(".site-title").prepend(blognameShortcutClone);
					}, 750);
				}
			});
		}
	});
})(jQuery);
