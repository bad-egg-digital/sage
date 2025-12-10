import { registerBlockType } from '@wordpress/blocks';

registerBlockType('badegg/example', {
  apiVersion: 3, // optional in JS, primarily in block.json
  edit() {
    return (
      <section className="block-badegg-example">
        <h2>Bad Egg Block Example</h2>
      </section>
    );
  },
});
