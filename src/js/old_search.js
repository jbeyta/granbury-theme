/* global jQuery: false */

import Vue from 'vue';

(function () {
	'use strict';

	const searchForms = document.querySelectorAll('.searchform_js');
	if (searchForms.length) {
		for (let sf = 0; sf < searchForms.length; sf++) {
			const searchForm = searchForms[sf];

			new Vue({
				el: searchForm,
				data: {
					results: {},
					input: '',
					more: {},
					searching: false,
					open: false,
				},
				methods: {
					toggleOpen: function() {
						this.open = !this.open;
					},
					reset: function () {
						this.results = {};
						this.input = '';
						this.more = {};
					},
					cw_ajax_search: function (words) {
						let self = this;
						let formData = new FormData();

						formData.append('s', this.input);

						Vue.set(this.more, 'url', '/?s=' + this.input);

						jQuery.ajax({
							url: search_route,
							data: formData,
							processData: false,
							contentType: false,
							type: "POST",
							beforeSend: function (xhr) {
								self.searching = true;
							},
							success: function (results) {
								self.results = {};

								if (results.length) {
									self.results = results;
								} else {
									Vue.set(self.more, 'url', '');
								}

								self.searching = false;
							},
							error: function (msg) {
								console.log('error');
								console.log(msg);
								self.searching = false;
							}
						});
					}
				}
			});	
		}
	}

}());