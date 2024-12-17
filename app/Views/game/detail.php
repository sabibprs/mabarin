<?= $this->extend('layouts/layout') ?>

<?= $this->section('content') ?>
<div class="w-full relative">
    <div class="flex w-full justify-center">
        <div class="flex flex-col-reverse lg:flex-row w-full bg-slate-900 border border-slate-800 rounded-xl shadow-lg shadow-elephant-800/10">
            <div class="flex flex-col w-full lg:w-1/2 px-4 py-6 md:px-6 md:py-8">
                <div class="mb-5">
                    <?= view_cell('InputCell', [
                        'label' => 'Nama Game',
                        'type' => 'text',
                        'value' => esc($game->name),
                        'disable' => true,
                    ]) ?>
                </div>
                <div class="mb-5">
                    <?= view_cell('InputCell', [
                        'label' => 'Kode Game',
                        'type' => 'text',
                        'value' => esc($game->code),
                        'disable' => true,
                    ]) ?>
                </div>
                <div class="mb-5">
                    <?= view_cell('InputCell', [
                        'label' => 'Deskripsi Game',
                        'type' => 'textarea',
                        'rows' => 5,
                        'value' => esc($game->description),
                    ]) ?>
                </div>
                <div class="mb-5">
                    <?= view_cell('InputCell', [
                        'label' => 'Maksimal Pemain',
                        'type' => 'text',
                        'value' => esc($game->max_player),
                        'disable' => true,
                    ]) ?>
                </div>
                <div class="mb-5">
                    <?= view_cell('InputCell', [
                        'label' => 'Status Verifikasi',
                        'type' => 'text',
                        'value' => esc($game->is_verified ? 'Terverifikasi' : 'Belum di Verifikasi'),
                        'disable' => true,
                    ]) ?>
                </div>
                <div class="mb-5">
                    <?= view_cell('InputCell', [
                        'label' => 'Total Akun Game',
                        'type' => 'text',
                        'value' => esc($game->total_accounts ? $game->total_accounts . ' Akun' : 'Belum ada akun dibawah game ini.'),
                        'disable' => true,
                    ]) ?>
                </div>
                <div class="mb-5">
                    <?= view_cell('InputCell', [
                        'label' => 'Dibuat Pada',
                        'type' => 'text',
                        'value' => readableTimestamp($game->created_at),
                        'disable' => true,
                    ]) ?>
                </div>
                <div class="mb-5">
                    <?= view_cell('InputCell', [
                        'label' => 'Diedit Pada',
                        'type' => 'text',
                        'value' => readableTimestamp($game->updated_at),
                        'disable' => true,
                    ]) ?>
                </div>
            </div>
            <div
                 class="group/upload-image relative transition-all duration-700 flex w-full aspect-square md:aspect-video lg:h-auto lg:w-1/2 rounded-b-xl rounded-t-2xl md:rounded-t-2xl border-b lg:border-l lg:border-t-0 border-slate-700 lg:border-slate-800 lg:rounded-none lg:rounded-r-xl lg:rounded-l-3xl bg-elephant-800 bg-opacity-10 opacity-80 bg-center object-cover overflow-hidden">
                <img class="absolute object-cover h-full w-full" id="preview-game-image" src="<?= esc($game->image) ?>" alt="<?= esc($game->name) ?>">
                <div class="relative w-full h-full">
                    <div class="absolute w-full h-full group-hover/upload-image:bg-black/50 transition-colors duration-700">
                        <div class="absolute flex justify-center w-[70%] top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 ">
                            <div
                                 class="flex flex-col w-full gap-2 transition-opacity duration-700 text-white bg-vulcan-600 border border-vulcan-500 bg-clip-padding backdrop-filter backdrop-blur-sm bg-opacity-70 rounded-xl p-4 md:p-8 outline-none ring-0 opacity-100">
                                <p class="text-xs md:text-base text-center font-semibold">Pembuat Game</p>
                                <div class="flex flex-row items-center w-full mt-1">
                                    <a class="flex flex-row w-full items-center gap-2 border border-vulcan-700/80 text-sm transition-all duration-700 outline-none bg-vulcan-700 bg-clip-padding backdrop-filter backdrop-blur-sm bg-opacity-40 hover:bg-blue-500 hover:border-blue-500/80 hover:bg-opacity-30 p-2 pr-3 hover:py-2 hover:px-3 rounded-xl"
                                       href="<?= url_to('user.detail', esc($game->creator->username)) ?>">
                                        <span class="h-14 w-14 rounded-full">
                                            <img class="h-14 w-14 rounded-full object-cover" src="<?= esc($game->creator->photo) ?>"
                                                 alt="<?= esc($game->creator->name) ?>">
                                        </span>
                                        <span class="flex flex-col text-start">
                                            <span class="text-base md:text-lg tracking-wide text-white font-semibold"><?= esc($game->creator->name) ?></span>
                                            <span class="text-sm md:text-base text-slate-200 md:-mt-1.5">@<?= esc($game->creator->username) ?></span>
                                        </span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
