<div>

    <div class="widget">

        <h5 class="widget-title"><span>Tags</span></h5>

        <ul class="list-inline widget-list-inline">

            {{-- add a value into getTags(5) to limit number shown, here it's 5--}}
            @foreach ( getTags() as $tag )

                <li class="list-inline-item">
                    <a href="{{ route('tag_posts',urlencode($tag)) }}">{{ $tag }}</a>
                </li>

            @endforeach

        </ul>

    </div>

</div>
