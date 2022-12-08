import React from 'react'

export default class OfficeSearch extends React.Component {
    constructor(props) {
        super(props)

        this.searchByName = this.searchByName.bind(this)
        this.updateSelectedOffice = this.updateSelectedOffice.bind(this)
        this.updateOfficeName = this.updateOfficeName.bind(this)

        this.state = { 
            results : [],
            isLoaded: false,
            nameSearch: '',
            selectedOffice: '',
            selectedOfficeName: '',
        }
    }

    componentDidMount() {
        if(this.props.cwmbcwoffice) {
            this.setState({selectedOffice: this.props.cwmbcwoffice})
        }

        fetch(endpoints.justoffices)
            .then(res => res.json())
            .then(
                (result) => {
                    this.setState({
                        isLoaded: true,
                        results: result
                    });
                    this.updateOfficeName(this.props.cwmbcwoffice)
                },
                (error) => {
                    console.log(error);
                    this.setState({
                        isLoaded: true
                    });
                }
            )
    }

    searchByName(e){
        this.setState({nameSearch: e.currentTarget.value})
    }

    updateSelectedOffice(e) {
        let officeID = ''

        if(e.currentTarget.dataset.agentid) {
            officeID = e.currentTarget.dataset.agentid
        }
        
        if(e.currentTarget.value) {
            officeID = e.currentTarget.value
        }
        
        this.setState({selectedOffice: officeID, nameSearch: ''})

        this.updateOfficeName(officeID)
    }

    updateOfficeName(officeID) {
        const matches = this.state.results.filter((office) => {
            return office.officemlsid == officeID
        })

        if(matches.length) {
            const office = matches[0]
            this.setState({selectedOfficeName: office.name})
            
            // update page title input
            const pageTitleInput = document.querySelector('#title')
            if(pageTitleInput) {
                pageTitleInput.value = office.name
            }
        }
    }

    render() {
        const { results, isLoaded, selectedOffice, selectedOfficeName } = this.state
        const { searchByName, updateSelectedOffice } = this

        if(!isLoaded) {
            return (
                <div className="loading"><p>Building List</p><div className="animation"></div></div>
            )
        } else {
            return (
                <div className="office-search-inner">
                    <div className="inner">
                        <div className="input-item">
                            <div className="input-mother">
                                <input
                                    type="text"
                                    placeholder="Search for a Office"
                                    value={this.state.nameSearch}
                                    onChange={searchByName}
                                />

                                <ul className="search-results">
                                    {results.filter((office) => (
                                            !!this.state.nameSearch && office.name.toLowerCase().includes(this.state.nameSearch.toLowerCase())
                                        )).map((office, key) => (
                                        <li onClick={updateSelectedOffice} data-agentid={office.officemlsid} key={key}>
                                            {office.name}
                                        </li>
                                    ))}
                                </ul>
                            </div>
                        </div>
    
                        <div className="input-item">
                            <input type="hidden" name="_office_name" value={selectedOfficeName} />
                            <select
                                id="_office"
                                name="_office"
                                value={selectedOffice}
                                onChange={updateSelectedOffice}
                            >
                                <option value="">Select a Office</option>
                                {results.map((office, key) => {
                                    return(
                                        <option value={office.officemlsid} key={key}>
                                            {office.name}
                                        </option>
                                    )
                                })}
                            </select>
                        </div>
                    </div>
                </div>
            )
        }
    }
}