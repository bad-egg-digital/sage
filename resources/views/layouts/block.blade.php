<section id="{{ $block['id'] }}" class="{{ implode(' ', $data['section_classes']) }} {{ @$block['className'] }}">
  @if(@$data['heading'] || @$data['blurb'])
    <div class="section-intro container container-narrow align-centre wysiwyg bg-watermarked-content {{ @$data['knockout'] }}">
      <h2>{{ @$data['heading'] }}</h2>
      @include('components.divider')
      <p>{{ @$data['blurb'] }}</p>
    </div>
  @endif

  <div class="section container container-large block-content bg-watermarked-content">
    @yield('block-content')
  </div>

  @if(@$data['links'])
    <div class="section-footer container container-narrow align-centre wysiwyg bg-watermarked-content {{ @$data['knockout'] }}">
      <div class="button-wrap">
        @foreach($data['links'] as $link)
          @include('components.button', $link)
        @endforeach
      </div>
    </div>
  @endif

  @if(@$data['bg_image'])
    <div class="bg-watermarked-image" style="opacity: {!! (@$data['bg_opacity'] ?: 30) * 0.01 !!}">
      {!! $ImageSrcset->render([
        'image' => $data['bg_image'],
        'name' => 'hero',
        'lazy' => true,
      ]) !!}
    </div>
  @endif

</section>
