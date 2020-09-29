<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactRequest;
use App\Mail\ContactMail;
use App\Repositories\PortfolioRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Mail;

class ContactsController extends SiteController
{
    public function __construct()
    {
        parent::__construct(new \App\Repositories\MenusRepository(new \App\Menu));

        $this->bar = 'left';

        $this->template = env('THEME') . '.contact';

        $this->descr = '<h3>...Say Hello! :)</h3>
                    <h4>Get in touch with Pink Rio team</h4>';
    }

    public function index() {
        $this->title = 'contact';

        $content = view(env('THEME') . '.contact_content')->render();
        $this->vars = Arr::add($this->vars, 'content', $content);

        $this->contentLefttBar = view(env('THEME') . '.contact_bar')->render();


        return $this->renderOutput();
    }

    public function input(ContactRequest $request) {
        if ($request->isMethod('post')) {
            $data = $request->all();
            $data = Arr::add($data, 'to', 'Vkolyasev1999@mail.ru');

            Mail::send(new ContactMail($data));

            return redirect()->route('contacts')->with('status', 'Email is send');
        }

    }
}
