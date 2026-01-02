import { useSelect } from '@wordpress/data';

/**
 * BlockSettings
 *
 * Bundles the <InspectorControls> used for several blocks
 * *
 * @param {object} props
 * @param {number} props.imageId The ID of the image to display.
 * @param {string} props.size The size of the image to display. Defaults to 'full'.
 * @returns {*} React JSX
 */
export default function BlockSettings({ imageId, size = 'full' }) {

	const { image } = useSelect((select) => ({
		image: select('core').getEntityRecord('postType', 'attachment', imageId),
	}));

	const imageAttributes = () =>{
		let attributes = {
			src: image.source_url,
			alt: image.alt_text,
			className: `attachment-${size} size-${size}`,
			width: image.media_details.width,
			height: image.media_details.height,
		};
		if (image.media_details && image.media_details.sizes && image.media_details.sizes[size]) {
			attributes.src = image.media_details.sizes[size].source_url;
			attributes.width = image.media_details.sizes[size].width;
			attributes.height = image.media_details.sizes[size].height;
		}

		return attributes;
	};

	return (
		<>
			{image && (
				<img {...imageAttributes()} />
			)}
		</>
	)
}
