<?php

use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome')->middleware(['guest'])->name('welcome');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

Route::get('discord', 'App\Http\Controllers\DiscordController@show')
    ->middleware(['auth'])
    ->name('discord.show');

Route::post('discord', 'App\Http\Controllers\DiscordController@store')
    ->middleware(['auth'])
    ->name('discord.store');

Route::get('people', 'App\Http\Controllers\UserController@index')
    ->middleware(['auth'])
    ->name('people.index');

Route::get('profile/{user:profile}', 'App\Http\Controllers\UserController@show')
    ->middleware(['auth'])
    ->name('people.show');

Route::get('projects/create', 'App\Http\Controllers\ProjectController@create')
    ->middleware(['auth'])
    ->name('projects.create');

Route::get('projects', 'App\Http\Controllers\ProjectController@index')
    ->middleware(['auth'])
    ->name('projects.index');

Route::get('projects/{project:slug}', 'App\Http\Controllers\ProjectController@show')
    ->middleware(['auth'])
    ->name('projects.show');

Route::get('projects/{project}/edit', 'App\Http\Controllers\ProjectController@edit')
    ->middleware(['auth', 'can:update,project'])
    ->name('projects.edit');

Route::put('projects/{project}', 'App\Http\Controllers\ProjectController@update')
    ->middleware(['auth', 'can:update,project'])
    ->name('projects.update');

Route::post('projects', 'App\Http\Controllers\ProjectController@store')
    ->middleware(['auth'])
    ->name('projects.store');

Route::post('projects/{project}/updates', 'App\Http\Controllers\ProjectUpdateController@store')
    ->middleware(['auth'])
    ->name('projects.updates.store');

Route::get('events', 'App\Http\Controllers\EventController@index')
    ->middleware(['auth'])
    ->name('events.index');

Route::get('events/{event:slug}', 'App\Http\Controllers\EventController@show')
    ->middleware(['auth'])
    ->name('events.show');

require __DIR__.'/auth.php';
