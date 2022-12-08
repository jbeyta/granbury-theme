// import breakpoints from css
window.breakpoint = {};
window.breakpoint.refreshValue = function () {
	this.value = window.getComputedStyle(document.querySelector('body'), ':before').getPropertyValue('content').replace(/\"/g, '');
	// console.log(this.value);
};