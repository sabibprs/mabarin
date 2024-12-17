<?= $this->extend('layouts/layout') ?>

<?= $this->section('content') ?>
<div class="w-full relative">
    <div class="flex w-full justify-center">
        <div class="flex flex-col w-full md:max-w-2xl bg-slate-900 border border-slate-800 rounded-xl shadow-lg shadow-elephant-800/10">
            <form class="flex flex-col w-full  px-4 py-6 md:px-8 md:pt-8 md:pb-10" action="<?= url_to('game.account.add') ?>" method="post" accept-charset="utf-8">
                <input id="account_user" name="account_user" type="hidden" value="<?= set_value('account_user', $userAuth->id) ?>">
                <input id="account_status" name="account_status" type="hidden"
                       value="<?= strval(set_value('account_status', auth()->isAdmin()) ? 'verified' : 'unverified') ?>">
                <div class="mb-5">
                    <?= view_cell('InputGameCell', [
                        'name' => 'account_game',
                        'label' => 'Game',
                        'placeholder' => 'Mau pilih game lainnya? Tenang semua ada kok!',
                        'value' => set_value('account_game', session()->getFlashdata('connect_game_account_ref')),
                        'errorMessage' => !empty($error->account_game) ? $error->account_game : null,
                    ]) ?>
                </div>
                <div class="mb-5">
                    <?= view_cell('InputCell', [
                        'name' => 'account_identity',
                        'label' => 'User Id',
                        'type' => 'number',
                        'placeholder' => '633699592',
                        'value' => set_value('account_identity'),
                        'errorMessage' => !empty($error->account_identity) ? $error->account_identity : null,
                    ]) ?>
                </div>
                <div class="mb-8">
                    <?= view_cell('InputCell', [
                        'name' => 'account_identity_zone_id',
                        'label' => 'Zone Id',
                        'type' => 'number',
                        'placeholder' => '8521',
                        'value' => set_value('account_identity_zone_id'),
                        'errorMessage' => !empty($error->account_identity_zone_id) ? $error->account_identity_zone_id : null,
                    ]) ?>
                </div>

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
                    <p>Tambahkan Akun Ini</p>
                </button>
            </form>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
