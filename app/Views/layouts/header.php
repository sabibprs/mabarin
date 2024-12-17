<header class="w-full">
    <div class="mx-auto max-w-3xl px-4 sm:px-6 md:max-w-7xl md:px-8">
        <div class="relative flex flex-wrap items-center justify-center md:justify-between">
            <div class="absolute left-0 top-0 flex flex-shrink-0 items-center py-5 md:static">
                <div class="sm:flex sm:space-x-5">
                    <div class="mt-4 text-left sm:mt-0 sm:pt-1">
                        <p class="text-2xl font-bold capitalize text-gray-200 sm:text-2xl">
                            <?php if (!empty($metadata->header->title)): ?>
                            <?= $metadata->header->title ?>
                            <?php else: ?>
                            <span class="font-medium text-gray-400">Halo,</span> <?= first_name($userAuth->name) ?>.
                            <?php endif; ?>
                        </p>
                        <p class="text-sm font-medium text-gray-400">
                            <?php if (!empty($metadata->header->description)): ?>
                            <?= $metadata->header->description ?>
                            <?php else: ?>
                            <?= $userAuth->email ?>.
                            <?php endif; ?>
                        </p>
                    </div>
                </div>
            </div>
            <div class="hidden md:ml-4 md:flex md:items-center md:py-5 md:pr-0.5">
                <div class="relative ml-4 flex-shrink-0">
                    <div class="relative">
                        <div class="profile-toggle opacity-100 transition delay-300 duration-700 hidden lg:block">
                            <button class="flex rounded-full border-2 border-transparent text-sm transition focus:border-gray-500/80 focus:outline-none">
                                <span class="h-10 w-10 rounded-full">
                                    <img class="h-10 w-10 rounded-full object-cover" src="<?= $userAuth->photo ?>" alt="<?= $userAuth->name ?>">
                                </span>
                            </button>
                        </div>
                        <div class="fixed inset-0 z-40" style="display: none;"></div>
                        <div class="profile-menu -z-50 w-48 -translate-y-full opacity-0 transition-all duration-300">
                            <div
                                 class="z-50 rounded-xl border border-vulcan-600/80 bg-vulcan-500 bg-opacity-40 bg-clip-padding px-1 py-1 shadow-lg backdrop-blur-lg backdrop-filter">
                                <div>
                                    <a class="flex items-center rounded-md px-4 py-2 text-left text-sm font-medium leading-5 text-slate-300/90 transition hover:bg-vulcan-500/30 hover:text-slate-200 focus:outline-none md:block"
                                       href="<?= url_to('home') ?>">
                                        <i class="fa-solid fa-house mr-1 md:mb-0.5"></i>
                                        <span>Home</span>
                                    </a>
                                </div>
                                <div class="pb-1 pt-0.5">
                                    <a class="flex items-center rounded-md px-4 py-2 text-left text-sm font-medium leading-5 text-slate-300/90 transition hover:bg-vulcan-500/30 hover:text-slate-200 focus:outline-none md:block"
                                       href="<?= url_to('user.profile') ?>">
                                        <i class="fa-solid fa-user mr-2"></i>
                                        <span>Profil</span>
                                    </a>
                                    <?php if(auth()->isAdmin()): ?>
                                    <a class="flex items-center rounded-md px-4 py-2 text-left text-sm font-medium leading-5 text-slate-300/90 transition hover:bg-vulcan-500/30 hover:text-slate-200 focus:outline-none md:block"
                                       href="<?= url_to('user') ?>">
                                        <i class="fa-solid fa-user-group mr-1"></i>
                                        <span>Pengguna</span>
                                    </a>
                                    <?php endif ?>
                                    <a class="flex items-center rounded-md px-4 py-2 text-left text-sm font-medium leading-5 text-slate-300/90 transition hover:bg-vulcan-500/30 hover:text-slate-200 focus:outline-none md:block"
                                       href="<?= url_to('game.account') ?>">
                                        <i class="fa-brands fa-steam mr-1.5"></i>
                                        <span>Akun Game</span>
                                    </a>
                                </div>
                                <div class="border-t border-vulcan-500/70"></div>
                                <form action="<?= url_to('logout') ?>" method="POST">
                                    <div class="pt-1 pb-0.5">
                                        <button class="flex items-center w-full rounded-md px-4 py-2 text-left text-sm font-medium leading-5 text-slate-300/90 transition hover:bg-rose-600 hover:text-white focus:outline-none md:block active:scale-95"
                                                type="submit">
                                            <i class="fa-solid fa-right-from-bracket ml-0.5 mr-1.5"></i>
                                            <span>Keluar</span>
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="absolute top-24 hidden md:block z-0 w-full border-t border-gray-600 opacity-100 transition-all delay-700 duration-700"></div>
            <div class="nav-menu-wrapper z-40" id="nav-menu-wrapper">
                <div class="flex w-full justify-between rounded-lg transition-all duration-700 lg:rounded-xl">
                    <nav class="flex w-full items-center justify-between space-x-4 transition-all duration-700 md:justify-normal">
                        <a class="nav-item <?= is_active_class('/', true) ?>" href="<?= url_to('home') ?>">
                            <span class="flex flex-col items-center gap-1.5 truncate md:flex-row md:gap-2">
                                <i class="fa-solid fa-house mb-0.5 mt-1 md:m-0 md:mb-0.5"></i>
                                <span>Home</span>
                            </span>
                        </a>
                        <a class="nav-item <?= is_active_class('/team') ?>" href="<?= url_to('team') ?>">
                            <span class="flex flex-col items-center gap-1.5 truncate md:flex-row md:gap-2">
                                <i class="fa-solid fa-layer-group mb-0.5 mt-1 md:m-0"></i>
                                <span>Team</span>
                            </span>
                        </a>
                        <a class="nav-item <?= is_active_class('/game', false, ['route' => ['/game/account'], 'matchOnly' => false]) ?>"
                           href="<?= url_to('game') ?>">
                            <span class="flex flex-col items-center gap-1.5 truncate md:flex-row md:gap-2">
                                <i class="fa-solid fa-gamepad mb-0.5 mt-1 md:m-0"></i>
                                <span>Game</span>
                            </span>
                        </a>
                        <a class="nav-item <?= is_active_class('/game/account') ?>" href="<?= url_to('game.account') ?>">
                            <span class="flex flex-col items-center gap-1.5 truncate md:flex-row md:gap-2">
                                <i class="fa-brands fa-steam mb-0.5 mt-1 md:m-0"></i>
                                <span>Akun</span>
                            </span>
                        </a>
                        <a class="nav-item hidden md:flex <?= is_active_class('/user/profile') ?>" href="<?= url_to('user.profile') ?>">
                            <span class="flex flex-col items-center gap-1.5 truncate md:flex-row md:gap-2">
                                <i class="fa-solid fa-user mb-0.5 mt-1 md:m-0"></i>
                                <span>Profil</span>
                            </span>
                        </a>
                        <?php if ($userAuth->isAdmin): ?>
                        <a class="nav-item hidden md:flex <?= is_active_class('/user', true) ?>" href="<?= url_to('user') ?>">
                            <span class="flex flex-col items-center gap-1.5 truncate md:flex-row md:gap-2">
                                <i class="fa-solid fa-user-group mb-0.5 mt-1 md:m-0"></i>
                                <span>Pengguna</span>
                            </span>
                        </a>
                        <?php endif; ?>
                        <a class="nav-item flex md:hidden <?= is_active_class('/user/profile') ?>" href="<?= url_to('user.profile') ?>">
                            <span class="flex flex-col items-center gap-1.5 truncate md:flex-row md:gap-2">
                                <img class="h-7 w-7 rounded-full object-cover" src="<?= $userAuth->photo ?>" alt="<?= $userAuth->name ?>">
                                <span>Profil</span>
                            </span>
                        </a>
                    </nav>

                    <div class="profile-toggle hidden opacity-0 transition duration-700 md:flex">
                        <button class="flex rounded-full border-2 border-transparent text-sm focus:border-gray-500/80 focus:outline-none">
                            <span class="h-10 w-10 rounded-full">
                                <img class="h-10 w-10 rounded-full object-cover" src="<?= $userAuth->photo ?>" alt="<?= $userAuth->name ?>">
                            </span>
                        </button>
                    </div>
                </div>

            </div>
            <div class="absolute right-0 flex-shrink-0 md:hidden"></div>
        </div>
</header>
