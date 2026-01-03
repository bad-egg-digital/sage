import { useSelect } from '@wordpress/data';

/**
 * BackgroundImage
 *
 * This component is used to display a background image for a block based on its attributes.
 *
 * @param {object} props
 * @param {string} props.background_image The url of the background image.
 * @param {string} props.background_position The background-position property.
 * @param {boolean} props.background_fixed Toggle for background-attachment: fixed.
 * @param {number} props.background_opacity The opacity value applied to the image.
 * @returns {*} React JSX
 */
export default function BackgroundImage({ background_url, background_position = 'center', background_fixed = false, background_opacity = 70 }) {

	return (
		<>
			{background_url && (
				<div
          className="badegg-block-background"
          style={{
            backgroundImage: `url(${background_url})`,
            backgroundPosition: background_position,
            backgroundSize: 'cover',
            backgroundAttachment: background_fixed ? 'fixed' : 'scroll',
            opacity: Number(background_opacity) * 0.01,
          }}
        />
			)}
		</>
	)
}
