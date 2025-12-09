import domReady from '@wordpress/dom-ready';
import blockWhitelist from '../json/core-block-whitelist.json';

domReady(() => {

  const restrictEditorParentBlocks = (settings, name) => {
    const TEXT_EDITOR_BLOCKS = blockWhitelist;

    if (TEXT_EDITOR_BLOCKS.includes(name)) {
      settings.parent = [
        'acf/badegg-editor',
      ];
    }

    return settings
  }

  wp.hooks.addFilter(
      'blocks.registerBlockType',
      'badegg/restrict-parent-blocks',
      restrictEditorParentBlocks
  );

});
