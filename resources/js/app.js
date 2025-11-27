import.meta.glob([
  '../images/**',
  '../fonts/**',
]);

import blocks from './blocks.js';
import Header from './sections/header.js';
import LazyLoad from './lib/Lazy.js';

LazyLoad();
blocks();
Header();
