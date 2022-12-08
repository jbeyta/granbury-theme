import React from 'react';
import renderHTML from 'react-render-html';

let LocList = (props) => {
	let listEm = () => {
		let postsHtml = [];
		let mapStyle = {
			height: 400,
			width: 100+'%'
		};

		let buildAddress = (street, street2, city, state, zip) => {
			let html = [];

			if(street) {
				html.push(<span className="street">{street}</span>);
			}
			if(street && street2) {
				html.push(<br />);
			}
			if(street2) {
				html.push(<span className="street2">{street2}</span>);
			}
			if((street && city) || (street2 && city)) {
				html.push(<br />);
			}
			if(city) {
				html.push(<span className="city">{city}</span>);
			}
			if(city && state) {
				html.push(<span>, </span>)
			}
			if(state) {
				html.push(<span className="state">{state}</span>);
			}
			if(zip) {
				html.push(<span className="zip"> {zip}</span>);
			}

			return html;
		}

		let buildPhone = (phone, ext) => {
			let html = [];
			if(phone) {
				html.push(<p className="phone"><b>Phone:</b> <a href={'tel:'+phone}>{phone}</a></p>);
			}

			if(ext) {
				html.push(<p><small>ext: {ext}</small></p>);
			}

			return html;
		}
		let buildPhone2 = (phone, ext) => {
			let html = [];
			if(phone) {
				html.push(<p className="phone"><b>Phone:</b> <a href={'tel:'+phone}>{phone}</a></p>);
			}

			if(ext) {
				html.push(<p><small>ext: {ext}</small></p>);
			}

			return html;
		}
		let buildFax = (fax) => {
			let html = [];
			if(fax) {
				html.push(<p className="fax"><b>Fax:</b> {fax}</p>);
			}

			return html;
		}
		let buildEmail = (email) => {
			let html = [];
			if(email) {
				html.push(<p className="email"><a href={'mailto:'+email}>{email}</a></p>);
			}

			return html;
		}
		let buildHours = (hours) => {
			let html = [];
			if(hours) {
				html.push(<p className="hours">{hours}</p>);
			}

			return html;
		}

		if(props.posts !== undefined && props.posts) {
			for (let i = 0; i < props.posts.length; i++) {
				postsHtml.push(
					<div className="location-mother" key={i + 1}>
						<div class="row ai-center wrap">
							<div class="s12 m6 info">
								<h4 class="loc-title">{props.posts[i].title.rendered}</h4>
								{buildAddress(
									props.posts[i].post_meta.address1,
									props.posts[i].post_meta.address2,
									props.posts[i].post_meta.city,
									props.posts[i].post_meta.state,
									props.posts[i].post_meta.zip,
								)}
								{buildPhone(props.posts[i].post_meta.phone, props.posts[i].post_meta.ext)}
								{buildPhone2(props.posts[i].post_meta.phone2, props.posts[i].post_meta.ext2)}
								{buildFax(props.posts[i].post_meta.fax)}
								{buildEmail(props.posts[i].post_meta.email)}
								{buildHours(props.posts[i].post_meta.hours)}
							</div>

							<div class="s12 m6">
								<div
									id={'loc_'+i}
									className="cw-map-canvas"
									style={mapStyle}
									data-address={props.posts[i].post_meta.address_string}
								></div>
							</div>
						</div>

					</div>
				);
			}
		}

		return postsHtml;
	}

	return(
		<div id={'cwblock-'+props.type} className="locations">{listEm()}</div>
	);
}

export default LocList;