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
  edit({ attributes, setAttributes }) {
    const blockProps = useBlockProps();
    blockProps.className = sectionClassNames(attributes, blockProps.className).join(' ');

    return (
      <div { ...blockProps }>
        <BlockSettings
          attributes={ attributes }
          setAttributes={ setAttributes }
        />

        <div className={ containerClassNames(attributes, [ 'wysiwyg' ]).join(' ') }>
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
    blockProps.className = sectionClassNames(attributes, blockProps.className, [ 'wysiwyg' ] ).join(' ');

    return (
      <div { ...blockProps }>
        <div className={ containerClassNames(attributes, [ 'wysiwyg' ]).join(' ') }>
          <InnerBlocks.Content />
        </div>

        <BackgroundImage { ...attributes } />

      </div>
    )
  }
});
