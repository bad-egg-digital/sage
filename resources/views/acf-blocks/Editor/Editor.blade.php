@if(@$data['section_anchor_id'])
  <div id="{{ $data['section_anchor_id'] }}" class="section-anchor"></div>
@endif

<section
  id="{{ $block['id'] }}"
  class="badegg-block
    @if(@$data['section_classes']) {{ implode(' ', $data['section_classes']) }} @endif
    {{ @$block['className'] }}
  ">

  <div class="section-{{ $block['name'] }}-inner">
    <div class="container container-{{ @$data['container_width'] ? $data['container_width'] : 'medium' }} block-content wysiwyg">
      <InnerBlocks
        allowedBlocks="{!! esc_attr( wp_json_encode( $data['allowed_blocks'] ) ) !!}"
        template="{!! esc_attr( wp_json_encode( $data['template'] ) ) !!}"
      />
    </div>
  </div>

</section>
