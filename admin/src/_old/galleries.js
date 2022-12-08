import React from 'react';
import renderHTML from 'react-render-html';

let GalleryList = (props) => {
	let listEm = () => {
		let postsHtml = [];

		if(props.posts !== undefined && props.posts) {
			for (let i = 0; i < props.posts.length; i++) {
				postsHtml.push(
					<div class="gal s6 m4 l3" key={i}>
						<h3 className="gal-title"><a href={props.posts[i].link}>{props.posts[i].title.rendered}</a></h3>
						<a href={props.posts[i].link}>
							{renderHTML(props.posts[i].post_meta.thumbs[0])}
						</a>
					</div>
				);
			}
		}

		return postsHtml;
	}

	return(
		<div id={'cwblock-'+props.type} className="gal-grid row">{listEm()}</div>
	);
}

export default GalleryList;