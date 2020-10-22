@if($articles)
    <div id="content-page" class="content group">
        <div class="hentry group">
            <h2>Добавненные статьи</h2>
            <div class="short-table white">
                <table style="width: 100%" cellspacing="0" cellpadding="0">
                    <thead>
                        <tr>
                            <th class="align-left">ID</th>
                            <th>Заголовок</th>
                            <th>Текст</th>
                            <th>Изображение</th>
                            <th>Категория</th>
                            <th>Псевдоним</th>
                            <th>Действие</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($articles as $article)
                        <tr>
                            <td class="align-left">{{$article->id}}</td>
                            <td class="align-left"><a href="{{route('article.edit', ['article' => $article->alias])}}">{{$article->title}}</a></td>
                            <td class="align-left">{{\Illuminate\Support\Str::limit($article->text, 200)}}</td>
                            <td>
                                @if(isset($article->img->mini))
                                    <img src="{{asset(env('THEME'))}}/images/articles/{{$article->img->mini}}" alt="">
                                @endif
                            </td>
                            <td>{{$article->category->title}}</td>
                            <td>{{$article->alias}}</td>
                            <td>
                                <form action="{{route('article.destroy', ['article' => $article->alias])}}" class="form-horizontal" method="post">
                                    @csrf
                                    @method('delete')
                                    <button type="submit" class="btn btn-french-5">Удалить</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <form action="{{route('article.create')}}" method="post">
            @csrf
            <button class="btn btn-panuu-5" type="submit">Добавить материал</button>
        </form>
    </div>
@endif
