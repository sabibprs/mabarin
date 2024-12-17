<div class="flex w-full">
    <?php if (!empty($name)) : ?>
        <input id="<?= esc($name) ?>" name="<?= esc($name) ?>" type="hidden" value="<?= !empty($value) ? esc($value) : $gameSelected->id ?>">
    <?php endif ?>

    <div class="relative h-28 w-28 sm:h-32 sm:w-32 md:h-36 md:w-36 rounded-full mx-auto">
        <div class="absolute group/btn-upload-photo transition-colors duration-700 w-full h-full justify-center items-center hover:bg-black/60 hover:animate-none rounded-full">
            <input class="hidden" type="file" target-id="<?= esc($name) ?>" target-name="<?= esc($name) ?>" uri-upload="<?= url_to('user.profile.upload-photo') ?>" accept=".png, .jpg, .jpeg" initial-render="true">
            <button role="upload-image-input" target-input="<?= esc($name) ?>" target-preview="preview-<?= esc($name) ?>" class="relative flex transition-all duration-700 opacity-0 group-hover/btn-upload-photo:opacity-100 w-full h-full rounded-full justify-center items-center" type="button">
                <span class="flex flex-col gap-1 transition-opacity duration-700 text-slate-300">
                    <i class="fa-solid fa-upload text-lg lg:text-xl mx-auto"></i>
                    <span class="text-xs md:text-sm text-center font-semibold">Ganti Foto</span>
                </span>
            </button>
        </div>
        <img class="h-28 w-28 sm:h-32 sm:w-32 md:h-36 md:w-36 rounded-full object-cover" src="<?= esc($value) ?>" alt="<?= esc($label) ?>" id="preview-<?= esc($name) ?>">
    </div>
</div>