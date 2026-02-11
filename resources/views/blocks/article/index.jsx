// block.json's editorScript, loaded only in the block editor

import metadata from './block.json';
import { __ } from '@wordpress/i18n';
import { registerBlockType } from '@wordpress/blocks';

import {
  useBlockProps,
  InnerBlocks,
} from '@wordpress/block-editor';

import allowedBlocks from '../../../json/block-core-whitelist.json';
import { containerClassNames, sectionClassNames } from '../../../js/blocks/lib/classNames';
import BackgroundImage from '../../../js/blocks/components/BackgroundImage';
import BlockSettings from '../../../js/blocks/components/BlockSettings';

registerBlockType(metadata.name, {
  edit({ attributes, setAttributes, clientId }) {
    const blockProps = useBlockProps();

    blockProps.className = containerClassNames(attributes, [ 'wysiwyg' ]).join(' ');

    return (
      <div className={ sectionClassNames(attributes, 'wp-block-badegg-article').join(' ') }>
        <BlockSettings
          attributes={ attributes }
          setAttributes={ setAttributes }
        />

        <button
          className="badegg-article-select-parent"
          onClick={() => {
            wp.data.dispatch('core/block-editor').selectBlock(clientId);
          }}
        >
          <span className="visually-hidden">Select Block</span>
        </button>

        <div { ...blockProps }>
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
    const blockProps = useBlockProps.save();
    blockProps.className = containerClassNames(attributes, [ 'wysiwyg' ]).join(' ');

    return (
      <div className={ sectionClassNames(attributes, 'wp-block-badegg-article').join(' ') }>
        <div { ...blockProps }>
          <InnerBlocks.Content />
        </div>

        <BackgroundImage { ...attributes } />

      </div>
    )
  }
});
