import React from 'react';
import SearchResults from './SearchResults';

export default class SearchForm extends React.Component {
    constructor(props) {
        super(props)

        this.getResults = this.getResults.bind(this)
        this.reset = this.reset.bind(this)
        this.handleKeyPress = this.handleKeyPress.bind(this)
        this.startSearch = this.startSearch.bind(this)
        this.toggleVisible = this.toggleVisible.bind(this)

        this.state = { 
            results : [],
            loading: false,
            searchStarted: false,
            searched: false,
            searchTerms: '',
            visible: false
        }
    }

    getResults(e) {
        if( this.state.loading || !this.state.searchStarted ) {
            return;
        }

        const search = this.state.searchTerms

        if( search && search.length > 2 ) {
            this.setState({ loading: true, searched: true })

            let url  = search_route.rest_search_posts.replace( '%s', search )

            fetch(url)
                .then(response => { return response.json()})
                .then(
                    (results) => {
                        this.setState({results: results, loading:false})
                    }
                )
        } else {
            this.setState({results: [], searched: false })
        }
    }

    reset() {
        this.setState({results: [], searched: false, searchTerms: '', searchStarted: false })
    }

    startSearch() {
        if(this.state.searchTerms) {
            this.setState({searchStarted: true}, this.getResults)
        }
    }

    handleKeyPress(e) {
        if(this.state.searchTerms && e.key === 'Enter'){
            this.setState({searchStarted: true}, this.getResults)
        }
    }

    toggleVisible() {
        this.setState({visible: !this.state.visible})
    }

    render() {
        const { results, loading, searched, searchTerms, visible } = this.state
        const { getResults, reset, startSearch, handleKeyPress, toggleVisible } = this

        function SearchButton() {
            return (
                searched ? <button className="clear" onClick={reset}>Clear</button> : <button onClick={startSearch}>Search</button>
            )
        }

        return (
            <div className="search-form-input">
                <div className={visible ? "toggle open" : "toggle"}>
                    <button className="toggle-control" onClick={toggleVisible}></button>
                </div>

                <div className={visible ? "search-form-inner visible" : "search-form-inner"}>
                    <div className="controls">
                        <input
                            className="search-input"
                            type="text"
                            placeholder="Search"
                            value={searchTerms}
                            onKeyUp={getResults}
                            onKeyPress={handleKeyPress}
                            onChange={e => this.setState({searchTerms: e.currentTarget.value})}
                        />

                        <SearchButton />
                    </div>

                    <SearchResults
                        searched={searched}
                        loading={loading}
                        results={results}
                        searchTerms={searchTerms}
                    />
                </div>
            </div>
        )
    }
}