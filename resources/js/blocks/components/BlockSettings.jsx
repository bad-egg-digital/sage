import { useSelect } from '@wordpress/data';

/**
 * BlockSettings
 *
 * Bundles the <InspectorControls> used for several blocks
 * *
 * @param {object} props
 * @param {number} props.attributes the data
 * @param {string} props.setAttributes the state
 * @returns {*} React JSX
 */

import { __ } from '@wordpress/i18n';
import { useState, useEffect } from '@wordpress/element';
import apiFetch from '@wordpress/api-fetch';

import {
	Panel,
	PanelBody,
	PanelRow,
	SelectControl,
	ToggleControl,
	RangeControl,
	ColorPalette,
	Button,
	Spinner,
} from '@wordpress/components';

import {
	InspectorControls,
  BlockControls,
  AlignmentToolbar,
	MediaUpload,
	MediaUploadCheck,
} from '@wordpress/block-editor';

export default function BlockSettings({ attributes, setAttributes }) {
	const [ configOptions, setConfigOptions ] = useState([]);
	const [ isLoading, setIsLoading ] = useState(true);

  useEffect( () => {
		let isMounted = true;

		apiFetch( { path: '/badegg/v1/blocks/config' } )
			.then( ( data ) => {
				if ( isMounted ) {
					setConfigOptions( data );
					setIsLoading( false );
				}
			} )
			.catch( () => {
				if ( isMounted ) {
					setConfigOptions( null );
					setIsLoading( false );
				}
			} );

		return () => {
			isMounted = false;
		};
	}, [] );

  if ( isLoading ) {
		return (
			<InspectorControls>
				<Panel>
					<PanelBody>
						<Spinner />
					</PanelBody>
				</Panel>
			</InspectorControls>
		);
	}

	if ( ! configOptions ) {
		return null;
	}

  const {
    alignment,
		container_width,
		padding_top,
		padding_bottom,
		background_hex,
		background_tint,
		background_image,
		background_opacity,
		background_contrast,
		background_fixed,
	} = attributes;

	return (
    <>
      <BlockControls>
        <AlignmentToolbar
          value={ alignment }
          onChange={(value) => setAttributes({alignment: value})}
        />
      </BlockControls>
      <InspectorControls>
        <Panel className="badegg-components-panel">
          <PanelBody title={ __("Spacing", "badegg") }>
            <SelectControl
              label={ __("Container Width", "badegg") }
              value={ container_width }
              options={ configOptions.container }
              onChange={ (value) => setAttributes({ container_width: value }) }
              __next40pxDefaultSize={ true }
              __nextHasNoMarginBottom={ true }
            />
            <ToggleControl
              label={ __('Top padding', 'badegg') }
              checked={ padding_top }
              onChange={(value) => setAttributes({ padding_top: value }) }
              __nextHasNoMarginBottom
            />
            <ToggleControl
              label={ __('Bottom padding', 'badegg') }
              checked={ padding_bottom }
              onChange={(value) => setAttributes({ padding_bottom: value }) }
              __nextHasNoMarginBottom
            />
          </PanelBody>
          <PanelBody title={ __("Background", "badegg") }>
            <p style={{ textTransform: 'uppercase', fontSize: '11px' }} className="components-truncate components-text components-input-control__label">
              { __('Colour', 'badegg') }
            </p>
            <ColorPalette
              colors={ configOptions.colours }
              value={ background_hex }
              clearable={ false }
              disableCustomColors={ true }
              style={{ marginBottom: '16px' }}
              onChange={ ( value ) => {
                let slug, hex, selected = '';

                if(value) {
                  selected = configOptions.colours.find(
                    ( c ) => c.color === value
                  );

                  hex = value;
                }

                if(selected) {
                  slug = selected.slug;
                }

                setAttributes( {
                  background_colour: slug,
                  background_hex: hex,
                });

              } }
            />

            { 'background_colour' in attributes && attributes.background_colour && ![0, '0', 'white', 'black'].includes(attributes.background_colour) ? (
              <SelectControl
                label={ __("Background Tint", "badegg") }
                value={ background_tint }
                options={ configOptions.tints }
                onChange={ (value) => setAttributes({ background_tint: value }) }
                __next40pxDefaultSize={ true }
                __nextHasNoMarginBottom={ true }
              />
            ) : null }

            { background_image != 0 && (
              <>
                <ToggleControl
                  label={ __('Text Contrast', 'badegg') }
                  checked={ background_contrast }
                  onChange={(value) => setAttributes({ background_contrast: value }) }
                  __nextHasNoMarginBottom
                />
                <ToggleControl
                  label={ __('Fixed Position', 'badegg') }
                  checked={ background_fixed }
                  onChange={(value) => setAttributes({ background_fixed: value }) }
                  __nextHasNoMarginBottom
                />
                <RangeControl
                  __next40pxDefaultSize
                  __nextHasNoMarginBottom
                  label={ __("Opacity", "badegg") }
                  value={ background_opacity }
                  onChange={ ( value ) => setAttributes({ background_opacity: value }) }
                  min={ 5 }
                  max={ 100 }
                />
              </>
            )}

            <PanelRow>
              <MediaUploadCheck>
                <MediaUpload
                  onSelect={ (media) => {
                    setAttributes({
                      background_image: media.id,
                      background_url: media.url,
                    });
                  }}
                  allowedTypes={ ['image'] }
                  value={ background_image }
                  render={ ({ open }) => (
                    <Button
                      onClick={ open }
                      variant="primary"
                    >
                      { background_image ?  __("Replace image", "badegg") :  __("Choose image", "badegg") }
                    </Button>
                  )}
                />
              </MediaUploadCheck>

              { background_image != 0 && (
                <Button
                  onClick={ () => setAttributes({ background_image: 0 }) }
                  isDestructive
                  variant="secondary"
                >
                  { __("Remove image", "badegg") }
                </Button>
              )}
            </PanelRow>

          </PanelBody>
        </Panel>
      </InspectorControls>
    </>
	);
}
