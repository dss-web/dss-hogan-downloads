(function () {

	var boxButtons = document.querySelectorAll('.hogan-module-dss_downloads button');

	for (var i = 0; i < boxButtons.length; i++) {
		boxButtons[i].onclick = function (event) {
			event.preventDefault();
			const attrValue = this.getAttribute('aria-expanded') === 'true' ? 'false' : 'true';
			this.setAttribute('aria-expanded', attrValue);
			const itemContainer = this.nextElementSibling;
			if (itemContainer) {
				itemContainer.setAttribute('aria-hidden', (attrValue === 'true' ? 'false' : 'true'));
			}
		};
	}
})();
