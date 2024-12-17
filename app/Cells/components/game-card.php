<div class="group/game-card transition-all duration-300 overflow-hidden rounded-xl sm:rounded-2xl md:rounded-3xl bg-vulcan-800 bg-opacity-50 shadow-lg border border-vulcan-700 hover:shadow-2xl">
    <div class="flex items-center relative aspect-square">
        <div class="absolute h-full w-full bg-black/30 z-10 opacity-0 group-hover/game-card:opacity-100 transition-all duration-700"></div>
        <img class="object-cover w-full h-full" src="<?= $game->image ?>" alt="<?= $game->name ?>">
        <?php if (auth()->isLoggedIn()) : ?>
            <?php if ((intval($game->creator->id) == intval(auth()->user("id"))) || ($game->is_verified && auth()->isAdmin())) : ?>
                <a href="<?= url_to('game.edit', $game->code) ?>" class="absolute top-0 left-0 z-20 text-sm text-center py-1.5 px-5 font-medium rounded-br-xl transition focus:outline-none bg-sky-600 bg-clip-padding backdrop-filter backdrop-blur-lg bg-opacity-50 group-hover/game-card:bg-opacity-90 text-slate-200 hover:bg-sky-500 hover:border-sky-500 hover:text-white cursor-pointer shadow-lg">
                    Edit
                </a>
            <?php endif ?>
            <?php if ((intval($game->creator->id) == intval(auth()->user("id")))) : ?>
                <form action="<?= url_to('game.delete', $game->code) ?>" method="POST">
                    <button type="submit" class="absolute <?= (!$game->is_verified && auth()->isAdmin()) ? "top-9" : "top-0" ?> right-0 z-20 text-sm text-center py-1.5 px-5 font-medium rounded-bl-xl transition focus:outline-none bg-pink-600 bg-clip-padding backdrop-filter backdrop-blur-sm bg-opacity-50 group-hover/game-card:bg-opacity-90 text-slate-200 hover:bg-pink-500 hover:border-pink-500 hover:text-white cursor-pointer shadow-lg">
                        Hapus
                    </button>
                </form>
            <?php endif ?>
        <?php endif ?>

        <?php if (!$game->is_verified && auth()->isUser()) : ?>
            <span class="absolute <?= intval($game->creator->id) == intval(auth()->user("id")) ? "top-10" : "top-0" ?> left-0 z-20 text-sm text-center py-1.5 px-3 font-medium rounded-br-xl transition focus:outline-none bg-orange-600 bg-clip-padding backdrop-filter backdrop-blur-sm bg-opacity-50 group-hover/game-card:bg-opacity-90 text-slate-200 hover:bg-orange-500 hover:border-orange-500 hover:text-white shadow-lg">
                Belum di Verifikasi Admin
            </span>
        <?php endif ?>
        <?php if (!$game->is_verified && auth()->isAdmin()) : ?>
            <a href="<?= url_to('game.verify', $game->code) ?>" class="absolute top-0 rounded-bl-xl right-0 z-20 text-sm text-center py-1.5 px-3 font-medium transition focus:outline-none bg-purple-600 bg-clip-padding backdrop-filter backdrop-blur-sm bg-opacity-50 group-hover/game-card:bg-opacity-90 text-slate-200 hover:bg-purple-500 hover:border-purple-500 hover:text-white cursor-pointer shadow-lg">
                Perlu Verifikasi
            </a>
        <?php endif ?>
    </div>
    <div class="flex flex-col w-full bg-vulcan-800 px-2 md:px-3 py-2 md:py-3 border-t h-full border-vulcan-600">
        <div>
            <p class="text-base md:text-lg line-clamp-1 hover:line-clamp-none text-slate-100 font-medium"><?= $game->name ?></p>
            <div class="flex w-full my-2 border-t border-vulcan-500/60"></div>
            <span class="text-sm transition duration-700 line-clamp-3 hover:line-clamp-none text-slate-200"><?= $game->description ?></span>
        </div>
        <div class="flex flex-col w-full mt-2">
            <div class="flex flex-row items-center w-full gap-1.5">
                <span class="text-sm text-slate-400">Max Pemain :</span>
                <span class="text-sm text-slate-400 font-semibold"><?= $game->max_player ?> Orang</span>
            </div>
            <div class="flex flex-row items-center w-full mt-2">
                <a href="<?= url_to("user.detail", esc($game->creator->username)) ?>" class="flex flex-row items-center gap-2 border-2 border-transparent text-sm transition outline-none">
                    <span class="h-7 w-7 rounded-full">
                        <img class="h-7 w-7 rounded-full object-cover" src="<?= esc($game->creator->photo) ?>" alt="<?= esc($game->creator->name) ?>">
                    </span>
                    <span class="flex flex-col text-start">
                        <span class="text-sm text-slate-200 font-semibold line-clamp-1 hover:line-clamp-none"><?= esc($game->creator->name) ?></span>
                        <span class="text-xs text-slate-300 -mt-1">@<?= esc($game->creator->username) ?></span>
                    </span>
                </a>
            </div>
        </div>
        <div class="flex flex-col lg:flex-row w-full mt-4 items-center justify-between gap-y-1.5">
            <a href="<?= url_to("game.detail", $game->code) ?>" class="text-sm text-center w-full lg:w-auto py-1.5 px-4 font-medium rounded-md border transition focus:outline-none bg-vulcan-600/50 border-transparent bg-bg-vulcan-400/80 text-slate-200 hover:bg-vulcan-500 hover:border-vulcan-500 hover:text-white cursor-pointer">
                Detail
            </a>
            <a href="<?= url_to("team.add", $game->code) ?>" class="text-sm text-center w-full lg:w-auto py-1.5 px-4 font-medium rounded-md border transition focus:outline-none bg-vulcan-600 border-transparent bg-bg-vulcan-400/80 text-slate-200 hover:bg-vulcan-500 hover:border-vulcan-500 hover:text-white cursor-pointer">
                Buat Team
            </a>
        </div>
    </div>
</div>