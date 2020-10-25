<?php

namespace App\Policies;

use App\Article;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ArtisanPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function save(User $user) {
        return $user->canDo('add_articles');
    }

    public function edit(User $user) {
        return $user->canDo('update_articles');
    }

    public function destroy(User $user, Article $article) {
        return ($user->canDo('delete_articles') && $user->id == $article->user_id);
    }
}
