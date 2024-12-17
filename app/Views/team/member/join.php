<?= $this->extend('layouts/layout') ?>

<?= $this->section('content') ?>
<div class="w-full relative">
    <div class="flex w-full justify-center">
        <div class="flex flex-col w-full md:max-w-xl bg-slate-900 border border-slate-800 rounded-xl shadow-lg shadow-elephant-800/10">
            <form class="flex flex-col w-full px-4 py-6 md:px-8 md:pt-8 md:pb-10" action="<?= url_to('team.join', $team->code) ?>" method="post"
                  accept-charset="utf-8">
                <input id="team_member_team" name="team_member_team" type="hidden" value="<?= set_value('team_member_team', $team->id) ?>">

                <?php if(empty($heroScraper)): ?>
                <input id="team_member_hero_id" name="team_member_hero_id" type="hidden" value="<?= set_value('team_member_hero_id', '') ?>">
                <input id="team_member_hero_image" name="team_member_hero_image" type="hidden" value="<?= set_value('team_member_hero_image', '') ?>">
                <?php endif ?>

                <div class="mb-5">
                    <?= view_cell('InputGameCell', [
                        'label' => 'Game',
                        'value' => $team->game->id,
                        'disable' => true,
                    ]) ?>
                </div>
                <?php if (intval($team->creator->id) !== intval($userAuth->id)): ?>
                <div class="mb-5">
                    <p class="block mb-2 text-sm font-medium text-white">Pembuat Tim</p>
                    <div class="flex flex-row items-center w-full mt-1">
                        <a class="flex flex-row w-full items-center gap-2 border border-transparent text-sm transition-all duration-700 outline-none bg-vulcan-800 bg-clip-padding backdrop-filter backdrop-blur-sm bg-opacity-40 hover:bg-blue-500 hover:border-blue-600/50 hover:bg-opacity-20 p-2 pr-3 hover:py-2 hover:px-3 rounded-xl"
                           href="<?= url_to('user.detail', $team->creator->username) ?>">
                            <span class="h-10 w-10 rounded-full">
                                <img class="h-10 w-10 rounded-full object-cover" src="<?= esc($team->creator->photo) ?>" alt="<?= esc($team->creator->name) ?>">
                            </span>
                            <span class="flex flex-col text-start">
                                <span class="text-sm text-slate-200 font-semibold truncate"><?= esc($team->creator->name) ?></span>
                                <span class="text-xs text-slate-300">@<?= esc($team->creator->username) ?></span>
                            </span>
                        </a>
                    </div>
                </div>
                <?php endif ?>
                <?php if (count($team->members) > 0): ?>
                <div class="mb-5">
                    <p class="block mb-2 text-sm font-medium text-white">Anggota Tim</p>
                    <div class="flex flex-col items-center w-full mt-1 gap-2">
                        <?php foreach ($team->members as $member): ?>
                        <div
                             class="flex flex-col group/team-member w-full border border-transparent text-sm transition-all duration-1000 outline-none bg-vulcan-800 bg-clip-padding backdrop-filter backdrop-blur-sm bg-opacity-40 hover:bg-blue-500 hover:border-blue-600/50 hover:bg-opacity-20 p-2 pr-3 hover:py-2 hover:px-3 rounded-xl overflow-hidden">
                            <div class="flex flex-row items-center gap-2 w-full z-10">
                                <a class="h-10 w-10 rounded-full" href="<?= url_to('user.detail', $member->account->user->username) ?>">
                                    <img class="h-10 w-10 rounded-full object-cover" src="<?= esc($member->account->user->photo) ?>"
                                         alt="<?= esc($member->account->user->name) ?>">
                                </a>
                                <div class="flex flex-col text-start">
                                    <a class="text-sm text-slate-200 font-semibold truncate"
                                       href="<?= url_to('user.detail', $member->account->user->username) ?>"><?= esc($member->account->user->name) ?></a>
                                    <a class="text-xs text-slate-300"
                                       href="<?= url_to('user.detail', $member->account->user->username) ?>">@<?= esc($member->account->user->username) ?></a>
                                </div>
                            </div>
                            <div class="flex w-full pt-1.5 mt-2.5 border-t border-vulcan-800">
                                <div class="flex flex-row items-center gap-2 w-full px-1">
                                    <?php if(!empty($member->hero_image)): ?>
                                    <span class="h-8 w-8 rounded-md">
                                        <img class="h-8 w-8 rounded-md object-cover" src="<?= esc($member->hero_image) ?>" alt="<?= esc($member->hero) ?>">
                                    </span>
                                    <?php endif ?>
                                    <div class="flex flex-col text-start">
                                        <?php if(!empty($member->hero)): ?>
                                        <span class="text-[12px] text-slate-200 font-semibold truncate"><?= esc($member->hero) ?></span>
                                        <?php endif ?>
                                        <?php if(!empty($member->hero_role)): ?>
                                        <span class="text-[10px] text-slate-300 -mt-1"><?= esc($member->hero_role) ?></span>
                                        <?php endif ?>
                                    </div>
                                </div>
                            </div>
                            <div
                                 class="flex flex-col w-full transition-all duration-700 h-0 -z-10 -translate-y-10 opacity-0 group-focus/team-member:z-0 group-focus/team-member:h-auto group-focus/team-member:opacity-100 group-focus/team-member:translate-y-0 group-hover/team-member:z-0 group-hover/team-member:h-auto group-hover/team-member:opacity-100 group-hover/team-member:translate-y-0">
                                <div class="flex w-full pt-1.5 mt-2.5 ">
                                    <div class="flex flex-row justify-between items-center gap-2 w-full px-1">
                                        <div class="flex flex-col text-start">
                                            <span class="text-[10px] text-slate-300 -mb-1">User Id</span>
                                            <span class="text-[12px] text-slate-200 font-semibold truncate"><?= esc($member->account->identity) ?></span>
                                        </div>
                                        <div class="flex flex-col text-end">
                                            <span class="text-[10px] text-slate-300 -mb-1">Zone Id</span>
                                            <span
                                                  class="text-[12px] text-slate-200 font-semibold truncate"><?= esc($member->account->identity_zone_id) ?></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php endforeach ?>
                    </div>
                </div>
                <?php endif ?>

                <div class="mb-5">
                    <?= view_cell('InputGameAccountCell', [
                        'name' => 'team_member_account',
                        'label' => 'Pilih Akun',
                        'placeholder' => 'Pilih akun lainnya?',
                        'value' => set_value('team_member_account', session()->getFlashdata('connect_game_account_ref')),
                        'errorMessage' => !empty($error->team_member_account) ? $error->team_member_account : null,
                        'accounts' => $accounts,
                    ]) ?>
                </div>

                <?php if (!empty($heroScraper)): ?>
                <div class="mb-8">
                    <?= view_cell('InputGameHeroCell', [
                        'name' => [
                            'hero' => 'team_member_hero',
                            'hero_id' => 'team_member_hero_id',
                            'hero_role' => 'team_member_hero_role',
                            'hero_image' => 'team_member_hero_image',
                        ],
                        'label' => 'Pilih Hero',
                        'placeholder' => 'Pilih hero lainnya?',
                        'value' => [
                            'hero' => set_value('team_member_hero'),
                            'hero_id' => set_value('team_member_hero_id'),
                            'hero_role' => set_value('team_member_hero_role'),
                            'hero_image' => set_value('team_member_hero_image'),
                        ],
                        'errorMessage' => !empty($error->team_member_hero) ? $error->team_member_hero : null,
                        'scraper' => $heroScraper,
                    ]) ?>
                </div>
                <?php else: ?>
                <div class="mb-5">
                    <?= view_cell('InputCell', [
                        'name' => 'team_member_hero',
                        'label' => 'Hero',
                        'type' => 'text',
                        'placeholder' => 'Balmond',
                        'value' => set_value('team_member_hero'),
                        'errorMessage' => !empty($error->team_member_hero) ? $error->team_member_hero : null,
                    ]) ?>
                </div>
                <div class="mb-8">
                    <?= view_cell('InputCell', [
                        'name' => 'team_member_hero_role',
                        'label' => 'Hero Role',
                        'type' => 'text',
                        'placeholder' => 'Fighter',
                        'value' => set_value('team_member_hero_role'),
                        'errorMessage' => !empty($error->team_member_hero_role) ? $error->team_member_hero_role : null,
                    ]) ?>
                </div>
                <?php endif ?>

                <?php if (!empty($error->global) || !empty($error->team_member_team) || !empty($error->team_member_hero_id) || !empty($error->team_member_hero_role) || !empty($error->team_member_hero_image)) : ?>
                <div class="mb-2 -mt-6 w-full">
                    <span class="text-xs text-red-400 font-medium ml-0.5">
                        <?= !empty($error->global) ? esc($error->global) : '' ?>
                        <?= !empty($error->team_member_team) ? esc($error->team_member_team) : '' ?>
                        <?= !empty($error->team_member_hero_id) && !empty($heroScraper) ? esc($error->team_member_hero_id) : '' ?>
                        <?= !empty($error->team_member_hero_role) && !empty($heroScraper) ? esc($error->team_member_hero_role) : '' ?>
                        <?= !empty($error->team_member_hero_image) && !empty($heroScraper) ? esc($error->team_member_hero_image) : '' ?>
                    </span>
                </div>
                <?php endif; ?>

                <button class="flex font-semibold h-10 w-full items-center justify-center space-x-2 rounded-md border px-4 text-sm transition-all focus:outline-none bg-blue-500 border-transparent bg-bg-blue-400/80 text-white hover:bg-blue-400/90 hover:border-blue-400 hover:text-white disabled:hover:bg-blue-400/80 disabled:border:bg-slate-400 disabled:opacity-80 disabled:cursor-wait"
                        type="submit">
                    <p>Gabung ke Tim</p>
                </button>
            </form>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
