import React from 'react'
import { Phone, Fax, Email, Website } from './contactInfo'

export default function Realtor(props) {
    const showHideBio = function(e){
        const self = e.currentTarget
        const bioText = self.querySelector('.bio-text')
        const bioInner = self.querySelector('.inner')
        const label = self.querySelector('.label')
        const H = bioInner.offsetHeight

        if(bioText.classList.contains('open')) {
            bioText.classList.remove('open')
            bioText.style.height = 0 + 'px'
            label.innerHTML = 'Read Bio'
        } else {
            bioText.classList.add('open')
            bioText.style.height = H + 'px'
            label.innerHTML = 'Hide Bio'
        }
    }

    return(
        <div className="realtor">
            {props.photo && <div className="img-mother"><img src={props.photo} alt="" /></div>}

            <div className="realtor-info">
                <div className="name-title">
                    <h5 className="realtor-name">{props.first_name} {props.last_name}</h5>
                    {props.title && <h6 class="title">{props.title}</h6>}
                </div>

                <Phone phone={props.phone_1_number} label="Cell" />
                <Phone phone={props.phone_2_number} label="Work" />
                <Phone phone={props.phone_3_number} label="Office" />
                <Fax fax={props.fax} />
                <Email email={props.email} />
                <Website website={props.website} />

                {props.bio && <div
                    className="bio"
                    onClick={showHideBio}
                    style={{
                        position: 'relative',
                        overflow: 'hidden',
                        cursor: 'pointer',
                        marginTop: 10 + 'px'
                    }}
                >
                    <p><b className="label">Read Bio</b></p>
                    <div
                        className="bio-text"
                        style={{
                            height: 0 + 'px',
                            '-webkit-transition': 'height .3s',
                            '-o-transition': 'height .3s',
                            transition: 'height .3s',
                        }}
                    ><div className="inner">{props.bio}</div></div>
                </div>}
            </div>
        </div>
    )
}
