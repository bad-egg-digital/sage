// block.json's editorScript, loaded only in the block editor

import { registerBlockType } from '@wordpress/blocks';
import { InnerBlocks, useBlockProps } from '@wordpress/block-editor';
import metadata from './block.json';
import allowedBlocks from '../../../json/core-block-whitelist.json';

registerBlockType(metadata.name, {
  edit({ attributes, setAttributes }) {
    const blockProps = useBlockProps();

    return (
      <div { ...blockProps }>
        <div className="container">
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
  save() {
    return (
      <div { ...useBlockProps.save() }>
        <div className="container">
          <InnerBlocks.Content />
        </div>
      </div>
    )
  }
});
