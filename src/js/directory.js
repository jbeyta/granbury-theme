(function () {
    'use strict';

    // office select
    const offSel = document.querySelector('.jto-names');
    if(offSel) {
        offSel.addEventListener('change', function(e){
            const target = e.currentTarget.value;

            if(target) {
                const targetEL = document.querySelector('#' + target);

                if(targetEL) {
                    window.scrollTo({
                        'behavior': 'smooth',
                        'left': 0,
                        'top': targetEL.offsetTop - 100
                    });
                }
            }
        });
    }

    // aff cat select
    const affCatSel = document.querySelector('#aff-cats');
    if(affCatSel) {
        affCatSel.addEventListener('change', function(e){
            const url = e.currentTarget.value;
            window.location.href = url;
        });
    }
}());