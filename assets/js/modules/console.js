define([
	'jquery'
], function ($) {
	return {
		init: function ($form) {
			var $input = $form.find('.console-input'),
				$output = $form.find('.console-output'),
				history = [],
				pos = 0;

			$form.on('submit', function (e) {
				e.preventDefault();

				$output.append('<div class="command-request">' + $input.val() + '</div>');

				var responseLength = false;

				$.ajax({
					method: $form.attr('method'),
					data: $form.serialize(),
					url: $form.attr('action'),
					xhrFields: {
						onprogress: function (e) {
							var response = e.currentTarget.response,
								data = (responseLength === false) ? response : response.substring(responseLength);

							responseLength = response.length;

							$output
							.append('<div class="command-response">' + data + '</div>')
							.scrollTop($output[0].scrollHeight);
						}
					}
				})
				.done(function () {
					history.push($input.val());
					pos = history.length;
					$input.val('');
				})
				.fail(function (data) {
					$output.append('<div class="command-response"><span class="error">Http error: ' + data + '</span></div>');
				});
			});

			$input.on('keypress', function (e) {
				switch (e.keyCode) {
					case 38: //up
						if (history[pos - 1] !== undefined) {
							$input.val(history[--pos]);
						}
						break;

					case 40: //down
						if (history[pos + 1] !== undefined) {
							$input.val(history[++pos]);
						} else {
							if (history[pos] !== undefined) {
								++pos;
							}

							$input.val('');
						}
						break;

					default:
						return;
				}

				e.preventDefault();
			});
		}
	};
});