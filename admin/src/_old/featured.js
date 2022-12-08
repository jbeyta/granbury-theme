/* global endpoints: false, jQuery: false */
import Vue from 'vue';

const featuredIcons = document.querySelectorAll('.featured-icon');

if (featuredIcons.length) {
    for (let i = 0; i < featuredIcons.length; i++) {
        const el = featuredIcons[i];
        const postid = el.getAttribute('data-postid');

        new Vue({
            el: el,
            data: {
                loading: false,
                featured: '',
                message: 'Loading',
            },
            mounted: function () {
                this.getMeta();
            },
            methods: {
                changeMeta() {
                    if (this.featured == 'on') {
                        this.featured = '';
                    } else {
                        this.featured = 'on';
                    }

                    this.saveMeta();
                },
                getMeta() {
                    let self = this;
                    this.loading = true;
                    this.message = 'Loading';
                    self.loading = true;

                    jQuery.ajax({
                        url: endpoints.featuredget + '?postid=' + postid,
                        type: 'GET',
                        beforeSend: function (xhr) {},
                        success: function (data) {
                            console.log(data);
                            
                            self.featured = data;
                            self.loading = false;
                        },
                        error: function (jqXHR, textStatus, errorThrown) {
                            console.log('jqXHR: ', jqXHR);
                            console.log('textStatus: ', textStatus);
                            console.log('errorThrown: ', errorThrown);
                            console.log('status: ', jqXHR.status);
                            console.log('responseText: ', jqXHR.responseText);
                            self.loading = false;
                        }
                    });
                },
                saveMeta() {
                    let self = this;
                    this.message = 'Saving';
                    this.loading = true;

                    jQuery.ajax({
                        url: endpoints.featuredsave,
                        data: {
                            postid: postid,
                            isfeatured: self.featured
                        },
                        type: 'POST',
                        beforeSend: function (xhr) {},
                        success: function (data) {
                            console.log(data);
                            
                            self.getMeta();
                            self.loading = false;
                        },
                        error: function (jqXHR, textStatus, errorThrown) {
                            console.log('jqXHR: ', jqXHR);
                            console.log('textStatus: ', textStatus);
                            console.log('errorThrown: ', errorThrown);
                            console.log('status: ', jqXHR.status);
                            console.log('responseText: ', jqXHR.responseText);

                            self.getMeta();
                            self.loading = false;
                        }
                    });
                }
            }
        });
    }
}