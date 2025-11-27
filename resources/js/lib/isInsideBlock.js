export default function isInsideMyACFBlock(blockName)
{
  const editor = wp.data.select('core/block-editor');
  const selectedId = editor.getSelectedBlockClientId();

  if (!selectedId) return false;

  const parents = editor.getBlockParents(selectedId);
  const parentNames = parents.map(id => editor.getBlockName(id));

  return parentNames.includes(blockName);
}
