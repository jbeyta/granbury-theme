import React from 'react'

export default class RealtorSearch extends React.Component {
    constructor(props) {
        super(props)

        this.searchByName = this.searchByName.bind(this)
        this.updateSelectedRealtor = this.updateSelectedRealtor.bind(this)
        this.updateRealtorName = this.updateRealtorName.bind(this)

        this.state = { 
            results : [],
            isLoaded: false,
            nameSearch: '',
            selectedRealtor: '',
        }
    }

    componentDidMount() {
        if(this.props.cwmbcwrealtor) {
            this.setState({selectedRealtor: this.props.cwmbcwrealtor})
        }

        fetch(endpoints.justrealtors)
            .then(res => res.json())
            .then(
                (result) => {
                    this.setState({
                        isLoaded: true,
                        results: result
                    });
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

    updateSelectedRealtor(e) {
        let agentSlug = ''

        if(e.currentTarget.dataset.agentid) {
            agentSlug = e.currentTarget.dataset.agentid
        }
        
        if(e.currentTarget.value) {
            agentSlug = e.currentTarget.value
        }
        
        this.setState({selectedRealtor: agentSlug, nameSearch: ''})

        this.updateRealtorName(agentSlug)
    }

    updateRealtorName(agentSlug) {
        const matches = this.state.results.filter((agent) => {
            return agent.slug == agentSlug
        })

        if(matches.length) {
            const agent = matches[0]
    
            // update page title input
            const pageTitleInput = document.querySelector('#title')
            if(pageTitleInput) {
                pageTitleInput.value = agent.first_name + ' ' + agent.last_name + ' - ' + agent.office_name
            }
        }
    }

    render() {
        const { results, isLoaded, nameSearch, selectedRealtor } = this.state
        const { searchByName, updateSelectedRealtor } = this

        if(!isLoaded) {
            return (
                <div className="loading"><p>Building List</p><div className="animation"></div></div>
                )
            } else {
                return (
                <div className="realtor-search-inner">
                    <div className="inner">
                        <div className="input-item">
                            <div className="input-mother">
                                <input
                                    type="text"
                                    placeholder="Search for a Realtor"
                                    value={this.state.nameSearch}
                                    onChange={searchByName}
                                />

                                <ul className="search-results">
                                    {results.filter((realtor) => (
                                            !!this.state.nameSearch && (
                                                realtor.first_name.toLowerCase().includes(this.state.nameSearch.toLowerCase())
                                                ||
                                                realtor.last_name.toLowerCase().includes(this.state.nameSearch.toLowerCase())
                                            )
                                        )).map((realtor, key) => (
                                        <li onClick={updateSelectedRealtor} data-agentid={realtor.slug} key={key}>
                                            {realtor.first_name} {realtor.last_name} - {realtor.office_name}
                                        </li>
                                    ))}
                                </ul>
                            </div>
                        </div>
    
                        <div className="input-item">
                            <select
                                id="_realtor"
                                name="_realtor"
                                value={selectedRealtor}
                                onChange={updateSelectedRealtor}
                            >
                                <option value="">Select a Realtor</option>
                                {results.map((realtor, key) => {
                                    return(
                                        <option value={realtor.slug} key={key}>
                                            {realtor.first_name} {realtor.last_name} - {realtor.office_name}
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