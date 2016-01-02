define(['jquery', 'jquery-lazyscript'], function ($) {
	return {
		init: function ($element) {
			var containerSelector = '.ui-autoload-container';
			var buttonSelector = '.ui-autoload-btn';
			var $container = $(containerSelector);
			var $window = $(window).lazyScript({
				selectorClass: buttonSelector.substr(1),
				callback: function ($button) {
					$button.click();
				}
			});

			$('body').on('click', buttonSelector, function (e) {
				var $this = $(this);

				$window.lazyScript('pause');

				$this.fadeTo('normal', 0.3);

				$.ajax({
					url: $(this).attr('href'),
				})
				.done(function (response) {
					var $temp = $('<div></div>').append($.parseHTML(response));

					$container.append($temp.find(containerSelector).children());
					$this.replaceWith($temp.find(buttonSelector));

					$window.lazyScript('resume');
				});

				e.preventDefault();
			});
		}
	};
});
