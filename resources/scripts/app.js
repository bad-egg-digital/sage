import domReady from '@roots/sage/client/dom-ready';
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

/**
 * @see {@link https://webpack.js.org/api/hot-module-replacement/}
 */
if (import.meta.webpackHot) import.meta.webpackHot.accept(console.error);
