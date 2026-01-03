// block.json's editorScript, loaded only in the block editor

import { __ } from '@wordpress/i18n';
import { registerBlockType } from '@wordpress/blocks';
import { useSelect } from '@wordpress/data';

import {
  useBlockProps,
  InnerBlocks,
  InspectorControls,
  BlockControls,
  AlignmentToolbar,
  MediaUpload,
  MediaUploadCheck,
} from '@wordpress/block-editor';

import {
  Panel,
  PanelBody,
  PanelRow,
  SelectControl,
  ToggleControl,
  RangeControl,
  ColorPalette,
  Button,
} from '@wordpress/components';

// import { Image } from '@10up/block-components';

import { useState, useEffect } from '@wordpress/element';
import metadata from './block.json';
import allowedBlocks from '../../../json/core-block-whitelist.json';
import { containerClassNames, sectionClassNames } from '../../../js/blocks/lib/classNames';
import AttachmentImage from '../../../js/blocks/components/AttachmentImage';
import BackgroundImage from '../../../js/blocks/components/BackgroundImage';

import apiFetch from '@wordpress/api-fetch';

registerBlockType(metadata.name, {
  edit({ attributes, setAttributes }) {
    const blockProps = useBlockProps();
    const [ isLoading, setIsLoading ] = useState( true );

    const {
      container_width,
      alignment,
      padding_top,
      padding_bottom,
      background_colour,
      background_hex,
      background_tint,
      background_image,
      background_url,
      background_position,
      background_opacity,
      background_contrast,
      background_fixed,
    } = attributes;

    const [
      configOptions, setConfigOptions,
    ] = useState( [] );

    useEffect( () => {
      apiFetch( { path: '/badegg/v1/blocks/config' } )
        .then( ( data ) => {
          setConfigOptions( data );
          setIsLoading( false );
        } )
        .catch( () => {
          setConfigOptions( [] );
          setIsLoading( false );
        } );
    }, [] );

    blockProps.className = sectionClassNames(
      attributes,
      blockProps.className,
      [
        'wysiwyg'
      ]).join(' ');

    // console.log(attributes);

    return (
      <div { ...blockProps }>
        <BlockControls>
          <AlignmentToolbar
            value={ alignment }
            onChange={(value) => setAttributes({alignment: value})}
          />
        </BlockControls>
        <InspectorControls>
          <Panel className="badegg-components-panel">
            <PanelBody title={ __("Settings", "badegg") }>
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
                  {/* <AttachmentImage
                    imageId={ background_image }
                    size="thumbnail"
                  /> */}
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
        <div className={ containerClassNames(attributes).join(' ') }>
          <InnerBlocks
            allowedBlocks={ allowedBlocks }
            defaultBlock={
              {
                name: "core/paragraph",
                attributes: {
                  placeholder: "start typing",
                }
              }
            }
          />
        </div>

        <BackgroundImage { ...attributes } />

      </div>
    );
  },
  save({ attributes }) {
    return (
      <div { ...useBlockProps.save() }>
        <div className={ containerClassNames(attributes).join(' ') }>
          <InnerBlocks.Content />
        </div>
      </div>
    )
  }
});
