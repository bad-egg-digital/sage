import.meta.glob([
  '../images/**',
  '../fonts/**',
]);

// import.meta.glob('../views/blocks/**/{style.scss,script.js,view.js}', { eager: true })

import Header from '../views/sections/header/header.js';
import LazyLoad from './lib/Lazy.js';

LazyLoad();
Header();

