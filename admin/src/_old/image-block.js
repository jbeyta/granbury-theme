/* global wp: false, */

import React from 'react';

// if (wp.element && wp.editor) {
const { __ } = wp.i18n; // Import __() from wp.i18n
const {
	registerBlockType,
} = wp.blocks;

const {
	useBlockProps,
	MediaUploadCheck,
	InspectorControls,
	MediaUpload,
} = wp.blockEditor;

const {
	Button,
	PanelBody,
	PanelRow,
	SelectControl,
	TextControl,
	ToggleControl,
} = wp.components;

const { serverSideRender: ServerSideRender } = wp;

const el = wp.element.createElement;

const { useSelect } = wp.data;

const icon = el('svg', {
	xmlns: 'http://www.w3.org/2000/svg',
	viewBox: '0 0 24 24',
},
	el('path', {
		'd': 'M7.74,7.74V24H24V7.74Zm13,8-4.91,4.91-2.79-2.82L9.29,21.62V9.29H22.45v8.13Zm-8.84-5.22A1.49,1.49,0,1,1,10.44,12,1.49,1.49,0,0,1,11.93,10.52ZM1.55,22.45V1.55h20.9v1.8H24V0H0V24H3.35V22.45Zm3.87,0v-17h17V7.23H24V3.87H3.87V24H7.23V22.45Z',
	})
);

registerBlockType('cw-blocks/responsive-image', {
	title: 'Responsive Image',
	icon: icon,
	category: 'embed',
	attributes: {
		imgW: {
			type: 'number',
			default: 1600,
		},
		imgH: {
			type: 'number',
			default: 1200,
		},
		imgWMed: {
			type: 'number',
			default: 800,
		},
		imgHMed: {
			type: 'number',
			default: 600,
		},
		imgWSmall: {
			type: 'number',
			default: 400,
		},
		imgHSmall: {
			type: 'number',
			default: 300,
		},
		crop: {
			type: 'boolean',
			default: false,
		},
		linkURL: {
			type: 'string',
			default: ''
		},
		targetBlank: {
			type: 'boolean',
			default: false
		},
		// pos: {
		// 	type: 'string',
		// 	default: ''
		// },
		imgID: {
			type: 'number',
			default: 0
		}
	},

	edit: (props) => {
		const { className, setAttributes, attributes } = props;
		const blockProps = useBlockProps.save();

		let imgDataObj = useSelect(select => {
			const { getEntityRecord } = select('core');
			return attributes.imgID && getEntityRecord('root', 'media', attributes.imgID);
		}, [attributes.imgID]);

		const setImgData = function (media) {
			// setAttributes({ imgDataObj: imgDataObj });
			setAttributes({ imgID: media.id });
		}

		const resetImgData = function () {
			// setAttributes({ imgDataObj: {} });
			setAttributes({ imgID: 0 });
		}

		const addImage = function () {
			return <div class="cwaddimage"><MediaUpload
				className="cw-resp-image wp-admin-cw-resp-image"
				allowedTypes={['image']}
				multiple={false}
				value={imgDataObj ? imgDataObj.id : ''}
				onSelect={setImgData}
				render={({ open }) => (
					imgDataObj ?
						<Button onClick={resetImgData} className="button">Remove Image</Button> :
						<Button onClick={open} className="button">Select/Upload Image</Button>
				)}
			/></div>
		};

		return [
			<InspectorControls key="cwkey-1">
				<PanelBody title="Image" initialOpen={true}>
					<MediaUploadCheck>
						<MediaUpload
							className="cw-resp-image wp-admin-cw-resp-image"
							allowedTypes={['image']}
							multiple={false}
							value={imgDataObj ? imgDataObj.id : ''}
							onSelect={setImgData}
							render={({ open }) => (
								imgDataObj ?
									<Button onClick={resetImgData} className="button">Remove Image</Button> :
									<Button onClick={open} className="button">Select/Upload Image</Button>
							)}
						/>
					</MediaUploadCheck>
				</PanelBody>

				<PanelBody title="URL" initialOpen={false}>
					<TextControl
						label="URL"
						value={props.attributes.linkURL}
						onChange={(linkURL) => setAttributes({ linkURL: linkURL })}
						type="text"
					/>
					<ToggleControl
						label="Open link in new tab"
						checked={props.attributes.targetBlank}
						onChange={(targetBlank) => setAttributes({ targetBlank: targetBlank })}
					/>
				</PanelBody>

				<PanelBody title="Sizes" initialOpen={true}>
					<PanelRow>
						<p>Both width and height are required to create a cropped image.</p>
					</PanelRow>

					<TextControl
						label="Small Width (phones)"
						value={props.attributes.imgWSmall}
						onChange={(imgWSmall) => setAttributes({ imgWSmall: parseInt(imgWSmall) })}
						type="number"
					/>
					<TextControl
						label="Small Height (phones)"
						value={props.attributes.imgHSmall}
						onChange={(imgHSmall) => setAttributes({ imgHSmall: parseInt(imgHSmall) })}
						type="number"
					/>

					<TextControl
						label="Medium Width (tablets)"
						value={props.attributes.imgWMed}
						onChange={(imgWMed) => setAttributes({ imgWMed: parseInt(imgWMed) })}
						type="number"
					/>
					<TextControl
						label="Medium Height (tablets)"
						value={props.attributes.imgHMed}
						onChange={(imgHMed) => setAttributes({ imgHMed: parseInt(imgHMed) })}
						type="number"
					/>

					<TextControl
						label="Large Width (desktop)"
						value={props.attributes.imgW}
						onChange={(imgW) => setAttributes({ imgW: parseInt(imgW) })}
						type="number"
					/>
					<TextControl
						label="Large Height (desktop)"
						value={props.attributes.imgH}
						onChange={(imgH) => setAttributes({ imgH: parseInt(imgH) })}
						type="number"
					/>
				</PanelBody>

				<PanelBody title="Crop" initialOpen={false}>
					<ToggleControl
						label="Crop"
						checked={props.attributes.crop}
						onChange={(crop) => setAttributes({ crop: crop })}
					/>
					{/* <SelectControl
							label="Position"
							value={props.attributes.pos}
							onChange={(pos) => setAttributes({ pos: pos })}
							options={[
								{ label: 'Left', value: 'left' },
								{ label: 'Center', value: 'center' },
								{ label: 'Right', value: 'right' },
							]}
						/> */}
				</PanelBody>
			</InspectorControls>,
			<ServerSideRender
				httpMethod="POST"
				block="cw-blocks/responsive-image"
				attributes={{
					imgW: attributes.imgW ? attributes.imgW : 0,
					imgH: attributes.imgH ? attributes.imgH : 0,
					imgWMed: attributes.imgWMed ? attributes.imgWMed : 0,
					imgHMed: attributes.imgHMed ? attributes.imgHMed : 0,
					imgWSmall: attributes.imgWSmall ? attributes.imgWSmall : 0,
					imgHSmall: attributes.imgHSmall ? attributes.imgHSmall : 0,
					crop: attributes.crop,
					loading: attributes.loading,
					linkURL: attributes.linkURL,
					targetBlank: attributes.targetBlank,
					// pos: attributes.pos,
					imgID: attributes.imgID,
				}}
				EmptyResponsePlaceholder={addImage}
			/>
		];
	},
	save: () => {
		return null;
	},
});
// }