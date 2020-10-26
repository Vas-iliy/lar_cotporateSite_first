<div id="content-page" class="content group">
    <div class="hentry group">
        <h3 class="title_page">Пользователи</h3>
        <div class="short-table white">
            <table style="width: 100%;">
                <thead>
                    <th>Name</th>
                    <th>Link</th>
                    <th>Удалить</th>
                </thead>
                @if($menu)
                    @include(env('THEME'). '.admin.custom-menu-items', ['items' => $menu->roots(), 'paddingLeft' => ''])
                @endif
            </table>
        </div>
        <a href="{{route('menus.create')}}" class="btn btn-the-salmon-dance-3" >Добавить пункт</a>
    </div>
</div>
