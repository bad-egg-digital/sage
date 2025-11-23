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
    @if(@$data['heading'] || @$data['blurb'])
      <div class="section-intro inner inner-bottom @if($data['bg_colour'] != 'white') knockout @endif">
        <div class="container">
          <div class="section-intro-inner wysiwyg">
            <h2>{{ @$data['heading'] }}</h2>
            <p>{{ @$data['blurb'] }}</p>
          </div>

          @if(@$data['links'])
            <div class="btn-wrap">
              @foreach($data['links'] as $link)
                @include('components.button', $link)
              @endforeach
            </div>
          @endif
        </div>
      </div>
    @endif

    <div class="container{{ @$data['container_width'] ?  ' container-' . $data['container_width'] : '' }} block-content">
      @yield('block-content')
    </div>

    @if(@$data['links'])
      <div class="section-footer inner-top">
        <div class="container">
          <div class="btn-wrap">
            @foreach($data['links'] as $link)
              @include('components.button', $link)
            @endforeach
          </div>
        </div>
      </div>
    @endif

  </div>

</section>
