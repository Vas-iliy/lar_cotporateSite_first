@extends(env('THEME') . '.layouts.site')

@section('content')
    <div id="content-page" class="content group">
        <div class="hentry group">
            <form action="{{url('/login')}}" id="contact-form-contact-us" class="contact-form" method="post">
                @csrf
                <div class="usermessagea"></div>
                <fieldset>
                    <ul>
                        <li class="text-field">
                            <label for="name-contact-us">
                                <span class="label">Name</span>
                                <br />					<span class="sublabel">This is the name</span><br />
                            </label>
                            <div class="input-prepend"><span class="add-on"><i class="icon-user"></i></span><input type="text" name="login" id="name-contact-us" class="required" value="" /></div>
                            <div class="msg-error"></div>
                        </li>
                        <li class="text-field">
                            <label for="email-contact-us">
                                <span class="label">Password</span>
                                <br />					<span class="sublabel">This is a fiel for password</span><br />
                            </label>
                            <div class="input-prepend"><span class="add-on"><i class="icon-envelope"></i></span><input type="password" name="password" id="email-contact-us" class="required email-validate" value="" /></div>
                            <div class="msg-error"></div>
                        </li>
                        <li class="submit-button">
                            <input type="submit" value="Отправить" class="sendmail alignright">
                        </li>
                    </ul>
                </fieldset>
            </form>

        </div>
    </div>
@endsection
