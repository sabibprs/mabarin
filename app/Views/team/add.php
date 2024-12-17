<?= $this->extend('layouts/layout') ?>

<?= $this->section('content') ?>
<div class="w-full relative">
    <div class="flex w-full justify-center">
        <div class="flex flex-col w-full md:max-w-2xl bg-slate-900 border border-slate-800 rounded-xl shadow-lg shadow-elephant-800/10">
            <form class="flex flex-col w-full  px-4 py-6 md:px-8 md:pt-8 md:pb-10" action="<?= url_to('team.add') ?>" method="post" accept-charset="utf-8">
                <input id="team_creator" name="team_creator" type="hidden" value="<?= set_value('team_creator', $userAuth->id) ?>">
                <div class="mb-5">
                    <?= view_cell('InputGameCell', [
                        'name' => 'team_game',
                        'label' => 'Game',
                        'placeholder' => 'Pilih game yang akan dimainkan untuk tim ini!',
                        'value' => set_value('team_game'),
                        'errorMessage' => !empty($error->team_game) ? $error->team_game : null,
                    ]) ?>
                </div>
                <div class="mb-5">
                    <?= view_cell('InputCell', [
                        'name' => 'team_name',
                        'label' => 'Nama Tim',
                        'type' => 'text',
                        'placeholder' => 'Bigetron Esports',
                        'value' => set_value('team_name'),
                        'errorMessage' => !empty($error->team_name) ? $error->team_name : null,
                    ]) ?>
                </div>
                <div class="mb-5">
                    <?= view_cell('InputCell', [
                        'name' => 'team_code',
                        'label' => 'Kode Tim',
                        'type' => 'text',
                        'placeholder' => 'bigetron-esports',
                        'mathParentSlug' => 'team_name',
                        'value' => set_value('team_code'),
                        'errorMessage' => !empty($error->team_code) ? $error->team_code : null,
                    ]) ?>
                </div>
                <div class="mb-8">
                    <?= view_cell('InputCell', [
                        'name' => 'team_status',
                        'label' => 'Status Tim',
                        'type' => 'select',
                        'options' => [
                            [
                                'value' => 'draft',
                                'text' => 'Draft',
                            ],
                            [
                                'value' => 'recruite',
                                'text' => 'Publish',
                            ],
                        ],
                        'mathParentSlug' => null,
                        'value' => set_value('team_status'),
                        'errorMessage' => !empty($error->team_status) ? $error->team_status : null,
                    ]) ?>
                </div>

                <?php if (!empty($error->global) || !empty($error->team_creator) ||!empty($error->team_game)) : ?>
                <div class="mb-2 -mt-6 w-full">
                    <span class="text-xs text-red-400 font-medium ml-0.5">
                        <?= !empty($error->global) ? esc($error->global) : '' ?>
                        <?= !empty($error->team_creator) ? esc($error->team_creator) : '' ?>
                        <?= !empty($error->team_game) ? esc($error->team_game) : '' ?>
                    </span>
                </div>
                <?php endif; ?>

                <button class="flex font-semibold h-10 w-full items-center justify-center space-x-2 rounded-md border px-4 text-sm transition-all focus:outline-none bg-blue-500 border-transparent bg-bg-blue-400/80 text-white hover:bg-blue-400/90 hover:border-blue-400 hover:text-white disabled:hover:bg-blue-400/80 disabled:border:bg-slate-400 disabled:opacity-80 disabled:cursor-wait"
                        type="submit">
                    <p>Buat Tim</p>
                </button>
            </form>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
