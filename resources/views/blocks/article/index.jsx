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
} from '@wordpress/components';
import { useState, useEffect } from '@wordpress/element';
import apiFetch from '@wordpress/api-fetch';
import metadata from './block.json';
import allowedBlocks from '../../../json/core-block-whitelist.json';

registerBlockType(metadata.name, {
  edit({ attributes, setAttributes }) {
    const blockProps = useBlockProps();
    const [ isLoading, setIsLoading ] = useState( true );

    const {
      container_width,
      alignment,
      padding_top,
      padding_bottom,
    } = attributes;

    const [
      containerWidthOptions, setContainerWidthOptions,
    ] = useState( [] );

    useEffect( () => {
        apiFetch( { path: '/badegg/v1/blocks/container_width' } )
            .then( ( data ) => {
                setContainerWidthOptions( data );
                setIsLoading( false );
            } )
            .catch( () => {
                setContainerWidthOptions( [] );
                setIsLoading( false );
            } );
    }, [] );

    console.log(attributes);

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
                options={ containerWidthOptions }
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
          </Panel>
        </InspectorControls>
        <div className={`container container-${ attributes.container_width } align-${ attributes.alignment }`}>
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
        <div className={`container container-${attributes.container_width} align-${ attributes.alignment }`}>
          <InnerBlocks.Content />
        </div>
      </div>
    )
  }
});
