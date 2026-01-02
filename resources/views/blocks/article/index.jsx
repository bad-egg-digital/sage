// block.json's editorScript, loaded only in the block editor

import { __ } from '@wordpress/i18n';
import { registerBlockType } from '@wordpress/blocks';

import {
  useBlockProps,
  InnerBlocks,
  InspectorControls,
  BlockControls,
  AlignmentToolbar,
} from '@wordpress/block-editor';

import {
  Panel,
  PanelBody,
  PanelRow,
  SelectControl,
  ToggleControl,
  ColorIndicator,
  ColorPalette,
} from '@wordpress/components';

import { useState, useEffect } from '@wordpress/element';
import apiFetch from '@wordpress/api-fetch';
import metadata from './block.json';
import allowedBlocks from '../../../json/core-block-whitelist.json';
import { containerClassNames, sectionClassNames } from '../../../js/lib/blocks/classNames';

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
          <Panel>
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
                label={ __('Top Padding', 'badegg') }
                checked={ padding_top }
                onChange={(value) => setAttributes({ padding_top: value }) }
                __nextHasNoMarginBottom
              />
              <ToggleControl
                label={ __('Bottom Padding', 'badegg') }
                checked={ padding_bottom }
                onChange={(value) => setAttributes({ padding_bottom: value }) }
                __nextHasNoMarginBottom
              />
            </PanelBody>
            <PanelBody title={ __("Background Colour", "badegg") }>
              <ColorPalette
                colors={ configOptions.colours }
                value={ background_hex }
                disableCustomColors={ true }
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

              { 'background_colour' in attributes && attributes.background_colour ? (
                <SelectControl
                  label={ __("Tint", "badegg") }
                  value={ background_tint }
                  options={ configOptions.tints }
                  onChange={ (value) => setAttributes({ background_tint: value }) }
                  __next40pxDefaultSize={ true }
                  __nextHasNoMarginBottom={ true }
                />
              ) : null }

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
      </div>
    );
  },
  save({ attributes }) {
    return (
      <div { ...useBlockProps.save() }>
        <div className={ containerClassNames(attributes).join() }>
          <InnerBlocks.Content />
        </div>
      </div>
    )
  }
});
