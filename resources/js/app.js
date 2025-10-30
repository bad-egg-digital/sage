import.meta.glob([
  '../images/**',
  '../fonts/**',
]);

import domReady from '@wordpress/dom-ready';
import blocks from './blocks.js';
import Header from './sections/header.js';
import LazyLoad from './lib/Lazy.js';

/**
 * Application entrypoint
 */
domReady(async () => {
  LazyLoad();
  blocks();
  Header();
});
