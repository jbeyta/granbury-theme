import React from 'react';
import renderHTML from 'react-render-html';

let AlertList = (props) => {
	let listEm = () => {
		let postsHtml = [];

		if(props.posts !== undefined && props.posts) {
			for (let i = 0; i < props.posts.length; i++) {
				postsHtml.push(
					<div className="alert" key={i}>
						<div className="row">
							<div className="s12">
								<div className="inner">
									<h3 className="alert-title">{props.posts[i].title.rendered}</h3>
									<p className="alert-text">{renderHTML(props.posts[i].content.rendered)}</p>

									<span className="alert-close"><i className="fas fa-times"></i></span>
								</div>
							</div>
						</div>

						<span className="alert-open"><i className="fas fa-exclamation"></i></span>
					</div>
				);
			}
		}

		return postsHtml;
	}

	return(
		<div id={'cwblock-'+props.type} className="alerts-mother">{listEm()}</div>
	);
}

export default AlertList;