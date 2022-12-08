import React from 'react';
import renderHTML from 'react-render-html';

let FaqList = (props) => {
	let listEm = () => {
		let postsHtml = [];

		if(props.posts !== undefined && props.posts) {
			for (let i = 0; i < props.posts.length; i++) {
				postsHtml.push(
					<div className="faq" key={i}>
						<h4 className="cwa-section-header">{props.posts[i].title.rendered}</h4>
						<div className="cwa-section-content">
							<div class="inner">
								{renderHTML(props.posts[i].content.rendered)}
							</div>
						</div>
					</div>
				);
			}
		}

		return postsHtml;
	}

	return(
		<div id={'cwblock-'+props.type} className="cw-accordion">{listEm()}</div>
	);
}

export default FaqList;