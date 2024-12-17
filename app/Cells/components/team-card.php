 <div class="group/team-card p-2 pt-2.5 pb-3 transition-all duration-300 overflow-hidden rounded-xl md:rounded-2xl bg-vulcan-700 bg-opacity-50 shadow-lg border border-vulcan-700 hover:shadow-2xl">
     <div class="flex flex-col">
         <div class="flex flex-col w-auto mt-2 px-1 gap-0.5">
             <div class="flex flex-row items-center justify-between w-auto">
                 <span class="text-sm text-slate-300/90 font-medium">Nama Tim</span>
                 <span class="text-sm text-slate-200/90 font-semibold"><?= esc($team->name) ?></span>
             </div>
             <div class="flex flex-row items-center justify-between w-auto">
                 <span class="text-sm text-slate-300/90 font-medium">Status</span>
                 <span class="text-sm text-slate-300/90 font-semibold"><?= esc($team->status) ?></span>
             </div>
             <div class="flex flex-row items-center justify-between w-auto">
                 <span class="text-sm text-slate-300/90 font-medium">Max Pemain</span>
                 <span class="text-sm text-slate-300/90 font-semibold"><?= esc($team->game->max_player . " Orang") ?></span>
             </div>
             <div class="flex flex-col text-start w-full mt-2 mb-1">
                 <span class="text-sm text-slate-300/90 font-medium pb-1">Game</span>
                 <a href="<?= url_to("game.detail", $team->game->code) ?>" class="flex w-full transition-colors duration-500 items-center border text-sm rounded-lg md:rounded-xl outline-none shadow hover:shadow-xl overflow-hidden cursor-pointer z-10 <?= boolval($team->game->is_verified) ? "bg-vulcan-800 border-vulcan-700 hover:bg-vulcan-700 hover:border-vulcan-500/70" : "bg-red-800 bg-clip-padding backdrop-filter backdrop-blur-sm bg-opacity-30 border-red-500/40 hover:bg-red-700/40 hover:border-red-500/70" ?>">
                     <div class="flex flex-col w-full">
                         <div class="flex flex-row w-full h-full items-center">
                             <div class="w-auto h-full">
                                 <div class="flex h-full w-16 md:w-16 lg:w-16 p-[5px]">
                                     <div class="relative h-full w-full aspect-square overflow-hidden rounded-r-2xl rounded-lg md:rounded-xl">
                                         <div class="absolute top-0 left-0 bg-black/10 h-full w-full z-10"></div>
                                         <img class="h-full w-full object-cover z-0" src="<?= esc($team->game->image) ?>" alt="<?= esc($team->game->name) ?>">
                                     </div>
                                 </div>
                             </div>
                             <div class="flex flex-col w-full bg-gradient-to-br pr-2 pl-0.5 gap-0.5">
                                 <h2 class="text-sm truncate text-slate-300 font-semibold"><?= esc($team->game->name) ?></h2>
                                 <p class="text-xs line-clamp-2 text-slate-300/70 font-medium" style="line-height: 1.4;">
                                     <?= esc($team->game->description) ?>
                                 </p>
                             </div>
                         </div>
                         <?php if (!boolval($team->game->is_verified)) : ?>
                             <span class="px-2 text-xs pb-1 font-medium text-red-300 shadow">Game Belum di Verifikasi Admin</span>
                         <?php endif ?>
                     </div>
                 </a>
             </div>

             <?php if (auth()->isAdmin()) : ?>
                 <div class="flex flex-col w-full mt-2.5 pt-2 gap-1 border-t border-vulcan-700">
                     <span class="text-sm text-start text-slate-300/90 font-medium">Pembuat</span>
                     <a href="<?= url_to("user.detail", $team->creator->username) ?>" class="bg-vulcan-800 bg-clip-padding backdrop-filter backdrop-blur-sm bg-opacity-80 relative flex flex-col w-full border border-transparent text-sm transition-all duration-700 outline-none hover:bg-vulcan-600 hover:border-vulcan-600/80 hover:bg-opacity-40 rounded-lg">
                         <div class="flex flex-col w-full p-2 hover:py-2 hover:px-3 transition-all duration-700">
                             <div class="flex flex-row w-full gap-2 items-center">
                                 <div class="h-8 w-8 rounded-full">
                                     <img class="h-8 w-8 rounded-full object-cover" src="<?= $team->creator->photo ?>" alt="<?= $team->creator->name ?>">
                                 </div>
                                 <div class="flex flex-col text-start z-10 max-w-[80%]">
                                     <span class="text-sm text-slate-200 font-semibold truncate"><?= $team->creator->name ?></span>
                                     <span class="text-xs text-slate-300 -mt-0.5">@<?= $team->creator->username ?></span>
                                 </div>
                             </div>
                         </div>
                     </a>
                 </div>
             <?php endif ?>

             <?php if (!empty($team->members) && count($team->members) > 0) : ?>
                 <div class="flex flex-col w-full mt-2.5 pt-2 gap-1 border-t border-vulcan-700">
                     <span class="text-sm text-start text-slate-300/90 font-medium">Pemain</span>
                     <div class="flex flex-col w-full items-center gap-2">
                         <?php foreach ($team->members as $member) : ?>
                             <div aria-controls="toggle" toggle-show="false" toggle-expand-target="<?= "team-{$team->id}-member-{$member->id}" ?>" class="<?= $member->account->status !== "verified" ? ($member->account->status == "scam" ? "bg-red-500 bg-clip-padding backdrop-filter backdrop-blur-sm bg-opacity-20 pt-4" : "bg-orange-500 bg-clip-padding backdrop-filter backdrop-blur-sm bg-opacity-20 pt-4") : "bg-vulcan-800 bg-clip-padding backdrop-filter backdrop-blur-sm bg-opacity-80" ?> relative flex flex-col w-full border border-transparent text-sm transition-all duration-700 outline-none hover:bg-vulcan-600 hover:border-vulcan-600/80 hover:bg-opacity-40 rounded-lg">
                                 <div class="flex flex-col w-full p-2 pr-3 hover:py-2 hover:px-3 transition-all duration-700">
                                     <?php if ($member->account->status !== "verified") : ?>
                                         <span class="absolute z-0 text-xs top-0 left-0 rounded-tl-lg rounded-br-md py-0.5 px-2 <?= $member->account->status == "scam" ? "bg-red-500" : "bg-orange-500" ?> bg-clip-padding backdrop-filter backdrop-blur-sm bg-opacity-30 tracking-wide font-medium">
                                             <?= $member->account->status == "scam" ? "Terindikasi akun palsu" : "Belum diverifikasi admin" ?>
                                         </span>
                                     <?php endif ?>
                                     <?php if (intval($team->creator->id) == intval($member->account->user->id)) : ?>
                                         <span class="absolute z-0 text-xs top-0 right-0 rounded-tr-lg rounded-bl-md py-0.5 px-2 bg-sky-500 bg-clip-padding backdrop-filter backdrop-blur-sm bg-opacity-50 tracking-wide font-medium">
                                             Pembuat
                                         </span>
                                     <?php endif ?>
                                     <div class="flex flex-row w-full gap-2 items-center">
                                         <a href="<?= url_to("user.detail", $member->account->user->username) ?>" class="h-8 w-8 rounded-full">
                                             <img class="h-8 w-8 rounded-full object-cover" src="<?= $member->account->user->photo ?>" alt="<?= $member->account->user->name ?>">
                                         </a>
                                         <div class="flex flex-col text-start z-10 max-w-[80%]">
                                             <span class="text-sm text-slate-200 font-semibold truncate"><?= $member->account->user->name ?></span>
                                             <span class="text-xs text-slate-300 -mt-0.5">@<?= $member->account->user->username ?></span>
                                         </div>
                                     </div>
                                     <div toggle-expand="<?= "team-{$team->id}-member-{$member->id}" ?>" show-on-toggle="true" class="hidden flex-col px-1 text-start mt-2 py-1 border-t border-vulcan-600 transition-all duration-700">
                                         <div class="flex flex-col w-full mb-2">
                                             <div class="flex flex-row items-center justify-between w-full">
                                                 <span class="text-xs text-slate-300/80 font-medium">User Id</span>
                                                 <span class="text-xs text-slate-300/90 font-medium"><?= esc($member->account->identity) ?></span>
                                             </div>
                                             <?php if (!empty($member->account->identity_zone_id)) : ?>
                                                 <div class="flex flex-row items-center justify-between w-full">
                                                     <span class="text-xs text-slate-300/80 font-medium">Zone Id</span>
                                                     <span class="text-xs text-slate-300/90 font-medium"><?= esc($member->account->identity_zone_id) ?></span>
                                                 </div>
                                             <?php endif ?>
                                         </div>
                                         <div class="flex flex-col w-full">
                                             <span class="text-xs text-slate-300/80 font-medium">Hero</span>
                                             <button onclick="<?= !empty($member->hero_scraper) && !empty($member->hero_id) ? "window.location.href='/game/{$team->game->code}/hero/{$member->hero_id}'" : "" ?>" class="flex flex-row gap-2 items-center bg-vulcan-600 bg-opacity-70 px-1.5 py-0.5 rounded-md <?= !empty($member->hero_scraper) ? "cursor-pointer" : "cursor-default" ?>">
                                                 <?php if (!empty($member->hero_image)) : ?>
                                                     <div class="h-7 w-7 rounded-md">
                                                         <img class="h-7 w-7 rounded-md object-cover" src="<?= $member->hero_image ?>" alt="<?= $member->hero ?>">
                                                     </div>
                                                 <?php endif ?>
                                                 <div class="flex flex-col text-start">
                                                     <span class="text-xs text-slate-300 font-medium"><?= $member->hero ?></span>
                                                     <?php if (!empty($member->hero_role)) : ?>
                                                         <span class="text-[10px] -mt-1 text-slate-300/70 font-medium"><?= $member->hero_role ?></span>
                                                     <?php endif ?>
                                                 </div>
                                             </button>
                                         </div>
                                     </div>
                                 </div>
                             </div>
                         <?php endforeach ?>
                     </div>
                 </div>
             <?php endif ?>
         </div>
     </div>
     <?php if (!empty($team->creator->id) && intval($team->creator->id) == intval(auth()->user('id'))) : ?>
         <div class="flex flex-row justify-between mt-2.5 pt-2 pb-1 px-1 gap-2.5 border-t border-vulcan-700">
             <?php if ($team->status !== "archive") : ?>
                 <a href="<?= url_to("team.edit", $team->code) ?>" class="flex w-full items-center gap-1 py-1.5 px-2.5 justify-center text-blue-100 hover:text-white text-sm font-medium bg-blue-500 border border-transparent bg-opacity-30 hover:bg-opacity-70 active:transition-none active:duration-0 hover:shadow-md transition duration-300 rounded-md active:scale-95 cursor-pointer">
                     <i class="fa-solid fa-pen text-xs mr-0.5"></i>
                     Edit
                 </a>
             <?php endif ?>
             <?php if ($team->status == "matches") : ?>
                 <form class="flex w-full p-0 m-0 justify-center items-center" action="<?= url_to("team.archive",  $team->code) ?>" method="post">
                     <button type="submit" class="flex items-center gap-1 py-1.5 px-2.5 w-full justify-center text-vulcan-100 hover:text-white text-sm font-medium bg-vulcan-500 border border-transparent bg-opacity-30 hover:bg-opacity-70 active:transition-none active:duration-0 hover:shadow-md transition duration-300 rounded-md active:scale-95 cursor-pointer">
                         <i class="fa-solid fa-archive text-xs mr-0.5"></i>
                         Arsipkan
                     </button>
                 </form>
             <?php elseif ($team->status == "archive" || (($team->status == "draft" || $team->status == "recruite") && count($team->members) < 1)) : ?>
                 <form class="flex w-full p-0 m-0 justify-center items-center" action="<?= url_to("team.delete",  $team->code) ?>" method="post">
                     <button type="submit" class="flex items-center gap-1 py-1.5 px-2.5 w-full justify-center text-vulcan-100 hover:text-white text-sm font-medium bg-vulcan-500 border border-transparent bg-opacity-30 hover:bg-opacity-70 active:transition-none active:duration-0 hover:shadow-md transition duration-300 rounded-md active:scale-95 cursor-pointer">
                         <i class="fa-solid fa-trash text-xs mr-0.5"></i>
                         Hapus
                     </button>
                 </form>
             <?php endif ?>
         </div>
         <?php if ($team->status == 'recruite' && !$includeSelf) : ?>
             <div class="flex flex-row justify-between mt-2 pt-2 pb-1 px-1 gap-2.5 border-t border-vulcan-700">
                 <form class="flex w-full p-0 m-0 justify-center items-center" action="<?= url_to("team.join", $team->code) ?>" method="post">
                     <button type="submit" class="flex w-full items-center gap-1 py-1.5 px-2.5 justify-center text-blue-100 hover:text-white text-sm font-medium bg-blue-500 border border-transparent bg-opacity-30 hover:bg-opacity-70 active:transition-none active:duration-0 hover:shadow-md transition duration-300 rounded-md active:scale-95 cursor-pointer">
                         <i class="fa-solid fa-user-group text-xs mr-0.5 mb-1.5"></i>
                         Pilih Akun Game
                     </button>
                 </form>
             </div>
         <?php endif ?>
     <?php endif ?>
     <?php if (intval($team->creator->id) !== intval(auth()->user('id')) && count($team->members) > 0 && count($team->members) < $team->game->max_player && !$includeSelf) : ?>
         <?php if ($team->status == 'recruite' || ($team->status == 'recruite' && count($team->members) > $team->game->max_player)) : ?>
             <div class="flex flex-row justify-between mt-2.5 pt-2 pb-1 px-1 gap-2.5 border-t border-vulcan-700">
                 <?php if ($team->status == 'recruite') : ?>
                     <a href="<?= url_to("team.join", $team->code) ?>" class="flex w-full items-center gap-1 py-1.5 px-2.5 justify-center text-blue-100 hover:text-white text-sm font-medium bg-blue-500 border border-transparent bg-opacity-30 hover:bg-opacity-70 active:transition-none active:duration-0 hover:shadow-md transition duration-300 rounded-md active:scale-95 cursor-pointer">
                         <i class="fa-solid fa-user-group text-xs mr-0.5"></i>
                         Gabung
                     </a>
                 <?php elseif ($team->status == 'recruite' && count($team->members) > $team->game->max_player) : ?>
                     <span class="text-xs font-medium text-slate-300/80">Tim Penuh</span>
                 <?php endif ?>
             </div>
         <?php endif ?>
     <?php elseif ($team->status !== 'archive' && $includeSelf && !empty($includeSelfAccountId)) : ?>
         <form action="<?= url_to("team.leave", $team->code, $includeSelfAccountId) ?>" method="post" class="flex flex-row justify-between mt-2.5 pt-2 pb-1 px-1 gap-2.5 border-t border-vulcan-700">
             <button type="submit" class="flex w-full items-center gap-1 py-1.5 px-2.5 justify-center text-blue-100 hover:text-white text-sm font-medium bg-red-500 border border-transparent bg-opacity-30 hover:bg-opacity-70 active:transition-none active:duration-0 hover:shadow-md transition duration-300 rounded-md active:scale-95 cursor-pointer">
                 <i class="fa-solid fa-right-from-bracket text-xs mr-0.5"></i>
                 Keluar Tim
             </button>
         </form>
     <?php endif ?>
 </div>