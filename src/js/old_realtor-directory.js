/* global jQuery: false, endpoints: false, */

import Vue from 'vue';

const rDirMother = document.querySelector('#realtor-dir');

if (rDirMother) {
    new Vue({
        el: rDirMother,
        data: {
            results: {},
            search: '',
            office: '',
            offices: {},
            loading: false,
            showBios: [],
            langs: false,
            showAppraisers: false,
        },
        mounted: function () {
            this.getData();
        },
        computed: {
            filteredResults: function(){
                let results = this.results;

                if (this.search || this.office || this.langs || this.showAppraisers) {
                    let search = this.search.toLowerCase();
                    let officeName = this.office;
                    let langs = this.langs;
                    let showAppraisers = this.showAppraisers;

                    if (search || officeName || langs || showAppraisers) {
                        return results.filter((office) => {
                            if (
                                (office.slug == officeName || !officeName)
                                &&
                                office.agent_names.indexOf(search) > -1
                                &&
                                (office.agent_langs == langs || !langs)
                                &&
                                (office.agent_titles.indexOf('appraiser') > -1 || !showAppraisers)
                            ) {
                                return office;
                            }
                        })
                    } else {
                        return results;
                    }

                } else {
                    return results;
                }
            }
        },
        methods: {
            agentHasBioShowing: function (agent_slug){
                if(agent_slug) {
                    // return this.showBios.includes(agent_slug);
                    return this.showBios.indexOf(agent_slug) > -1;
                } else {
                    return false;
                }
            },
            toggleBio: function(agent_slug) {
                if (!this.showBios) {
                    return;
                }

                // if (this.showBios.includes(agent_slug)) {
                if (this.showBios.indexOf(agent_slug) > -1) {
                    const index = this.showBios.indexOf(agent_slug);
                    if (index > -1) {
                        this.showBios.splice(index, 1);
                    }
                } else {
                    this.showBios.push(agent_slug);
                }
            },
            agentIncludes: function (office_agent) {
                let search = this.search.toLowerCase();
                if(search) {
                    // if (office_agent.searchable.includes(search)) {
                    if (office_agent.searchable.indexOf(search) > -1) {
                        return true;
                    } else {
                        return false;
                    }
                } else {
                    return true;
                }
            },
            clearSearch: function () {
                this.search = '';
                this.office = '';
                this.langs = false;
            },
            getData: function(){
                let self = this;
                this.loading = true;

                jQuery.ajax({
                    url: endpoints.realtors,
                    type: 'GET',
                    success: function(data){
                        // console.log('success');
                        // console.log(this.url);
                        self.results = data.results;
                        self.offices = data.offices;
                        self.loading = false;
                    },
                    error: function(jqXHR, textStatus, errorThrown){
                        console.log('jqXHR: ', jqXHR);
                        console.log('textStatus: ', textStatus);
                        console.log('errorThrown: ', errorThrown);
                        console.log('status: ', jqXHR.status);
                        console.log('responseText: ', jqXHR.responseText);
                        self.loading = false;
                    }
                });
            }
        }
    });
}
