import domReady from '@wordpress/dom-ready';
import blockParents from '../json/block-parents.json';
import blockWhitelist from '../json/block-core-whitelist.json';
import.meta.glob('../views/blocks/**/{index.jsx,index.js}', { eager: true })

domReady(() => {
  const restrictEditorParentBlocks = (settings, name) => {
    if (blockWhitelist.includes(name)) {
      settings.parent = blockParents;
    }

    return settings
  }

  wp.hooks.addFilter(
      'blocks.registerBlockType',
      'badegg/restrict-parent-blocks',
      restrictEditorParentBlocks
  );

  // find blocks styles
  wp.blocks.getBlockTypes().forEach((block) => {
      if (_.isArray(block['styles'])) {
          console.log('editor.js ' + block.name, _.pluck(block['styles'], 'name'));
      }
  });
});
