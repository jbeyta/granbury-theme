import React from 'react'
import Office from './Office'

export default function Offices(props) {
    return(
        <div className="offices">
            {props.offices.filter(office => props.selectedOffce ? office.office_id == props.selectedOffce : true).filter(ofc => props.realtorSearch ? ofc.realtornames.includes(props.realtorSearch.toLowerCase()) : true).map(offce => (
                <Office {...offce} realtorSearch={props.realtorSearch} />
            ))}
        </div>
    )
}