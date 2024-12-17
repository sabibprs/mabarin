 <?= $this->extend('layouts/layout') ?>

 <?= $this->section('content') ?>
 <div class="w-full relative">
     <div class="mt-4 md:mt-0 md:mb-6">
         <a class="text-sm text-center w-auto py-2 md:py-1.5 px-4 font-medium rounded-md border transition focus:outline-none bg-vulcan-600 border-transparent bg-bg-vulcan-400/80 text-slate-200 hover:bg-vulcan-500 hover:border-vulcan-500 hover:text-white cursor-pointer"
            href="<?= url_to('game.account.add') ?>">
             <?php if (!empty($accounts) && count($accounts) >= 1) : ?>
             <span class="inline">
                 <i class="fa-solid fa-plus mr-0.5"></i>
                 Tambah
             </span class="inline">
             <?php else : ?>
             <span class="inline">
                 <i class="fa-solid fa-link mr-0.5"></i>
                 Koneksikan
             </span>
             <?php endif ?>
             <span class="inline">Akun Game</span>
         </a>
     </div>

     <div class="flex flex-col w-full mt-8 sm:mt-3 md:mt-4 gap-8 md:gap-12">
         <div class="flex flex-col w-full">
             <h2 class="text-lg font-medium leading-6 text-slate-100">Akun game terhubung</h2>
             <div class="mt-4 grid grid-cols-1 gap-5 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
                 <?php foreach ($accounts as $account) : ?>
                 <?= view_cell('GameAccountCardCell', ['account' => $account]) ?>
                 <?php endforeach; ?>
             </div>

             <?php if (empty($accounts) || count($accounts) < 1) : ?>
             <div class="flex w-full justify-center text-center py-2 md:py-8">
                 <span class="text-sm font-medium text-slate-400">Kamu Belum Memiliki Akun Game Yang Terkoneksi.</span>
             </div>
             <?php endif ?>
         </div>
         <?php if (auth()->isAdmin()): ?>
         <?php if (!empty($allUnverifiedAccounts)): ?>
         <div class="flex flex-col w-full">
             <h2 class="text-lg font-medium leading-6 text-slate-100">Akun game yang butuh verifikasi</h2>
             <div class="mt-4 grid grid-cols-1 gap-5 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
                 <?php foreach ($allUnverifiedAccounts as $account) : ?>
                 <?= view_cell('GameAccountCardCell', ['account' => $account]) ?>
                 <?php endforeach; ?>
             </div>
         </div>
         <?php endif ?>
         <?php if (!empty($allUserAccounts)): ?>
         <div class="flex flex-col w-full">
             <h2 class="text-lg font-medium leading-6 text-slate-100">Akun game dari semua pengguna</h2>
             <div class="mt-4 grid grid-cols-1 gap-5 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
                 <?php foreach ($allUserAccounts as $account) : ?>
                 <?= view_cell('GameAccountCardCell', ['account' => $account]) ?>
                 <?php endforeach; ?>
             </div>
         </div>
         <?php endif ?>
         <?php endif ?>
     </div>
 </div>
 <?= $this->endSection() ?>
