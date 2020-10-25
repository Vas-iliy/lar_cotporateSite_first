<div id="content-page" class="content group">
    <div class="hentry group">
        <form action="{{(isset($article->id)) ? route('article.update', ['article' => $article->alias]) : route('article.store')}}" class="contact-form" method="post" enctype="multipart/form-data">
            @csrf
            @if(isset($article->id))
                @method('put')
            @endif
            <ul>
                <li class="text-field">
                    <label for="name-contact-us">
                        <span class="label">Название:</span>
                        <br/>
                        <span class="sublabel">Заголовок материала:</span>
                        <br/>
                    </label>
                    <div class="input-prepend">
                        <span class="add-on"><i class="icon-user"></i></span>
                        <input type="text" name="title" value="{{isset($article->title) ? $article->title : old('title')}}" placeholder="Name">
                    </div>
                </li>
                <li class="text-field">
                    <label for="name-contact-us">
                        <span class="label">Ключевые слова:</span>
                        <br/>
                        <span class="sublabel">Введите псевдоним:</span>
                        <br/>
                    </label>
                    <div class="input-prepend">
                        <span class="add-on"><i class="icon-user"></i></span>
                        <input type="text" name="keywords" value="{{isset($article->keywords) ? $article->keywords : old('keywords')}}" placeholder="Keywords">
                    </div>
                </li>
                <li class="text-field">
                    <label for="name-contact-us">
                        <span class="label">Мета описание:</span>
                        <br/>
                        <span class="sublabel">Введите псевдоним:</span>
                        <br/>
                    </label>
                    <div class="input-prepend">
                        <span class="add-on"><i class="icon-user"></i></span>
                        <input type="text" name="meta_desc" value="{{isset($article->meta_desc) ? $article->meta_desc : old('keywords')}}" placeholder="Meta">
                    </div>
                </li>
                <li class="text-field">
                    <label for="name-contact-us">
                        <span class="label">Псевдоним:</span>
                        <br/>
                        <span class="sublabel">Введите псевдоним:</span>
                        <br/>
                    </label>
                    <div class="input-prepend">
                        <span class="add-on"><i class="icon-user"></i></span>
                        <input type="text" name="alias" value="{{isset($article->alias) ? $article->alias : old('alias')}}" placeholder="Alias">
                    </div>
                </li>
                <li class="text-field">
                    <label for="name-contact-us">
                        <span class="label">Краткое описание:</span>
                        <br/>
                    </label>
                    <div class="input-prepend">
                        <textarea name="desc" id="editor" cols="30" rows="10">{{isset($article->desc) ? $article->desc : old('desc')}}</textarea>
                    </div>
                </li>
                <li class="text-field">
                    <label for="name-contact-us">
                        <span class="label">Описание:</span>
                        <br/>
                    </label>
                    <div class="input-prepend">
                        <textarea name="text" id="editor2" cols="30" rows="10">{{isset($article->text) ? $article->text : old('text')}}</textarea>
                    </div>
                </li>
                @if(isset($article->img->path))
                    <li class="text-field">
                        <label for="name-contact-us">
                            <span class="label">Изображение материала:</span>
                            <br/>
                        </label>
                        <img src="{{asset(env('THEME'))}}/images/articles/{{$article->img->path}}" alt="">
                        <input type="hidden" name="old_image" value="{{$article->img->path}}">
                    </li>
                @endif
                <li class="text-field">
                    <label for="name-contact-us">
                        <span class="label">Изображение:</span>
                        <br/>

                        <span class="sublabel">Изображение материала:</span>
                        <br/>
                    </label>
                    <div class="input-prepend">
                        <input type="file" name="image" class="filestyle" data-placeholder="Файла нет">
                    </div>
                </li>
                <li class="text-field">
                    <label for="name-contact-us">
                        <span class="label">Категория:</span>
                        <br/>
                        <span class="sublabel">Категория материала:</span>
                        <br/>
                    </label>
                    <div class="input-prepend">
                        <select name="category_id" id="">
                            @foreach($categories as $cat)
                            <option value="{{$cat->id}}">{{$cat->title}}</option>
                            @endforeach
                        </select>
                    </div>
                </li>
                <li class="submit-button">
                    <button type="submit" class="btn btn-the-salmon-dance-3">Сохранить</button>
                </li>
            </ul>
        </form>

        <script>
            CKEDITOR.replace('editor');
            CKEDITOR.replace('editor2');
        </script>
    </div>
</div>
