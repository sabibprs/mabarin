<?= $this->extend('layouts/clean-layout') ?>

<?= $this->section('content') ?>
<div class="w-full flex justify-center min-h-screen">
    <div class="h-screen w-full">
        <div class="flex item-center justify-center">
            <div class="relative z-10 mt-[calc(25vh)] h-fit w-full max-w-lg mx-6 md:mx-0 overflow-hidden border border-vulcan-500 rounded-2xl shadow-xl">
                <div
                     class="flex relative flex-col items-center justify-center space-y-3 border-b border-vulcan-500 bg-vulcan-500 rounded-md rounded-b-none bg-clip-padding backdrop-filter backdrop-blur-sm bg-opacity-30 px-4 py-6 pt-8 text-center sm:px-16">
                    <a class="flex items-center gap-1 group/back absolute left-3 top-3 rounded-md border border-vulcan-500 px-3 py-1 text-xs font-medium bg-vulcan-500 bg-clip-padding backdrop-filter backdrop-blur-sm bg-opacity-30 transition-all hover:border-vulcan-400/80"
                       href="<?= previous_url() ?>">
                        <i
                           class="fa-solid fa-chevron-left transition-all duration-700 -translate-x-full -mr-3 opacity-0 group-hover/back:opacity-70 group-hover/back:m-0 group-hover/back:translate-x-0 "></i>
                        Kembali
                    </a>
                    <h3 class="text-xl font-semibold">Login ke <?= env('app.name', 'MabarIn') ?></h3>
                    <p class="text-sm text-slate-300">Login ke akun mu dan cari tim mabar yang solid.</p>
                </div>
                <div
                     class="flex flex-col space-y-3 bg-vulcan-500 rounded-md rounded-t-none bg-clip-padding backdrop-filter backdrop-blur-sm bg-opacity-20 px-4 py-8 sm:px-16">
                    <form class="flex flex-col" action="<?= url_to('login') ?>" method="post" accept-charset="utf-8">
                        <div class="mb-5">
                            <?= view_cell('InputCell', [
                                'name' => 'username',
                                'label' => 'Username',
                                'type' => 'text',
                                'placeholder' => 'Username atau Email kamu',
                                'className' => 'border-vulcan-600',
                                'value' => set_value('username'),
                                'errorMessage' => !empty($error->username) ? $error->username : null,
                            ]) ?>
                        </div>
                        <div class="mb-8">
                            <?= view_cell('InputCell', [
                                'name' => 'password',
                                'label' => 'Password',
                                'type' => 'password',
                                'placeholder' => '••••••••',
                                'className' => 'border-vulcan-600',
                                'value' => set_value('password'),
                                'errorMessage' => !empty($error->password) ? $error->password : null,
                            ]) ?>
                        </div>

                        <?php if (!empty($error->global)) : ?>
                        <div class="mb-2 -mt-6 w-full">
                            <span class="text-xs text-red-400 font-medium ml-0.5"><?= esc($error->global) ?></span>
                        </div>
                        <?php endif; ?>

                        <button class="flex font-semibold h-10 w-full items-center justify-center space-x-2 rounded-md border px-4 text-sm transition-all focus:outline-none bg-blue-500 border-transparent bg-bg-blue-400/80 text-white hover:bg-blue-400/90 hover:border-blue-400 hover:text-white disabled:hover:bg-blue-400/80 disabled:border:bg-slate-400 disabled:opacity-80 disabled:cursor-wait"
                                type="submit">
                            <p>Login</p>
                        </button>
                    </form>
                    <p class="text-center text-sm text-slate-300/80">Belum punya akun?
                        <a class="font-semibold text-blue-400 transition-colors hover:text-blue-300" href="<?= url_to('register') ?>">Daftar Sekarang</a>.
                    </p>
                </div>
            </div>
        </div>
    </div>
    <div class="absolute w-screen h-screen opacity-50" style="z-index: -80; background-image: url(&quot;https://source.unsplash.com/1600x900/?dark+purple);">
    </div>
</div>
<?= $this->endSection() ?>
