// block.json's editorScript, loaded only in the block editor

import { registerBlockType } from '@wordpress/blocks';
import { useBlockProps } from '@wordpress/block-editor';
import metadata from './block.json';

registerBlockType(metadata.name, {
  edit() {
    const blockProps = useBlockProps();

    return (
      <section { ...blockProps }>
        <h2>Bad Egg Block Example</h2>
      </section>
    );
  }
});
