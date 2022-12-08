(function () {
	'use strict';
	
	const bodyEl = document.querySelector('body');

	let breakpoint = {};
	breakpoint.refreshValue = function () {
		this.value = window.getComputedStyle(bodyEl, ':before').getPropertyValue('content').replace(/\"/g, '');
		// console.log(this.value);
	};

	document.addEventListener("DOMContentLoaded", function () {
		// nav toggle
		const htmlEl = document.querySelector('html');

		if (hasClass(htmlEl , 'touch') || breakpoint.value == 'phone') {
			const menuToggle = document.querySelector('.menu-toggle');

			menuToggle.addEventListener('click', function (e) {
				e.preventDefault();

				let target = this.getAttribute('data-menu');
				toggleClass(document.querySelector('.' + target), 'open');
				toggleClass(bodyEl , 'mobile-nav-open');
			})
		}
	});

	// if close to top
	const cwNavCont = document.querySelector('.cw-nav-cont');

	if (cwNavCont) {
		const cwNavContPos = cwOffset(cwNavCont);
		let last_known_scroll_position = 0;
		let ticking = false;
		// scroll-stick
		window.addEventListener('scroll', function () {
			last_known_scroll_position = window.scrollY;
			if (!ticking) {
				window.requestAnimationFrame(function () {
					if (last_known_scroll_position >= cwNavContPos.top + 100) {
						addClass(cwNavCont, 'down');
					} else {
						removeClass(cwNavCont, 'down');
					}

					ticking = false;
				});

				ticking = true;
			}
		});
	}

	function cwOffset(el) {
		var rect = el.getBoundingClientRect(),
			scrollLeft = window.pageXOffset || document.documentElement.scrollLeft,
			scrollTop = window.pageYOffset || document.documentElement.scrollTop;
		return {
			top: rect.top + scrollTop,
			left: rect.left + scrollLeft
		}
	}

	// back to top
	const btt = document.querySelector('.back-to-top');
	if(btt) {
		window.addEventListener('scroll', function(){
			if (window.scrollY) {
				addClass(btt, 'showit');
			} else {
				removeClass(btt, 'showit');
			}
		});

		btt.addEventListener('click', function () {
			window.scrollTo({
				'behavior': 'smooth',
				'left': 0,
				'top': 0
			});
		});
	}

	// http://youmightnotneedjquery.com/
	function hasClass(el, className) {
		if (el.classList) {
			return el.classList.contains(className);
		} else {
			return new RegExp('(^| )' + className + '( |$)', 'gi').test(el.className);
		}
	}

	// http://youmightnotneedjquery.com/
	function toggleClass(el, className) {
		if (el.classList) {
			el.classList.toggle(className);
		} else {
			let classes = el.className.split(' ');
			let existingIndex = -1;

			for (let i = classes.length; i--;) {
				if (classes[i] === className) {
					existingIndex = i;
				}
			}

			if (existingIndex >= 0) {
				classes.splice(existingIndex, 1);
			} else { 
				classes.push(className);
			}

			el.className = classes.join(' ');
		}
	}

	function addClass(el, className) {
		if (el.classList) {
			el.classList.add(className);
		} else {
			var current = el.className, found = false;
			var all = current.split(' ');
			for (var i = 0; i < all.length, !found; i++) found = all[i] === className;
			if (!found) {
				if (current === '') el.className = className;
				else el.className += ' ' + className;
			}
		}
	}

	function removeClass(el, className) {
		if (el.classList)
			el.classList.remove(className);
		else
			el.className = el.className.replace(new RegExp('(^|\\b)' + className.split(' ').join('|') + '(\\b|$)', 'gi'), ' ');
	}
}());