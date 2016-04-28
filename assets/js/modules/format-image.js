define([
	'jquery',
	'./format-upload',
	'magnific-popup'
], function ($, upload) {
	return {
		init: function ($element) {
			upload.init($element);

			$element.on('click', '.ui-view', function (e) {
				e.preventDefault();
				
				$.magnificPopup.open({
					type: 'image',
					items: {
						src: $(this).attr('href')
					}
				})
			});
		},
		destroy: function ($element) {
			upload.destroy($element);
		}
	};
});