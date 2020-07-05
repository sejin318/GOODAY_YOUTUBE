;(function($) {
	'use strict'

	$.extend(true, $.trumbowyg, {
		langs: {
			// jshint camelcase:false
			en: {
				fontsize: 'Font size',
				fontsizes: {
					'x-small': 'Extra small',
					small: 'Small',
					medium: 'Regular',
					large: 'Large',
					'x-large': 'Extra large',
					custom: 'Custom',
				},
				fontCustomSize: {
					title: 'Custom Font Size',
					label: 'Font Size',
					value: '48px',
				},
			},
			ko: {
				fontsize: '글씨크기',
				fontsizes: {
					'x-small': 'Extra small',
					small: 'Small',
					medium: 'Regular',
					large: 'Large',
					'x-large': 'Extra large',
				},
			},
		},
	})
	// jshint camelcase:true

	// Add dropdown with font sizes
	$.extend(true, $.trumbowyg, {
		plugins: {
			fontsize: {
				init: function(trumbowyg) {
					trumbowyg.addBtnDef('fontsize', {
						dropdown: buildDropdown(trumbowyg),
					})
				},
			},
		},
	})

	function buildDropdown(trumbowyg) {
		var dropdown = []
		var sizes = ['x-small', 'small', 'medium', 'large', 'x-large']

		$.each(sizes, function(index, size) {
			trumbowyg.addBtnDef('fontsize_' + size, {
				text:
					'<span style="font-size: ' +
					size +
					';">' +
					trumbowyg.lang.fontsizes[size] +
					'</span>',
				hasIcon: false,
				fn: function() {
					trumbowyg.execCmd('fontSize', index + 1, true)
				},
			})
			dropdown.push('fontsize_' + size)
		})

		return dropdown
	}
})(jQuery)
