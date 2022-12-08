import React from 'react'
import Realtor from './Realtor'

export default function Realtors(props) {
    return (
        props.realtors.length ? <div className="realtors">
            {props.realtors.filter(
                rlt => props.realtorSearch ? (
                    rlt.first_name.toLowerCase().includes(props.realtorSearch.toLowerCase())
                    ||
                    rlt.last_name.toLowerCase().includes(props.realtorSearch.toLowerCase())
                ) : true ).map(realtr => (
                    <Realtor {...realtr} />
                ))
            }
        </div> : ''
    )
}