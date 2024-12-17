<?= $this->extend('layouts/layout') ?>

<?= $this->section('content') ?>
<div class="w-full relative">
    <div class="flex flex-col w-full justify-center gap-4">
        <div class="flex flex-col mx-auto w-full md:max-w-xl bg-slate-900 border border-slate-800 rounded-xl shadow-lg shadow-elephant-800/10">
            <form class="flex flex-col w-full px-4 py-6 md:px-8 md:pt-8 md:pb-10"action="<?= url_to('user.profile.edit') ?>" method="post" accept-charset="utf-8">
                <div class="flex flex-col mx-auto justify-center mb-8 gap-4">
                </div>

                <div class="mb-5">
                    <?= view_cell('InputPhotoProfileCell', [
                        'label' => $user->name,
                        'name' => 'photo',
                        'type' => 'text',
                        'value' => set_value('photo', esc($user->photo)),
                        'errorMessage' => !empty($error->photo) ? $error->photo : null,
                    ]) ?>
                </div>
                <div class="mb-5">
                    <?= view_cell('InputCell', [
                        'label' => 'Nama',
                        'name' => 'name',
                        'type' => 'text',
                        'value' => set_value('name', esc($user->name)),
                        'errorMessage' => !empty($error->name) ? $error->name : null,
                    ]) ?>
                </div>
                <div class="mb-5">
                    <?= view_cell('InputCell', [
                        'label' => 'Username',
                        'name' => 'username',
                        'type' => 'text',
                        'value' => set_value('username', esc($user->username)),
                        'errorMessage' => !empty($error->username) ? $error->username : null,
                    ]) ?>
                </div>
                <div class="mb-5">
                    <?= view_cell('InputCell', [
                        'label' => 'Email',
                        'name' => 'email',
                        'type' => 'email',
                        'value' => set_value('email', esc($user->email)),
                        'errorMessage' => !empty($error->email) ? $error->email : null,
                    ]) ?>
                </div>
                <div class="mb-5">
                    <?= view_cell('InputCell', [
                        'label' => 'Telepon',
                        'name' => 'phone',
                        'type' => 'text',
                        'value' => set_value('phone', esc($user->phone)),
                        'errorMessage' => !empty($error->phone) ? $error->phone : null,
                    ]) ?>
                </div>
                <div class="mb-8">
                    <?= view_cell('InputCell', [
                        'label' => 'Kata Sandi',
                        'name' => 'password',
                        'type' => 'password',
                        'value' => set_value('password'),
                        'errorMessage' => !empty($error->password) ? $error->password : null,
                    ]) ?>
                    <?php if (empty($error->password)): ?>
                    <span class="text-xs font-medium text-slate-400/80">Biarkan kata sandi tetap kosong untuk menggunakan kata sandi yang lama.</span>
                    <?php endif ?>
                </div>

                <div class="flex w-full justify-between">
                    <a class="text-sm text-center w-auto py-2 md:py-1.5 px-4 font-semibold rounded-md border transition focus:outline-none bg-vulcan-600 border-transparent text-slate-200 hover:bg-vulcan-500 hover:border-vulcan-500 hover:text-white cursor-pointer"
                       href="<?= url_to('user.profile') ?>">
                        <i class="fa-solid fa-arrow-left mr-0.5"></i>
                        Batal
                    </a>
                    <button class="text-sm text-center w-auto py-2 md:py-1.5 px-4 font-semibold rounded-md border transition focus:outline-none bg-blue-500 border-transparent text-slate-200 hover:bg-blue-400 hover:border-blue-500 hover:text-white cursor-pointer"
                            type="submit">
                        <i class="fa-solid fa-floppy-disk mr-0.5"></i>
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
