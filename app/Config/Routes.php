<?php

use CodeIgniter\Router\RouteCollection;
use App\Controllers\{Auth, Game, GameAccount, Home, Team, TeamMember, User};

/**
 * @var RouteCollection $routes
 */
$routes->get('/', [Home::class, 'main'], ['as' => 'home']);


// Authentication Routes
$routes->group('auth', static function ($route) {
    $route->get('', [Auth::class, 'main']);
    $route->post('logout', [Auth::class, 'logout'], ['as' => 'logout']);
    $route->match(['get', 'post'], 'login', [Auth::class, 'login'], ['as' => 'login']);
    $route->match(['get', 'post'], 'register', [Auth::class, 'register'], ['as' => 'register']);
});

// Game Routes
$routes->group('game', static function ($route) {
    // Account Game Routes
    $route->group('account', static function ($route) {
        $route->get('', [GameAccount::class, 'main'], ['as' => 'game.account']);
        $route->match(['get', 'post'], 'add', [GameAccount::class, "addAccount"], ['as' => 'game.account.add']);
    });
    $route->group('(:any)/account', static function ($route) {
        $route->match(['get', 'post'], '(:any)/edit', [GameAccount::class, "editAccount"], ['as' => 'game.account.edit']);
        $route->post('(:any)/verify', [GameAccount::class, "verifyAccount"], ['as' => 'game.account.verify']);
        $route->post('(:any)/delete', [GameAccount::class, "deleteAccount"], ['as' => 'game.account.delete']);
    });

    // Game
    $route->get('', [Game::class, 'main'], ['as' => 'game']);
    $route->match(['get', 'post'], 'add', [Game::class, "addGame"], ['as' => 'game.add']);
    $route->match(['get', 'post'], '(:any)/edit', [Game::class, "editGame"], ['as' => 'game.edit']);
    $route->match(['get', 'post'], '(:any)/verify', [Game::class, "editGame"], ['as' => 'game.verify']);
    $route->post('(:any)/delete', [Game::class, "deleteGame"], ['as' => 'game.delete']);
    $route->post('upload-image', [Game::class, "uploadImage"], ['as' => 'game.upload-image']);
    $route->get('(:any)', [Game::class, "detailGame"], ['as' => 'game.detail']);
});

// Team Routes
$routes->group('team', static function ($route) {
    // Team Route
    $route->get('', [Team::class, 'main'], ['as' => 'team']);
    $route->get('(:any)/detail', [Team::class, 'main'], ['as' => 'team.detail']);
    $route->match(['get', 'post'], 'create', [Team::class, "addTeam"], ['as' => 'team.add']);
    $route->match(['get', 'post'], '(:any)/edit', [Team::class, "editTeam"], ['as' => 'team.edit']);
    $route->post('(:any)/delete', [Team::class, "deleteTeam"], ['as' => 'team.delete']);
    $route->post('(:any)/archive', [Team::class, "archiveTeam"], ['as' => 'team.archive']);

    // Team Member Route
    $route->match(['get', 'post'], '(:any)/join', [TeamMember::class, "joinTeam"], ['as' => 'team.join']);
    $route->match(['get', 'post'], '(:any)/leave/(:any)', [TeamMember::class, "leaveTeam"], ['as' => 'team.leave']);
});

// User Routes
$routes->group('user', static function ($route) {
    $route->get('', [User::class, 'main'], ['as' => 'user']);
    $route->get('profile', [User::class, 'selfProfile'], ['as' => 'user.profile']);
    $route->post('photo/upload', [User::class, "uploadPhotoProfile"], ['as' => 'user.profile.upload-photo']);
    $route->match(['get', 'post'], 'profile/edit', [User::class, 'editSelfProfile'], ['as' => 'user.profile.edit']);
    $route->match(['get', 'post'], '(:any)/edit', [User::class, 'editProfile'], ['as' => 'user.edit']);
    $route->get('(:any)/', [User::class, 'userProfile'], ['as' => 'user.detail']);
});
