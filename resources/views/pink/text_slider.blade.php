@if($contentSlider)
    @foreach($contentSlider as $item)
        <div class="widget-last widget text-image">
            <h3>{{$item->title}}</h3>
            <div class="text-image" style="text-align:left"><img src="{{asset(env('THEME'))}}/images/{{$item->img}}" alt="Customer support" /></div>
            <p>{{$item->text}}</p>
        </div>
    @endforeach
@endif
