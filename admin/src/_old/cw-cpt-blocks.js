import React from 'react';
import moment from 'moment';

if(wp.element && wp.editor) {
	const { __ } = wp.i18n; // Import __() from wp.i18n
	const { registerBlockType } = wp.blocks; // Import registerBlockType() from wp.blocks

	let el = wp.element.createElement,
		Fragment = wp.element.Fragment,
		RichText = wp.editor.RichText;

	registerBlockType( 'cw-cpt-selector-block/cpt-selector', {
		title: 'Content Types',

		icon: 'list-view',

		category: 'embed',

		attributes: {
			type: {
				type: 'string',
				default: '',
			},
			per_page: {
				type: 'string',
				default: '',
			},
			orderby: {
				type: 'string',
				default: 'title',
			},
			order: {
				type: 'string',
				default: 'asc',
			},
			cats: {
				type: 'array',
				default: [],
			},
			cat: {
				type: 'string',
				default: '',
			},
			loading: {
				type: 'number',
				default: 0
			}
		},

		edit: props => {
			let { attributes: { type, per_page, orderby, order, cats, cat, loading }, setAttributes } = props;

			// when a post type is selected, query for the default taxonomy and get the terms.
			let setType = (e) => {
				let type = e.target.querySelector( 'option:checked' ).value;

				setAttributes({ type: type, cat: '', loading: 1 });
				e.preventDefault();

				let url = siteurl+'/wp-json/wp/v2/'+type+'_categories';

				fetch(url)
				.then(response => response.json())
				.then(data => {
					// console.log(url);
					// console.log(data) // Prints result from `response.json()` in getRequest

					if(data.code != 'rest_taxonomy_invalid' && data.code != 'rest_no_route') {
						setAttributes({ cats: data, loading: 0 });
					} else {
						setAttributes({ cats: [], loading: 0 });
					}

				})
				.catch(error => {
					setAttributes({ cats: [], loading: 0 });
					console.error(error)
				});
			}

			// set attribs for query modifiers and update the query with each change
			let setCat = (e) => {
				let cat = e.target.querySelector( 'option:checked' ).value;
				setAttributes({ cat: cat });
				e.preventDefault();
			}

			let setCount = (e) => {
				let per_page = parseInt( e.target.value );
				setAttributes({ per_page: per_page });
				e.preventDefault();
			}

			let setOrder = (e) => {
				let orderby = e.target.querySelector( 'option:checked' ).value;
				setAttributes({ orderby: orderby });
				e.preventDefault();
			}

			let setSort = (e) => {
				let order = e.target.querySelector( 'option:checked' ).value;
				setAttributes({ order: order });
				e.preventDefault();
			}

			// create the dropdown for the post type select
			let createOptions = () => {
				let options = [];
				
				if(cw_cpts.length) {
					for (let i = 0; i < cw_cpts.length; i++) {
						options.push(
							<option value={cw_cpts[i].id} key={i}>{cw_cpts[i].name}</option>
						);
					}
				}

				return options;
			}

			// build category select
			let createCatOptions = () => {
				let options = [];
				
				for (let i = 0; i < cats.length; i++) {
					options.push(
						<option value={cats[i].id} key={i}>{cats[i].name}</option>
					);
				}

				return options;
			}

			let catsHtml = '';
			if(cats.length) {
				catsHtml = <div className="field-mother row ai-center">
					<div className="s12 m6">
						<label>Category</label>

						<select name="type" value={cat} onChange={setCat}>
							<option value="">All Categories</option>
							{createCatOptions()}
						</select>
					</div>
				</div>
			}

			let loader = '';
			if(loading) {
				loader = <div className="loader"><div className="inner">Loading&hellip;</div></div>;
			}

			return(
				<div className={props.className}>
					{loader}
					<div className="header-mother row">
						<div className="s12">
							<h4 className="header">Content Type: {type}</h4>
						</div>
					</div>

					<form>
						<div className="field-mother row ai-center">
							<div className="s12 m6">
								<select name="type" value={type} onChange={setType}>
									{createOptions()}
								</select>
							</div>

							<div className="s12 m6">
								<label>Number to show</label>
								<input type="number" name="count" min="1" onChange={setCount} value={per_page} placeholder="All" />
								<p><small>Leave empty to show all.</small></p>
							</div>
						</div>

						<div className="field-mother row ai-center">
							<div className="s12 m6">
								<label>Order</label>

								<select name="orderby" value={orderby} onChange={setOrder}>
									<option value="title">Alphabetical (by title)</option>
									<option value="date">Date</option>
									<option value="menu_order">Manual</option>
								</select>
							</div>

							<div className="s12 m6">
								<label>Sort</label>

								<select name="orderby" value={order} onChange={setSort}>
									<option value="asc">Ascending</option>
									<option value="desc">Descending</option>
								</select>
							</div>
						</div>

						{catsHtml}
					</form>
				</div>
			);
		},

		save: ( props ) => {
			const { attributes: { type, per_page, orderby, order, cat } } = props;

			if(type === undefined || type == '') {
				return;
			}

			return(
				<div
					className={'cw-cpt-block cwblock-type-'+type}
					data-type={type}
					data-per_page={per_page}
					data-orderby={orderby}
					data-order={order}
					data-cat={cat}
				></div>
			);

		},
	} );	
}