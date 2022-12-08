jQuery(function () {
	const $heroSlider = jQuery('.cwslider');

	if ($heroSlider) {
		var slides_count = $heroSlider.find('.slide').length;
		if (slides_count > 1) {
			const slkOpts = {
				arrows: true,
				dots: false,
				speed: 500,
				autoplaySpeed: 5500,
				autoplay: true,
				pauseOnHover: false,
			};

			$heroSlider.slick(slkOpts);
		} else {
			setTimeout(function () {
				$heroSlider.find('.slide').addClass('slick-active');
			}, 500);
		}
	}
});