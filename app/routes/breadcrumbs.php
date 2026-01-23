<?php // routes/breadcrumbs.php

// Note: Laravel will automatically resolve `Breadcrumbs::` without
// this import. This is nice for IDE syntax and refactoring.
use Diglactic\Breadcrumbs\Breadcrumbs;

// This import is also not required, and you could replace `BreadcrumbTrail $trail`
//  with `$trail`. This is nice for IDE type checking and completion.
use Diglactic\Breadcrumbs\Generator as BreadcrumbTrail;

// Models
use App\Models\Post;
use App\Models\User;

// Home
Breadcrumbs::for('home', function (BreadcrumbTrail $trail) {
    $trail->push(Lang::get('routes.web.home'), route('home'));
});

// Home > 5bukv
Breadcrumbs::for('5bukv', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push(Lang::get('routes.web.5bukv'), route('5bukv'));
});

// Home > Posts
Breadcrumbs::for('posts.index', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push(Lang::get('routes.web.posts.index'), route('posts.index'));
});

// Home > Posts > User
Breadcrumbs::for('posts.indexUser', function (BreadcrumbTrail $trail, User $user) {
    $trail->parent('posts.index');
    $trail->push($user->name, route('posts.indexUser', $user));
});

// Home > Posts > Create
Breadcrumbs::for('posts.create', function (BreadcrumbTrail $trail) {
    $trail->parent('posts.index');
    $trail->push(Lang::get('routes.web.posts.create'), route('posts.create'));
});

// Home > Posts > Show
Breadcrumbs::for('posts.show', function (BreadcrumbTrail $trail, Post $post) {
    $trail->parent('posts.index');
    $trail->push($post->user->name, route('posts.indexUser', $post->user));
    $trail->push($post->title, route('posts.show', $post));
});

// Home > Posts > Edit
Breadcrumbs::for('posts.edit', function (BreadcrumbTrail $trail, Post $post) {
    $trail->parent('posts.show', $post);
    $trail->push(Lang::get('routes.web.posts.edit'), route('posts.edit', $post));
});

// Home > Uploads
Breadcrumbs::for('uploads.index', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push(Lang::get('routes.web.uploads.index'), route('uploads.index'));
});