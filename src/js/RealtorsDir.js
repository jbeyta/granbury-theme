import React from 'react'
import SearchControls from './components/SearchControls';
import Offices from './components/Offices'

class App extends React.Component {
    constructor(props) {
        super(props);

        this.whichOffice = this.whichOffice.bind(this)
        this.searchRealtors = this.searchRealtors.bind(this)
        this.resetSearch = this.resetSearch.bind(this)

        this.state = {
            error: null,
            isLoaded: false,
            offices: [],
            selectedOffce: '',
            realtorSearch: '' 
        };
    }

    componentDidMount() {
        fetch(endpoints.realtors)
            .then(res => res.json())
            .then(
                (result) => {
                    this.setState({
                        isLoaded: true,
                        offices: result
                    });
                },
                (error) => {
                    this.setState({
                        isLoaded: true,
                        error: error
                    });
                }
            )
    }
    
    whichOffice(e) {
        this.setState({selectedOffce: e.target.value})
    }

    searchRealtors(e) {
        this.setState({realtorSearch: e.target.value})
    }

    resetSearch() {
        this.setState({
            selectedOffce: '',
            realtorSearch: '',
        })
    }

    render() {
        const { error, isLoaded, offices, selectedOffce, realtorSearch } = this.state;
        const { searchRealtors,  resetSearch, whichOffice } = this

        if (error) {
            return <div>Error: {error.message}</div>;
        } else if (!isLoaded) {
            return <div>Building Directory</div>;
        } else {
            return (
                <div className="realtors-main">
                    <SearchControls
                        realtorSearch={realtorSearch}
                        offices={offices}
                        searchRealtors={searchRealtors}
                        whichOffice={whichOffice}
                        resetSearch={resetSearch}
                    />

                    <Offices
                        offices={offices}
                        selectedOffce={selectedOffce}
                        realtorSearch={realtorSearch}
                    />
                </div>
            );
        }
    }
}

export default App