<?php

// SITE MODULE | DASHBOARD
\Router::set('home', '')->rule('id', '\d+')->uses('Index@index');
\Router::set('capcha', 'capcha/')->uses('Index@capcha');
\Router::set('checkCapcha', 'check/')->uses('Index@check');

// SITE MODULE | USERS
\Router::set('login', 'login/')->uses('Users@login');
\Router::set('logout', 'logout/')->uses('Users@logout');
\Router::set('users', 'users/')->uses('Users@list');
\Router::set('usersView', 'users/view/{id}/')->rule('id', '\d+')->uses('Users@view');
\Router::set('usersAdd', 'users/add/')->uses('Users@add');
\Router::set('usersEdit', 'users/edit/{id}/')->rule('s', '[a-z]+')->rule('id', '\d+')->uses('Users@edit');
\Router::set('usersDelete', 'users/delete/{id}/')->rule('id', '\d+')->uses('Users@delete');
\Router::set('shadowLogin', 'users/shadow/{id}/')->rule('id', '\d+')->uses('Users@shadow');
