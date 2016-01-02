define([
	'jquery',
	'loader',
], function ($, loader) {
	return {
		init: function ($element) {
			$element
				.on('click', '.format-child-add', function (e) {
					var $this = $(this),
						$container = $(this).parent().parent(),
						template = $container.siblings('script[type="js-template"]').html(),
						num = $container.siblings('div').length;

					template = template.replace(/\:\:n\:\:/g, num);

					loader.init($(template).hide().insertBefore($container).slideDown('normal'));

					e.preventDefault();
				});

			initBtnEvents($element);
		},
		initBtnEvents: initBtnEvents
	}

	function initBtnEvents ($element) {
		$element
			.on('click', '.format-child-remove', function (e) {
				if (confirm('Are you sure?')) {
					var $this = $(this).parent().parent();

					$this.slideUp('normal', function () {
						$this.remove();
					});
				}

				e.preventDefault();
			})
			.on('click', '.format-child-up', function (e) {
				var $this = $(this).parent().parent();
				var $sibling = $this.prev();

				if ($sibling.length) {
					loader.destroy($this);
					$this.insertBefore($sibling);
					loader.init($this);
				}

				e.preventDefault();
			})
			.on('click', '.format-child-down', function (e) {
				var $this = $(this).parent().parent();
				var $sibling = $this.next();

				if ($sibling.length) {
					loader.destroy($this);
					$this.insertAfter($sibling);
					loader.init($this);
				}

				e.preventDefault();
			});
	}
});