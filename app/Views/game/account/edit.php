<?= $this->extend('layouts/layout') ?>

<?= $this->section('content') ?>
<div class="w-full relative">
    <div class="flex w-full justify-center">
        <div class="flex flex-col w-full md:max-w-2xl bg-slate-900 border border-slate-800 rounded-xl shadow-lg shadow-elephant-800/10">
            <form class="flex flex-col w-full  px-4 py-6 md:px-8 md:pt-8 md:pb-10"
                  action="<?= url_to('game.account.edit', $account->game->code, $account->identity) ?>" method="post" accept-charset="utf-8">
                <input id="account_user" name="account_user" type="hidden" value="<?= set_value('account_user', $account->user->id) ?>">
                <?php if ($userAuth->isUser): ?>
                <input id="account_status" name="account_status" type="hidden"
                       value="<?= strval(set_value('account_status', auth()->isAdmin() ? $account->status : 'unverified')) ?>">
                <?php endif?>
                <div class="mb-5">
                    <?= view_cell('InputGameCell', [
                        'name' => 'account_game',
                        'label' => 'Game',
                        'placeholder' => 'Berniat ganti game?',
                        'value' => set_value('account_game', $account->game->id),
                        'errorMessage' => !empty($error->account_game) ? $error->account_game : null,
                    ]) ?>
                </div>
                <div class="mb-5">
                    <?= view_cell('InputCell', [
                        'name' => 'account_identity',
                        'label' => 'User Id',
                        'type' => 'number',
                        'placeholder' => '633699592',
                        'value' => set_value('account_identity', $account->identity),
                        'errorMessage' => !empty($error->account_identity) ? $error->account_identity : null,
                    ]) ?>
                </div>
                <div class="<?= $userAuth->isAdmin ? 'mb-5' : 'mb-8' ?>">
                    <?= view_cell('InputCell', [
                        'name' => 'account_identity_zone_id',
                        'label' => 'Zone Id',
                        'type' => 'number',
                        'placeholder' => '8521',
                        'value' => set_value('account_identity_zone_id', $account->identity_zone_id),
                        'errorMessage' => !empty($error->account_identity_zone_id) ? $error->account_identity_zone_id : null,
                    ]) ?>
                </div>

                <?php if ($userAuth->isAdmin): ?>
                <div class="pt-5 mt-2 border-t border-vulcan-800"></div>
                <?php if (strval($account->user->id) !== $userAuth->id): ?>
                <div class="mb-5">
                    <p class="block mb-2 text-sm font-medium text-white">Pemilik Akun</p>
                    <div class="flex flex-row items-center w-full mt-1">
                        <a class="flex flex-row items-center gap-2 border border-transparent text-sm transition-all duration-700 outline-none bg-vulcan-800 bg-clip-padding backdrop-filter backdrop-blur-sm bg-opacity-40 hover:bg-blue-500 hover:border-blue-600/50 hover:bg-opacity-20 p-2 pr-3 hover:py-2 hover:px-3 rounded-xl"
                           href="<?= url_to('user.detail', $account->user->username) ?>">
                            <span class="h-10 w-10 rounded-full">
                                <img class="h-10 w-10 rounded-full object-cover" src="<?= esc($account->user->photo) ?>" alt="<?= esc($account->user->name) ?>">
                            </span>
                            <span class="flex flex-col text-start ">
                                <span class="text-sm text-slate-200 font-semibold line-clamp-1 hover:line-clamp-none"><?= esc($account->user->name) ?></span>
                                <span class="text-xs text-slate-300">@<?= esc($account->user->username) ?></span>
                            </span>
                        </a>
                    </div>
                </div>
                <?php endif ?>
                <div class="mb-8">
                    <?= view_cell('InputCell', [
                        'name' => 'account_status',
                        'label' => 'Status Akun',
                        'type' => 'select',
                        'options' => [
                            [
                                'value' => 'verified',
                                'text' => 'Terverifikasi',
                            ],
                            [
                                'value' => 'unverified',
                                'text' => 'Tidak di Verifikasi',
                            ],
                            [
                                'value' => 'scam',
                                'text' => 'Palsu',
                            ],
                        ],
                        'mathParentSlug' => null,
                        'value' => set_value('account_status', $account->status),
                        'errorMessage' => !empty($error->account_status) ? $error->account_status : null,
                    ]) ?>
                </div>
                <?php endif ?>

                <?php if (!empty($error->global) || !empty($error->account_user) || !empty($error->account_status)||!empty($error->account_game)) : ?>
                <div class="mb-2 -mt-6 w-full">
                    <span class="text-xs text-red-400 font-medium ml-0.5">
                        <?= !empty($error->global) ? esc($error->global) : '' ?>
                        <?= !empty($error->account_user) ? esc($error->account_user) : '' ?>
                        <?= !empty($error->account_status) ? esc($error->account_status) : '' ?>
                        <?= !empty($error->account_game) ? esc($error->account_game) : '' ?>
                    </span>
                </div>
                <?php endif; ?>

                <button class="flex font-semibold h-10 w-full items-center justify-center space-x-2 rounded-md border px-4 text-sm transition-all focus:outline-none bg-blue-500 border-transparent bg-bg-blue-400/80 text-white hover:bg-blue-400/90 hover:border-blue-400 hover:text-white disabled:hover:bg-blue-400/80 disabled:border:bg-slate-400 disabled:opacity-80 disabled:cursor-wait"
                        type="submit">
                    <p>Simpan Perubahan</p>
                </button>
            </form>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
