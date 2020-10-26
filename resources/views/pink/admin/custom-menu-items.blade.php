@foreach($items as $item)
    <tr>
        <td style="text-align:left;">{{$paddingLeft}}<a href="{{route('menus.edit', ['menu' => $item->id])}}">{{$item->title}}</a></td>
        <td>{{$item->url()}}</td>
        <td>
            <form action="{{route('menus.destroy', ['menu' => $item->id])}}" method="post" class="form-horizontal">
                @csrf
                @method('delete')
                <button type="submit" class="btn btn-french-5">Удалить</button>
            </form>
        </td>
    </tr>
    @if($item->hasChildren())
        <ul class="sub-menu">
            @include(env('THEME') . '.admin.custom-menu-items', ['items' => $item->children(), 'paddingLeft' => $paddingLeft.'---'])
        </ul>
    @endif
@endforeach
