<div class="widget-first widget recent-posts">
    @if($articles)
        <h3>{{trans('ru.form_blog')}}</h3>
        <div class="recent-post group">
            @foreach($articles as $article)
                <div class="hentry-post group">
                    <div class="thumb-img"><img src="{{asset(env('THEME'))}}/images/articles/{{$article->img->mini}}" alt="001" title="001" /></div>
                    <div class="text">
                        <a href="{{route('articles.show', ['alias' => $article->alias])}}" title="Section shortcodes &amp; sticky posts!" class="title">{{$article->title}}</a>
                        <p class="post-date">{{$article->created_at->format('F d, Y')}}</p>
                    </div>
                </div>
            @endforeach
        </div>
    @endif


</div>

{!! $text_slider !!}
