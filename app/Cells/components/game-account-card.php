 <div class="group/game-account-card p-2 pt-2.5 transition-all duration-300 overflow-hidden rounded-xl md:rounded-2xl bg-vulcan-700 bg-opacity-50 shadow-lg border border-vulcan-700 hover:shadow-2xl">
     <div class="flex flex-col">
         <a href="<?= url_to("game.detail", $account->game->code) ?>" class="flex w-full transition-colors duration-500 items-center border text-sm rounded-lg md:rounded-xl outline-none shadow hover:shadow-xl overflow-hidden cursor-pointer z-10 <?= boolval($account->game->is_verified) ? "bg-vulcan-800 border-vulcan-700 hover:bg-vulcan-700 hover:border-vulcan-500/70" : "bg-red-800 bg-clip-padding backdrop-filter backdrop-blur-sm bg-opacity-30 border-red-500/40 hover:bg-red-700/40 hover:border-red-500/70" ?>">
             <div class="flex flex-col w-full">
                 <div class="flex flex-row w-full h-full items-center">
                     <div class="w-auto h-full">
                         <div class="flex h-full w-16 md:w-16 lg:w-16 p-[5px]">
                             <div class="relative h-full w-full aspect-square overflow-hidden rounded-r-2xl rounded-lg md:rounded-xl">
                                 <div class="absolute top-0 left-0 bg-black/10 h-full w-full z-10"></div>
                                 <img class="h-full w-full object-cover z-0" src="<?= esc($account->game->image) ?>" alt="<?= esc($account->game->name) ?>">
                             </div>
                         </div>
                     </div>
                     <div class="flex flex-col w-full bg-gradient-to-br pr-2 pl-0.5 gap-0.5">
                         <h2 class="text-sm truncate text-slate-300 font-semibold"><?= esc($account->game->name) ?></h2>
                         <p class="text-xs line-clamp-2 text-slate-300/70 font-medium" style="line-height: 1.4;">
                             <?= esc($account->game->description) ?>
                         </p>
                     </div>
                 </div>
                 <?php if (!boolval($account->game->is_verified)) : ?>
                     <span class="px-2 text-xs pb-1 font-medium text-red-300 shadow">Game Belum di Verifikasi Admin</span>
                 <?php endif ?>
             </div>
         </a>
         <div class="flex flex-col w-auto mt-2 px-1 gap-0.5">
             <div class="flex flex-row items-center justify-between w-auto">
                 <span class="text-sm text-slate-300/90 font-medium">User Id</span>
                 <span class="text-sm text-slate-300/90 font-semibold"><?= esc($account->identity) ?></span>
             </div>
             <div class="flex flex-row items-center justify-between w-auto">
                 <span class="text-sm text-slate-300/90 font-medium">Zone Id</span>
                 <span class="text-sm text-slate-300/90 <?= empty($account->identity_zone_id) ? "font-medium" : "font-semibold" ?>">
                     <?= (!empty($account->identity_zone_id)) ? esc($account->identity_zone_id) : "-" ?></span>
             </div>
             <div class="flex flex-row items-center justify-between w-auto">
                 <span class="text-sm text-slate-300/90 font-medium">Status Akun</span>
                 <span class="text-sm <?= esc($accountStatusColor) ?> font-semibold"><?= esc($accountStatus) ?></span>
             </div>
         </div>
         <?php if (strval($account->user->id) !== auth()->user("id") && auth()->isAdmin()) : ?>
             <div class="flex flex-row items-center w-full pt-2">
                 <a href="<?= url_to("user.detail", $account->game->creator->username) ?>" class="flex flex-row w-full items-center gap-2 border border-transparent text-sm transition-all duration-700 outline-none bg-vulcan-800 bg-clip-padding backdrop-filter backdrop-blur-sm bg-opacity-40 hover:bg-blue-500 hover:border-blue-600/50 hover:bg-opacity-20 p-2 pr-3 hover:py-2 hover:px-3 rounded-lg">
                     <span class="h-8 w-8 rounded-full">
                         <img class="h-8 w-8 rounded-full object-cover" src="<?= $account->game->creator->photo ?>" alt="<?= $account->game->creator->name ?>">
                     </span>
                     <span class="flex flex-col text-start ">
                         <span class="text-sm text-slate-200 font-semibold line-clamp-1 hover:line-clamp-none"><?= $account->game->creator->name ?></span>
                         <span class="text-xs text-slate-300">@<?= $account->game->creator->username ?></span>
                     </span>
                 </a>
             </div>
         <?php endif ?>
     </div>
     <?php if (!empty($account->identity)) : ?>
         <div class="flex flex-row justify-between mt-2.5 pt-2 pb-1 px-1 gap-2.5 border-t border-vulcan-700">
             <a href="<?= url_to("game.account.edit", $account->game->code, $account->identity) ?>" class="flex w-full items-center gap-1 py-2 md:py-1 px-2.5 justify-center text-blue-100 hover:text-white text-sm font-medium bg-blue-500 border border-transparent bg-opacity-30 hover:bg-opacity-70 active:transition-none active:duration-0 hover:shadow-md transition duration-300 rounded-md active:scale-95 cursor-pointer">
                 <i class="fa-solid fa-pen text-xs"></i>
                 Edit
             </a>
             <form class="flex w-full p-0 m-0 justify-center items-center" action="<?= url_to("game.account.delete",  $account->game->code, $account->identity) ?>" method="post">
                 <button type="submit" class="flex items-center gap-1 py-2 md:py-1 px-2.5 w-full justify-center text-rose-100 hover:text-white text-sm font-medium bg-rose-500 border border-transparent bg-opacity-30 hover:bg-opacity-70 active:transition-none active:duration-0 hover:shadow-md transition duration-300 rounded-md active:scale-95 cursor-pointer">
                     <i class="fa-solid fa-trash text-xs"></i>
                     Hapus
                 </button>
             </form>
             <?php if ($account->status !== "verified" && auth()->isAdmin()) : ?>
                 <form class="flex w-full p-0 m-0 justify-center items-center" action="<?= url_to("game.account.verify", $account->game->code, $account->identity) ?>" method="post">
                     <button type="submit" class="flex items-center gap-1 py-2 md:py-1 px-2.5 w-full justify-center text-green-100 hover:text-white text-sm font-medium bg-green-500 border border-transparent bg-opacity-30 hover:bg-opacity-70 active:transition-none active:duration-0 hover:shadow-md transition duration-300 rounded-md active:scale-95 cursor-pointer">
                         <i class="fa-solid fa-check text-sm"></i>
                         Verifikasi
                     </button>
                 </form>
             <?php endif ?>
         </div>
     <?php endif ?>
 </div>