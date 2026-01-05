import { select } from '@wordpress/data';

/**
 * BackgroundImage
 *
 * This component is used to display a background image for a block based on its attributes.
 *
 * @param {object} props
 * @param {string} props.background_url The desired full size url.
 * @param {string} props.background_url_lazy Tiny lazy url.
 * @param {boolean} props.background_lazy Whether or not to lazy load the background image.
 * @param {string} props.background_position The background-position property.
 * @param {boolean} props.background_fixed Toggle for background-attachment: fixed.
 * @param {number} props.background_opacity The opacity value applied to the image.
 * @returns {*} React JSX
 */
export default function BackgroundImage({
  background_url,
  background_url_lazy,
  background_lazy,
  background_position = 'center',
  background_fixed = false,
  background_opacity = 70,
}) {

  if (background_url) {
    let styles = {
      backgroundImage: `url(${background_url})`,
      backgroundPosition: background_position,
      backgroundSize: 'cover',
      backgroundAttachment: background_fixed ? 'fixed' : 'scroll',
      opacity: Number(background_opacity) * 0.01,
    }

    let attributes = {
      className: 'badegg-block-background',
      style: styles,
    };

    if(background_lazy) {
      attributes['data-bg'] = background_url;
      attributes.style.backgroundImage = `url(${background_url_lazy})`;
      attributes.className += ' lazy-bg';
    }

    return (
      <div { ...attributes } />
    )
  } else {
    return;
  }

}
