import.meta.glob([
  '../images/**',
  '../fonts/**',
]);

import Header from './sections/header.js';
import LazyLoad from './lib/Lazy.js';

LazyLoad();
Header();
