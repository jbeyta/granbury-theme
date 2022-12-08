import React from 'react';
import ReactDOM from 'react-dom';
import SearchForm from './SearchForm';

const searchFields = document.getElementsByClassName('search-form');
 
if( searchFields.length ) {
	for( let i=0; i < searchFields.length; i++ ) {
		ReactDOM.render(<SearchForm />, searchFields[ i ]);
	}
}