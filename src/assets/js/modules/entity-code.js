define([
	'jquery'
], function ($) {
	var defaults = {
		lineNumbers: true,
		lineWrapping: true
	};

	var module = {
		init: function ($element) {
			var config = $.extend({}, defaults, $element.data('config') || {});

			var deps = ['codemirror'];

			if (config.mode) {
				deps.push('codemirror/mode/' + config.mode + '/' + config.mode);
			}

			require(deps, function (codemirror) {
				var $textarea = $element.find('textarea');
				var editor = codemirror.fromTextArea($textarea[0], config);

				//todo: plugins: fullscreen
				editor.addKeyMap({
					"Tab": function (cm) {
						if (cm.somethingSelected()) {
							var sel = editor.getSelection("\n");
							// Indent only if there are multiple lines selected, or if the selection spans a full line
							if (sel.length > 0 && (sel.indexOf("\n") > -1 || sel.length === cm.getLine(cm.getCursor().line).length)) {
								cm.indentSelection("add");
								return;
							}
						}

						if (cm.options.indentWithTabs) {
							cm.execCommand("insertTab");
						} else {
							cm.execCommand("insertSoftTab");
						}
					},
					"Shift-Tab": function (cm) {
						cm.indentSelection("subtract");
					}
				});

				$textarea.data('codemirror', editor);
			});
		},
		destroy: function ($element) {
			$element
				.find('textarea')
				.data('codemirror')
				.toTextArea();
		}
	};

	return module;
});