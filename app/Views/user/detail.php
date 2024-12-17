<?= $this->extend('layouts/layout') ?>

<?= $this->section('content') ?>
<div class="w-full relative">
    <div class="flex w-full justify-center">
        <div class="flex flex-col w-full md:max-w-xl bg-slate-900 border border-slate-800 rounded-xl shadow-lg shadow-elephant-800/10">
            <?php if(empty($user) || !empty(session()->getFlashdata("error"))): ?>
            <div class="flex flex-col w-full justify-center text-center py-8 md:py-16 px-4 gap-0.5">
                <span class="text-slate-300/90 font-semibold text-base md:text-lg">Upps...</span>
                <span class="text-sm font-medium text-slate-400"><?= esc(session()->getFlashdata('error')) ?></span>
            </div>
            <?php else: ?>
            <div class="flex flex-col w-full px-4 py-6 md:px-8 md:pt-8 md:pb-10">
                <div class="flex flex-col mx-auto justify-center mb-5 gap-4">
                    <div class="h-28 w-28 sm:h-32 sm:w-32 md:h-36 md:w-36 rounded-full mx-auto">
                        <img class="h-28 w-28 sm:h-32 sm:w-32 md:h-36 md:w-36 rounded-full object-cover" src="<?= esc($user->photo) ?>"
                             alt="<?= esc($user->name) ?>">
                    </div>
                    <div class="flex flex-col text-center justify-center max-auto">
                        <h1 class="text-base md:text-lg lg:text-xl tracking-wide text-slate-200 font-semibold"><?= esc($user->name) ?></h1>
                        <h2 class="text-sm md:text-base lg:text-base text-slate-300/70 md:-mt-1 font-medium">@<?= esc($user->username) ?></h2>
                    </div>
                </div>

                <?php if(!empty($user->total_games) || !empty($user->total_teams) || !empty($user->total_accounts)): ?>
                <div class="flex flex-row mx-auto justify-center mb-5 gap-2">
                    <?php if(!empty($user->total_games)):  ?>
                    <div
                         class="flex flex-col justify-center items-center text-center px-3 p-2 md:pb-3 bg-vulcan-800 bg-clip-padding backdrop-filter backdrop-blur-sm bg-opacity-50 rounded-lg">
                        <span class="text-sm md:text-base tracking-wide text-slate-200 font-semibold"><?= esc($user->total_games) ?></span>
                        <span class="text-xs text-slate-300/80 md:-mt-0.5 font-medium">Game Dibuat</span>
                    </div>
                    <?php endif ?>

                    <?php if(!empty($user->total_teams)):  ?>
                    <div
                         class="flex flex-col justify-center items-center text-center px-3 p-2 md:pb-3 bg-vulcan-800 bg-clip-padding backdrop-filter backdrop-blur-sm bg-opacity-50 rounded-lg">
                        <span class="text-sm md:text-base tracking-wide text-slate-200 font-semibold"><?= esc($user->total_teams) ?></span>
                        <span class="text-xs text-slate-300/80 md:-mt-0.5 font-medium">Tim Dibuat</span>
                    </div>
                    <?php endif ?>

                    <?php if(!empty($user->total_accounts)):  ?>
                    <div
                         class="flex flex-col justify-center items-center text-center px-3 p-2 md:pb-3 bg-vulcan-800 bg-clip-padding backdrop-filter backdrop-blur-sm bg-opacity-50 rounded-lg">
                        <span class="text-sm md:text-base tracking-wide text-slate-200 font-semibold"><?= esc($user->total_accounts) ?></span>
                        <span class="text-xs text-slate-300/80 md:-mt-0.5 font-medium">Akun Game</span>
                    </div>
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
                        'label' => 'Peran',
                        'type' => 'text',
                        'value' => esc($user->role == 'admin' ? 'Admin' : 'Pengguna'),
                        'disable' => true,
                    ]) ?>
                </div>
                <div class="mb-5">
                    <?= view_cell('InputCell', [
                        'label' => 'Mendaftar Pada',
                        'type' => 'text',
                        'value' => readableTimestamp($user->created_at),
                        'disable' => true,
                    ]) ?>
                </div>
                <div class="mb-8">
                    <?= view_cell('InputCell', [
                        'label' => 'Diperbarui Pada',
                        'type' => 'text',
                        'value' => readableTimestamp($user->updated_at),
                        'disable' => true,
                    ]) ?>
                </div>
                <div class="flex w-full justify-end">
                    <a class="text-sm text-center w-auto py-2 md:py-1.5 px-4 font-medium rounded-md border transition focus:outline-none bg-vulcan-600 border-transparent bg-bg-vulcan-400/80 text-slate-200 hover:bg-vulcan-500 hover:border-vulcan-500 hover:text-white cursor-pointer"
                       href="<?= url_to('user') ?>">
                        <i class="fa-solid fa-user-group mr-0.5"></i>
                        Semua Pengguna
                    </a>
                </div>
                <?php else: ?>
                <div class="mb-5">
                    <?= view_cell('InputCell', [
                        'label' => 'Bergabung Pada',
                        'type' => 'text',
                        'value' => readableTimestamp($user->created_at),
                        'disable' => true,
                    ]) ?>
                </div>
                <?php endif ?>

            </div>
            <?php endif ?>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
