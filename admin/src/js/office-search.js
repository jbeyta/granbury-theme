import React from 'react';
import ReactDOM from 'react-dom';
import OfficeSearch from './OfficeSearch'

const officeDir = document.getElementById('cw-office-search-mother')

if(officeDir) {
    const cwmbcwoffice = officeDir.dataset.cwmbcwoffice
    ReactDOM.render(<OfficeSearch cwmbcwoffice={cwmbcwoffice} />, officeDir)
}

