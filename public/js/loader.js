define(['jquery'], function ($) {
	return {
		init: function ($element) {
			$element.find('[data-module]').each(function () {
				var $this = $(this);

				require(['modules/' + $this.attr('data-module')], function (module) {
					module.init($this);
				});

				$this.attr('data-module-destroy', $this.attr('data-module'));
				$this.removeAttr('data-module');
			});
		},
		destroy: function ($element) {
			$element.find('[data-module-destroy]').each(function () {
				var $this = $(this);

				require(['modules/' + $this.attr('data-module-destroy')], function (module) {
					if (module.destroy) {
						module.destroy($this);
					}
				});

				$this.attr('data-module', $this.attr('data-module-destroy'));
				$this.removeAttr('data-module-destroy');
			});
		}
	};
});