/* global jQuery: false, endpoints: false */

const importButton = document.querySelector('#realtor-import');

if(importButton) {
    importButton.addEventListener('click', function() {
        jQuery.ajax({
            url: endpoints.manualimport,
            type: 'GET',
            success: function(data){
                console.log('success');
                console.log(data);
            },
            error: function(jqXHR, textStatus, errorThrown){
                console.log('jqXHR: ', jqXHR);
                console.log('textStatus: ', textStatus);
                console.log('errorThrown: ', errorThrown);
                console.log('status: ', jqXHR.status);
                console.log('responseText: ', jqXHR.responseText);
            }
        });
    });
}