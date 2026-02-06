import.meta.glob([
  '../images/**',
  '../fonts/**',
]);

import Header from '../views/sections/header/header.js';
import LazyLoad from './lib/Lazy.js';
import BadEggLightbox from './lib/BadEggLightbox';

Header();
LazyLoad();
BadEggLightbox();
