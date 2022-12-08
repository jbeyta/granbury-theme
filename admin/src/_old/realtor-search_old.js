/* global endpoints: false, currentposttype: false, jQuery: false */

import Vue from 'vue';

//document.addEventListener('DOMContentLoaded', function () {
    const cwrs = document.querySelector('.cw-realtor-search-mother');
    let post_title = document.querySelector('[name="post_title"]');
    const titlePromptText = document.querySelector('#title-prompt-text');
    const cmb2input = document.querySelector('#_cwmb_cwrealtor');

    if (currentposttype == 'cwextrarealtors') {
        post_title = null;
    }

    if (cwrs) {
        new Vue({
            el: cwrs,
            data: {
                results: {},
                realtor: '',
                search: '',
                loading: false,
                wholethingbroke: false
            },
            mounted: function () {
                this.getData();
                if (!cmb2input) {
                    this.wholethingbroke = true;
                }
            },
            computed: {
                filtered: function () {
                    if (this.search) {
                        let realtors = this.results;
                        let search = this.search.toLowerCase();

                        return realtors.filter((realtor) => {
                            if (
                                realtor.name.toLowerCase().includes(search)
                            ) {
                                return realtor;
                            }
                        });
                    } else {
                        return [];
                    }
                }
            },
            methods: {
                getSavedData: function () {
                    if (cmb2input && cmb2input.value) {
                        this.realtor = cmb2input.value;
                    }
                },
                thisone: function (slug) {
                    this.realtor = slug;
                    this.search = '';

                    let name = '';
                    for (let i = 0; i < this.results.length; i++) {
                        const rltr = this.results[i];
                        if (rltr.slug == slug) {
                            name = rltr.name;
                        }
                    }

                    if (cmb2input) {
                        cmb2input.value = slug;
                    }

                    if (post_title) {
                        titlePromptText.classList.add('screen-reader-text');
                        post_title.value = name;
                    }
                },
                getData: function () {
                    let self = this;
                    this.loading = true;

                    jQuery.ajax({
                        url: endpoints.justrealtors,
                        type: 'GET',
                        success: function (data) {
                            self.results = data;
                            self.getSavedData();
                            self.loading = false;
                            //console.log(data);
                            
                        },
                        error: function (jqXHR, textStatus, errorThrown) {
                            console.log('jqXHR: ', jqXHR);
                            console.log('textStatus: ', textStatus);
                            console.log('errorThrown: ', errorThrown);
                            console.log('status: ', jqXHR.status);
                            console.log('responseText: ', jqXHR.responseText);
                        }
                    });
                    
                }
            }
        });
    }

    //offices
    const cwos = document.querySelector('.cw-office-search-mother');
    if (cwos) {
        const cmb2OfficeInput = document.querySelector('#_cwmb_cwoffice');

        new Vue({
            el: cwos,
            data: {
                results: {},
                office: '',
                search: '',
                loading: false,
                wholethingbroke: false
            },
            mounted: function () {
                this.getData();
                if (!cmb2OfficeInput) {
                    this.wholethingbroke = true;
                }
            },
            computed: {
                filtered: function () {
                    if (this.search) {
                        let offices = this.results;
                        let search = this.search.toLowerCase();

                        return offices.filter((office) => {
                            if (
                                office.name.toLowerCase().includes(search)
                            ) {
                                return office;
                            }
                        });
                    } else {
                        return [];
                    }
                }
            },
            methods: {
                getSavedData: function () {
                    if (cmb2OfficeInput && cmb2OfficeInput.value) {
                        this.office = cmb2OfficeInput.value;
                    }
                },
                thisone: function (mlsid) {
                    this.office = mlsid;
                    this.search = '';

                    let name = '';
                    for (let i = 0; i < this.results.length; i++) {
                        const offc = this.results[i];
                        if (offc.officemlsid == mlsid) {
                            name = offc.name;
                        }
                    }

                    if (cmb2OfficeInput) {
                        cmb2OfficeInput.value = mlsid;
                    }

                    if (post_title) {
                        titlePromptText.classList.add('screen-reader-text');
                        post_title.value = name;
                    }
                },
                getData: function () {
                    let self = this;
                    this.loading = true;

                    jQuery.ajax({
                        url: endpoints.justoffices,
                        type: 'GET',
                        success: function (data) {
                            self.results = data;
                            self.getSavedData();
                            self.loading = false;
                            //console.log(data);
                            
                        },
                        error: function (jqXHR, textStatus, errorThrown) {
                            console.log('jqXHR: ', jqXHR);
                            console.log('textStatus: ', textStatus);
                            console.log('errorThrown: ', errorThrown);
                            console.log('status: ', jqXHR.status);
                            console.log('responseText: ', jqXHR.responseText);
                        }
                    });
                }
            }
        });
    }
//}, false);



