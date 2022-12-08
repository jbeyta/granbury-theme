import React from 'react'
import Realtors from './Realtors'
import { Phone, Email, Website, SocialLink } from './contactInfo'

export default function Office(props) {
    return (
        <div className="office">
            <div className="office-info">
                
                {props.photo && <img src={props.photo} alt="" />}

                <h4 className="office-name">{props.office_name}</h4>
                <p style={{display: 'none'}}><small>{props.member_id}</small></p>
                <p className="address">
                    <span className="line-1">{props.address1}</span>
                    <span className="line-2">{props.address2}</span>
                    <span className="line-3">{props.city}, {props.state} {props.zip}</span>
                </p>

                <Phone phone={props.phone_1_number} />
                <Email email={props.email} />
                <Website website={props.website} />

                <div className="social-links">
                    <SocialLink url={props.facebook} />
                    <SocialLink url={props.instagram} />
                    <SocialLink url={props.linkedin} />
                    <SocialLink url={props.twitter} />
                </div>
            </div>

            <Realtors
                realtors={props.realtors}
                realtorSearch={props.realtorSearch}
            />
        </div>
    )
}