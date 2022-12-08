import React from 'react';
import SearchResult from './SearchResult';

export default class SearchResults extends React.Component {
    constructor(props) {
        super(props);
    }

    render() {
        let results = '';

        if( this.props.loading ) {
            results = <div className="loading">LOADING</div>
;
        } else if( this.props.results.length > 0 ) {

            const _results = this.props.results.map( result => {
                return(<SearchResult key={result.id} result={result}/>);
            });

            results = <ul className="results styleless">
                {_results}
                <li className="more-results">
                    <a href={siteurl + '?s=' + this.props.searchTerms}>More Results</a>
                </li>
            </ul>;

        } else if( this.props.searched ) {
            results = <p className="no-results">Nothing Found</p>;
        }

        return (
            <div className="search-results">{results}</div>
        )
    }
}