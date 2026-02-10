@if(socials)
  <ul class="socials nolist">
    @foreach($socials as $social)
      <li>
        <a href="{{ get_field('url', $social) }}" rel="noopener nofollow noreferrer" target="_blank">
          <i class="fa-brands fa-{{ get_field('fontawesome_brands', $social) }}"></i>
          <span class="visually-hidden">{{ get_the_title($social) }}</span>
        </a>
      </li>
    @endforeach
  </ul>
@endif
