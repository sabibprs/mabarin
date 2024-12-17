<?= $this->extend('layouts/layout') ?>

<?= $this->section('content') ?>
<div class="w-full relative">
    <div class="flex flex-col w-full">
        <div class="relative overflow-hidden sm:rounded-lg">
            <div class="flex items-center justify-between flex-column flex-wrap md:flex-row pb-4">
                <div>
                    <button class="inline-flex items-center border outline-none font-medium rounded-lg text-sm px-3 py-1.5 bg-vulcan-700 text-slate-300 border-vulcan-600 hover:bg-vulcan-700 hover:border-vulcan-600 focus:ring-vulcan-700"
                            data-dropdown-toggle="dropdownAction" type="button" type="button" aria-controls="toggle" toggle-show="true"
                            toggle-expand-target="user-menu-action" toggle-on-click-only="true">
                        <span class="sr-only">Action button</span>
                        Action
                        <svg class="w-2.5 h-2.5 ms-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4" />
                        </svg>
                    </button>

                    <div class="z-10 mt-2 shadow-xl absolute hidden flex-col divide-y rounded-lg w-60 bg-vulcan-600 divide-vulcan-500"
                         toggle-expand="user-menu-action" show-on-toggle="true">
                        <ul class="py-1 text-sm text-slate-200" aria-labelledby="dropdownActionButton">
                            <li>
                                <a class="flex items-center gap-2 text-center px-4 py-2 hover:bg-vulcan-500 hover:text-white font-medium" href="#">
                                    <i class="fa-solid fa-user-shield mr-0.5"></i>
                                    <span>Jadikan Admin</span>
                                </a>
                            </li>
                            <li>
                                <a class="flex items-center gap-2 text-center px-4 py-2 hover:bg-vulcan-500 hover:text-white font-medium" href="#">
                                    <i class="fa-solid fa-user-pen mr-0.5"></i>
                                    <span>Jadikan Pengguna Biasa</span>
                                </a>
                            </li>
                            <li>
                                <a class="flex items-center gap-2 text-center px-4 py-2 hover:bg-vulcan-500 hover:text-white font-medium" href="#">
                                    <i class="fa-solid fa-user-lock mr-0.5"></i>
                                    <span>Nonaktifkan</span>
                                </a>
                            </li>
                        </ul>
                        <div class="py-1">
                            <a class="flex items-center gap-2 text-center px-4 py-2 text-sm text-slate-200 hover:bg-rose-600/80 hover:text-white font-medium"
                               href="#">
                                <i class="fa-solid fa-user-xmark mr-0.5"></i>
                                <span>Hapus Pengguna Dipilih</span>
                            </a>
                        </div>
                    </div>
                </div>
                <label class="sr-only" for="table-search">Cari</label>
                <div class="relative">
                    <div class="absolute inset-y-0 rtl:inset-r-0 start-0 flex items-center ps-3 pointer-events-none">
                        <svg class="w-4 h-4 text-slate-300" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                        </svg>
                    </div>
                    <input class="block p-2 py-1.5 md:py-2 ps-10 text-sm slate-100 border rounded-lg w-full lg:max-w-80 bg-vulcan-700/80 placeholder:text-slate-200 border-vulcan-600 placeholder-vulcan-400 text-white ring-0 outline-none focus:border-vulcan-500"
                           type="text" placeholder="Cari Pengguna">
                </div>
            </div>
            <div class="flex w-full overflow-x-auto rounded-lg md:rounded-none">
                <table class="w-full text-sm text-left rtl:text-right text-slate-300 shadow-xl">
                    <thead class="text-xs text-slate-400 uppercase bg-vulcan-700">
                        <tr>
                            <th class="p-4" scope="col">
                                <div class="flex items-center">
                                    <input class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"
                                           id="checkbox-all-search" type="checkbox">
                                    <label class="sr-only" for="checkbox-all-search">checkbox</label>
                                </div>
                            </th>
                            <th class="px-6 py-3" scope="col">
                                Nama
                            </th>
                            <th class="px-6 py-3" scope="col">
                                Email
                            </th>
                            <th class="px-6 py-3" scope="col">
                                Telepon
                            </th>
                            <th class="px-6 py-3" scope="col">
                                Role
                            </th>
                            <th class="px-6 py-3" scope="col">
                                Action
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-slate-800">
                        <?php foreach ($users as $user): ?>
                        <tr class="border-b bg-vulcan-800/80 border-vulcan-700 hover:bg-vulcan-700 hover:border-vulcan-600">
                            <td class="w-4 p-4">
                                <div class="flex items-center">
                                    <input class="w-4 h-4 text-blue-600 rounded-lg focus:ring-blue-600 ring-offset-gray-800 focus:ring-offset-gray-800 focus:ring-2 bg-gray-700 border-gray-600"
                                           id="checkbox-user-select" type="checkbox">
                                    <label class="sr-only" for="checkbox-user-select">select</label>
                                </div>
                            </td>
                            <th class="flex items-center px-6 py-4 whitespace-nowrap text-white" scope="row">
                                <div class="w-10 h-10 rounded-full">
                                    <img class="w-full h-full rounded-full object-cover" src="<?= esc($user->photo) ?>" alt="<?= "$user->name
                                    (@{$user->username})" ?>">
                                </div>
                                <div class="ps-3">
                                    <div class="text-sm md:text-base font-semibold text-slate-100"><?= esc($user->name) ?></div>
                                    <a class="text-xs md:text-sm font-medium text-slate-300/70 hover:text-blue-400 cursor-pointer"
                                       href="<?= url_to('user.detail', $user->username) ?>">@<?= esc($user->username) ?></a>
                                </div>
                            </th>
                            <td class="px-6 py-4">
                                <a class="text-slate-300 hover:text-blue-400 cursor-pointer" href="mailto:<?= $user->email ?>"><?= esc($user->email) ?></a>
                            </td>
                            <td class="px-6 py-4">
                                <span><?= esc($user->phone) ?></span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center text-center">
                                    <span
                                          class="px-4 py-1 rounded-full font-semibold <?= $user->role == 'admin' ? 'bg-cyan-600/90 text-white' : 'bg-blue-600/80 text-slate-200' ?>">
                                        <?= esc($user->role == 'admin' ? 'Admin' : 'Pengguna') ?>
                                    </span>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <a class="font-medium text-blue-400 hover:underline" href="<?= url_to('user.edit', $user->username) ?>">Edit</a>
                            </td>
                        </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
