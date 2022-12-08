import React from 'react'

export default function SearchControls(props) {
    return(
        <div className="fiters">
            <div className="filter-mother">
                <input type="text" onChange={props.searchRealtors} value={props.realtorSearch} placeholder="Search Realtor Name" />
            </div>

            <div className="filter-mother">
                <select onChange={props.whichOffice} value={props.selectedOffce}>
                    <option value="" key={0}>Select an office</option>
                    {props.offices.filter(ofc => props.realtorSearch ? ofc.realtornames.includes(props.realtorSearch.toLowerCase()) : true).map(offce => (
                        <option value={offce.office_id} key={offce.office_id}>{offce.office_name}</option>
                    ))}
                </select>
            </div>

            <div className="filter-mother">
                <button onClick={props.resetSearch}>Reset Search</button>
            </div>
        </div>
    )
}