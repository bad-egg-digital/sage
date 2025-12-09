import.meta.glob([
  '../images/**',
  '../fonts/**',
]);

import Header from '../views/sections/header/header.js';
import LazyLoad from './lib/Lazy.js';

LazyLoad();
Header();
