import { registerBlockType } from '@wordpress/blocks';

registerBlockType('badegg/example', {
  edit() {
    return (
      <section className="block-badegg-example">
        <h2>Bad Egg Block Example</h2>
      </section>
    );
  },
});
