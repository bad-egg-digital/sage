<ul class="socials nolist">
  @foreach($socials as $social)
    <li>
      <a
        class="fa-brands fa-{{ get_field('fontawesome_brands', $social) }}"
        href="{{ get_field('url', $social) }}"
        rel="noopener nofollow noreferrer"
        target="_blank"
      ><span class="visually-hidden">{{ get_the_title($social) }}</span></a>
    </li>
  @endforeach
</ul>
