import React from 'react';
import ReactDOM from 'react-dom';
import RealtorSearch from './RealtorSearch'

const realtorDir = document.getElementById('cw-realtor-search-mother')

if(realtorDir) {
    const cwmbcwrealtor = realtorDir.dataset.cwmbcwrealtor
    ReactDOM.render(<RealtorSearch cwmbcwrealtor={cwmbcwrealtor} />, realtorDir)
}

