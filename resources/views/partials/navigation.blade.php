                        {{--@foreach($pages as $page)
                        <li class="smoothScroll {{ request()->is($page->uri) ? 'active' : '' }} {{ $page->uri == 'productos' ? 'dropdown' : '' }}">
                          <a href="{{ url(''.$page->uri) }}">{{ $page->title }}</a>
                        </li>
                        @endforeach
                        --}}
                        
@foreach($pages as $page)
<li class="{{ count($page->children) ? ($page->isChild() ? 'dropdown-submenu' : 'dropdown') : '' }} {{ str_slug($page->title) }}">
  <a href="{{ Request::is('/') || $page->uri == '/' ? url($page->uri) : url('/'.$page->uri) }}" class="smoothScroll {{ count($page->children) ? ($page->isChild() ? 'dropdown-submenu' : 'dropdown-toggle') : '' }} {{ str_slug($page->title) }} {{ Request::is($page->uri) ? 'active' : '' }} {{ !$page->isChild() ? 'main-link' : '' }}" {{ count($page->children) ? ($page->isChild() ? 'dropdown-submenu' : 'data-toggle=dropdown role=button aria-haspopup=true aria-expanded=false') : '' }}>
    {{ $page->title }}
    @if(count($page->children))
      <i class="fa fa-angle-down {{ $page->isChild() ? 'right' : '' }}"></i>
    @endif
  </a>
  @if(count($page->children))
    <ul class="dropdown-menu">
      @include('partials.navigation', ['pages' => $page->children])
    </ul>
  @endif
</li>
@endforeach
