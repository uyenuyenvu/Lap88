<li><a href="{{ route('frontend.category', $menu->slug) }}">{{ $menu->name }}</a>
    @if(count($menu->children) > 1)
        <ul>
            <li>
                <ul>
                    @foreach($menu->children as $children)
                        @include('frontend.includes.children-menus', ['menu' => $children])
                    @endforeach
                </ul>
            </li>
        </ul>
    @endif
</li>
