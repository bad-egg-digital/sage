export function containerClassNames(attributes, bgProps)
{

  let classNames = [
    'container',
  ];

  if('container_width' in attributes)
    classNames.push(`container-${attributes.container_width}`);

  if('alignment' in attributes)
    classNames.push(`align-${attributes.alignment}`);

  return classNames;
}

export function sectionClassNames(attributes, defaultClasses, extraClasses = [])
{
  defaultClasses = defaultClasses.split(' ');

  let classNames = [
    'section',
  ];

  if('padding_top'in attributes && !attributes.padding_top)
    classNames.push('section-zero-top');

  if('padding_bottom'in attributes && !attributes.padding_bottom)
    classNames.push('section-zero-bottom');


  // combine arrays
  classNames = classNames.concat(defaultClasses).concat(extraClasses);

  // remove duplicate items
  classNames = [ ...new Set(classNames) ];

  return classNames;
}
