define([
	'jquery',
	'loader',
	'./entity-collection'
], function ($, loader, collection) {
	return {
		init: function ($element) {
			$element
				.on('change', '.format-child-add', function (e) {
					if (this.value === '0') {
						return;
					}

					var $this = $(this),
						$container = $(this).parent().parent(),
						template = $container.siblings('script[type="js-template"][data-type="' + this.value + '"]').html(),
						num = $container.siblings('div').length;

					template = template.replace(/\:\:n\:\:/g, num);

					loader.init($(template).hide().insertBefore($container).slideDown('normal'));

					$this.val('0');

					e.preventDefault();
				});
				
			collection.initBtnEvents($element);
		}
	};
});