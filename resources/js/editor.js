import domReady from '@wordpress/dom-ready';

domReady(() => {

  const restrictEditorParentBlocks = (settings, name) => {
    const TEXT_EDITOR_BLOCKS = [
      // Design
      'core/separator',
      'core/spacer',

      // Media
      'core/cover',
      'core/file',
      'core/gallery',
      'core/image',
      'core/media-text',
      'core/audio',
      'core/video',

      // Text
      'core/footnotes',
      'core/heading',
      'core/list',
      'core/code',
      'core/details',
      'core/freeform',
      'core/list-item',
      'core/missing',
      'core/paragraph',
      'core/preformatted',
      'core/pullquote',
      'core/quote',
      'core/table',
      'core/verse',
    ];

    if (TEXT_EDITOR_BLOCKS.includes(name)) {
      settings.parent = ['acf/badegg-editor']
    }

    // console.log(settings, name)

    return settings
  }

  wp.hooks.addFilter(
      'blocks.registerBlockType',
      'your-project-name/restrict-parent-blocks',
      restrictEditorParentBlocks
  );

});
