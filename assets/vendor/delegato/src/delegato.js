/*
 * delegato
 * https://github.com/MiniPlugins/delegato
 *
 * Copyright (c) 2015 Berto Yáñez, Óscar Otero
 * Licensed under the MIT license.
 */
(function (factory) {
    if (typeof define === 'function' && define.amd) {
    define(['jquery'], factory);
} else {
    factory(jQuery);
}
}(function ($) {

    var pluginName = "delegato",
        defaults = {
            includeJquery: false
        };

    function Delegato (element, options) {
        this.element = element;
        this.settings = $.extend({}, defaults, options);

        this.pattern = /(?:\(([^\)]+)\))?([^:|]+):?([^|]+)?/;

        this.actions = {};

        this.init();
    }

    Delegato.prototype = {
        init: function () {
            var availableActions = this.actions;
            var actionPattern = this.pattern;
            var includeJquery = this.settings.includeJquery;

            var isValidSelector = function(selector) {
                var $element;
                try {
                    $element = $(selector);
                } catch(e) {
                    return false;
                }
                return $element;
            };

            var parseTarget = function($this, target) {
                var selectorParts = target.match(/^([^@]+)(?:@(.*))?$/);

                var selectorTarget = selectorParts[1];
                var selectorModifier = selectorParts[2];

                if(!selectorTarget) {
                    throw new Error('Invalid selector');
                }

                var $parsedSelector;

                switch(selectorTarget) {
                    case 'this':
                        $parsedSelector = $this;
                        break;
                    case 'parent':
                        $parsedSelector = $this.parent();
                        break;
                    case 'next':
                        $parsedSelector = $this.next();
                        break;
                    case 'prev':
                        $parsedSelector = $this.prev();
                        break;
                    case 'parent-next':
                        $parsedSelector = $this.parent().next();
                        break;
                    case 'parent-prev':
                        $parsedSelector = $this.parent().prev();
                        break;
                    default:
                        $parsedSelector = isValidSelector(selectorTarget);
                        break;
                }

                if(!$parsedSelector) {
                    throw new Error('Invalid selector');
                }

                return selectorModifier ? $parsedSelector.find(selectorModifier) : $parsedSelector;
            };


            $(this.element).on('click', '[data-action]', function (e) {
                var $this = $(this);

                var actions = $this.data('action');
                var globalTarget = $this.data('target') || $this.attr('href');


                actions.split('|').forEach(function(action) {
                    var parts = action.match(actionPattern);

                    if(parts) {
                        var selector = parts[1] ? parts[1] : globalTarget;
                        var command = parts[2];
                        var args = parts[3] ? parts[3].split(',') : [];

                        var $selector = parseTarget($this, selector);

                        if($.isFunction(availableActions[command])) {
                            args.unshift(e);
                            availableActions[command].apply($selector, args);
                        } else if (includeJquery && $.isFunction($selector[command])) {
                            $selector[command].apply($selector, args);
                        } else {
                            throw new Error('Malformed action');
                        }
                    }
                });

                e.stopPropagation();
                e.preventDefault();
            });
        },
        register: function(name, func) {
            this.actions[name] = func;
        },
        unregister: function(name) {
            if(this.actions[name]) {
                delete this.actions[name];
            }
        }
    };

    $.fn[pluginName] = function (options) {
        if ((options === undefined) || (typeof options === 'object')) {
            return this.each(function () {
                if (!$.data(this, "plugin_" + pluginName)) {
                    $.data(this, "plugin_" + pluginName, new Delegato(this, options));
                }
            });
        }

        if ((typeof options === 'string') && (options[0] !== '_') && (options !== 'init')) {
            var returns, args = arguments;

            this.each(function () {
                var instance = $.data(this, 'plugin_' + pluginName);

                if ((instance instanceof Delegato) && (typeof instance[options] === 'function')) {
                    returns = instance[options].apply(instance, Array.prototype.slice.call(args, 1));
                }

                if (options === 'destroy') {
                    $.data(this, 'plugin_' + pluginName, null);
                }
            });

            return returns !== undefined ? returns : this;
        }
    };
}));