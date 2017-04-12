// 2017-04-10
define([
	'Df_Payment/withOptions', 'jquery'
], function(parent, $) {'use strict'; return parent.extend({
	defaults: {df: {test: {showBackendTitle: false}}},
	/**
	 * 2017-04-12
	 * @used-by optionsA()
	 * @returns {Object}
	 */
	options: function() {
		debugger;
		return {'a': 'option 1', 'b': 'option 2'};
	},
});});