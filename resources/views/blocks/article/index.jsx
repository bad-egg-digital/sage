import { registerBlockType } from '@wordpress/blocks';
import { InnerBlocks, useBlockProps } from '@wordpress/block-editor';
import metadata from './block.json';
import allowedBlocks from '../../../json/core-block-whitelist.json';

registerBlockType(metadata.name, {
  icon: {
    src: 'format-aside',
    foreground: '#f58762',
  },
  edit({ attributes, setAttributes }) {
    const blockProps = useBlockProps();

    return (
      <section { ...blockProps }>
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
      </section>
    );
  },
  save() {
    return (
      <section { ...useBlockProps.save() }>
        <div className="container">
          <InnerBlocks.Content />
        </div>
      </section>
    )
  }
});
