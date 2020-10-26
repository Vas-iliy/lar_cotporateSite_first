<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\PermissionsRepository;
use App\Repositories\RolesRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class PermissionsController extends AdminController
{
    protected $per_rep;
    protected $rol_rep;

    public function __construct(PermissionsRepository $per_rep, RolesRepository $rol_rep)
    {
        parent::__construct();
        $this->per_rep = $per_rep;
        $this->rol_rep = $rol_rep;

        $this->template = env('THEME') . '.admin.permissions';
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        if (Gate::denies('edit_users')){
            abort(403);
        }

        $this->title = 'Менеджер привелегий пользователей';

        $roles = $this->getRoles();
        $permissions = $this->getPermissions();

        $this->content = view(env('THEME') . '.admin.permissions_content', compact(['roles', 'permissions']))->render();

        return $this->renderOutput();
    }

    private function getRoles() {
        return $this->rol_rep->get();
    }

    private function getPermissions() {
        return $this->per_rep->get();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
