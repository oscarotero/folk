define([
	'jquery'
], function ($) {
	return {
		init: function ($form) {
			var enabled = true;

			$form.on('click', 'button[name="method-override"]', function () {
				enabled = false;
			});

			$form.on('submit', function (e) {
				if (!enabled) {
					return;
				}

				e.preventDefault();

				setTimeout(function () {
					var data = new FormData($form[0]);

					console.log(data.get('method-override'));

					$.ajax({
						url: $form.attr('action'),
						type: $form.attr('method'),
						processData: false,
						contentType: false,
						data: data,
						success: function () {
							alert('Ok!');
						}
					});
				}, 1);
			});
		}
	};
});