<?= $this->extend('layouts/layout') ?>

<?= $this->section('content') ?>
<div class="w-full relative">
    <div class="flex flex-col w-full justify-center gap-4">
        <div class="flex flex-col mx-auto w-full md:max-w-xl bg-slate-900 border border-slate-800 rounded-xl shadow-lg shadow-elephant-800/10">
            <?php if(!empty($user)): ?>
            <div class="flex flex-col w-full px-4 py-6 md:px-8 md:pt-8 md:pb-10">
                <div class="flex flex-col mx-auto justify-center mb-5 gap-4">
                    <div class="h-28 w-28 sm:h-32 sm:w-32 md:h-36 md:w-36 rounded-full mx-auto">
                        <img class="h-28 w-28 sm:h-32 sm:w-32 md:h-36 md:w-36 rounded-full object-cover" src="<?= esc($user->photo) ?>"
                             alt="<?= esc($user->name) ?>">
                    </div>
                    <div class="flex flex-col text-center justify-center mx-auto">
                        <h1 class="text-base md:text-lg lg:text-xl tracking-wide text-slate-200 font-semibold"><?= esc($user->name) ?></h1>
                        <h2 class="text-sm md:text-base lg:text-base text-slate-300/70 md:-mt-1 font-medium">@<?= esc($user->username) ?></h2>
                    </div>
                </div>

                <?php if(!empty($user->total_games) || !empty($user->total_teams) || !empty($user->total_accounts)): ?>
                <div class="flex flex-row mx-auto justify-center mb-5 gap-2">
                    <?php if(!empty($user->total_games)):  ?>
                    <a class="flex flex-col justify-center items-center text-center px-3 p-2 md:pb-3 bg-vulcan-800 hover:bg-blue-500/50 bg-clip-padding backdrop-filter backdrop-blur-sm bg-opacity-50 rounded-lg"
                       href="<?= url_to('game') ?>">
                        <span class="text-sm md:text-base tracking-wide text-slate-200 font-semibold"><?= esc($user->total_games) ?></span>
                        <span class="text-xs text-slate-300/80 md:-mt-0.5 font-medium">Game Dibuat</span>
                    </a>
                    <?php endif ?>

                    <?php if(!empty($user->total_teams)):  ?>
                    <a class="flex flex-col justify-center items-center text-center px-3 p-2 md:pb-3 bg-vulcan-800 hover:bg-blue-500/50 bg-clip-padding backdrop-filter backdrop-blur-sm bg-opacity-50 rounded-lg"
                       href="<?= url_to('team') ?>">
                        <span class="text-sm md:text-base tracking-wide text-slate-200 font-semibold"><?= esc($user->total_teams) ?></span>
                        <span class="text-xs text-slate-300/80 md:-mt-0.5 font-medium">Tim Dibuat</span>
                    </a>
                    <?php endif ?>

                    <?php if(!empty($user->total_accounts)):  ?>
                    <a class="flex flex-col justify-center items-center text-center px-3 p-2 md:pb-3 bg-vulcan-800 hover:bg-blue-500/50 bg-clip-padding backdrop-filter backdrop-blur-sm bg-opacity-50 rounded-lg"
                       href="<?= url_to('game.account') ?>">
                        <span class="text-sm md:text-base tracking-wide text-slate-200 font-semibold"><?= esc($user->total_accounts) ?></span>
                        <span class="text-xs text-slate-300/80 md:-mt-0.5 font-medium">Akun Game</span>
                    </a>
                    <?php endif ?>
                </div>
                <?php endif ?>

                <div class="mb-5">
                    <?= view_cell('InputCell', [
                        'label' => 'Email',
                        'type' => 'text',
                        'value' => esc($user->email),
                        'disable' => true,
                    ]) ?>
                </div>
                <div class="mb-5">
                    <?= view_cell('InputCell', [
                        'label' => 'Telepon',
                        'type' => 'text',
                        'value' => esc($user->phone),
                        'disable' => true,
                    ]) ?>
                </div>

                <?php if(auth()->isAdmin()): ?>
                <div class="mb-5">
                    <?= view_cell('InputCell', [
                        'label' => 'Role',
                        'type' => 'text',
                        'value' => esc($user->role),
                        'disable' => true,
                    ]) ?>
                </div>
                <?php endif ?>

                <div class="mb-8">
                    <?= view_cell('InputCell', [
                        'label' => 'Mendaftar Pada',
                        'type' => 'text',
                        'value' => readableTimestamp($user->created_at),
                        'disable' => true,
                    ]) ?>
                </div>

                <?php if(intval($user->id) == intval(auth()->user()->id)): ?>
                <div class="flex w-full justify-end">
                    <a class="text-sm text-center w-auto py-2 md:py-1.5 px-4 font-medium rounded-md border transition focus:outline-none bg-vulcan-600 border-transparent text-slate-200 hover:bg-vulcan-500 hover:border-vulcan-500 hover:text-white cursor-pointer"
                       href="<?= url_to('user.profile.edit') ?>">
                        <i class="fa-solid fa-pen mr-0.5"></i>
                        Edit Profil
                    </a>
                </div>
                <?php endif ?>
            </div>
            <?php else: ?>
            <div class="flex flex-col w-full justify-center text-center py-8 md:py-16 px-4 gap-0.5">
                <span class="text-slate-300/90 font-semibold text-base md:text-lg">Upps...</span>
                <span class="text-sm font-medium text-slate-400">Pengguna dengan username <?= esc('nsmle') ?> tidak dapat ditemukan!</span>
            </div>
            <?php endif ?>
        </div>
        <div class="flex flex-col mx-auto w-full md:max-w-xl bg-slate-900 border border-slate-800 rounded-xl shadow-lg shadow-elephant-800/10">
            <div class="flex flex-col sm:flex-row md:flex-row md:justify-between w-full px-4 py-6 md:p-6 gap-4">
                <?php if(auth()->isAdmin()): ?><a
                   class="w-full whitespace-nowrap text-sm text-center py-2 md:py-1.5 px-4 font-medium rounded-md border transition focus:outline-none bg-vulcan-600 border-transparent text-slate-200 hover:bg-vulcan-500 hover:border-vulcan-500 hover:text-white cursor-pointer"
                   href="<?= url_to('user') ?>">
                    <i class="fa-solid fa-user-group mr-0.5"></i>
                    Semua Pengguna
                </a>
                <?php endif ?>
                <form class="flex w-full" action="<?= url_to('logout') ?>" method="POST">
                    <button class="w-full text-sm text-center py-2 md:py-1.5 px-4 font-medium rounded-md border transition focus:outline-none bg-rose-600 border-transparent text-slate-200 hover:bg-rose-500 hover:border-rose-500 hover:text-white cursor-pointer"
                            type="submit">
                        <i class="fa-solid fa-right-from-bracket mr-0.5"></i>
                        Keluar
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
