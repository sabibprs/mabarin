<div class="relative">
    <?php if (!empty($label)) : ?>
        <label class="block mb-2 text-[15px] font-medium text-white"><?= esc($label) ?></label>
    <?php endif ?>

    <?php if (!empty($name['hero'])) : ?>
        <input aria-label="input-hero-name" id="<?= esc($name['hero']) ?>" name="<?= esc($name['hero']) ?>" type="hidden" value="<?= empty($value['hero']) ? (!empty($heroSelected->name) ? esc($heroSelected->name) : "") : esc($value['hero']) ?>">
    <?php endif ?>

    <?php if (!empty($name['hero_id'])) : ?>
        <input aria-label="input-hero-id" id="<?= esc($name['hero_id']) ?>" name="<?= esc($name['hero_id']) ?>" type="hidden" value="<?= empty($value['hero_id']) ? (!empty($heroSelected->id) ? esc($heroSelected->id) : "") : esc($value['hero_id']) ?>">
    <?php endif ?>

    <?php if (!empty($name['hero_role'])) : ?>
        <input aria-label="input-hero-role" id="<?= esc($name['hero_role']) ?>" name="<?= esc($name['hero_role']) ?>" type="hidden" value="<?= empty($value['hero_role']) ? (!empty($heroSelected->detail->role) ? esc($heroSelected->detail->role) : "null") : esc($value['hero_role']) ?>">
    <?php endif ?>

    <?php if (!empty($name['hero_image'])) : ?>
        <input aria-label="input-hero-image" id="<?= esc($name['hero_image']) ?>" name="<?= esc($name['hero_image']) ?>" type="hidden" value="<?= empty($value['hero_image']) ? (!empty($heroSelected->image) ? esc($heroSelected->image) : "") : esc($value['hero_image']) ?>">
    <?php endif ?>


    <div class="relative flex flex-col w-full transition-all duration-1000 overflow">
        <div control="<?= !$disable ? "hero-input" : "none" ?>" control-expand-element="hero-input-list" class="flex w-full transition-colors duration-500 items-center border text-sm rounded-lg md:rounded-xl outline-none hero-input overflow-hidden cursor-pointer shadow-lg z-10">
            <div class="w-auto h-full">
                <div class="flex h-full w-16 md:w-16 lg:w-16 p-[5px]">
                    <div class="relative h-full w-full aspect-square overflow-hidden rounded-r-2xl rounded-lg md:rounded-xl">
                        <div class="absolute top-0 left-0 bg-black/10 h-full w-full z-10"></div>
                        <img class="h-full w-full object-cover z-0" src="<?= esc($heroSelected->image) ?>" alt="<?= esc($heroSelected->name) ?>" aria-label="hero-image">
                    </div>
                </div>
            </div>
            <div class="flex flex-col w-full bg-gradient-to-br pr-2 pl-1.5">
                <span class="text-sm lg:text-base truncate text-slate-300 font-semibold" aria-label="hero-name"><?= esc($heroSelected->name) ?></span>
                <span class="text-xs lg:text-sm truncate text-slate-300/80 font-medium" aria-label="hero-role"><?= !empty($heroSelected->detail->role) ? esc($heroSelected->detail->role) : "" ?></span>
            </div>
        </div>

        <?php if (!$disable) : ?>
            <div control="hero-input-list" control-expanded="show" class="transition-all duration-500 hero-input-expander rounded-b-xl bg-vulcan-700 bg-clip-padding backdrop-filter backdrop-blur-sm bg-opacity-40 overflow-hidden -mt-5 pt-4">
                <div class="flex flex-col w-full h-full mt-2 pt-4 pb-6 px-4 overflow-y-auto">
                    <?php if (!empty($placeholder)) : ?>
                        <label class="block mb-4 pb-2 border-b border-vulcan-700 text-sm font-semibold text-slate-200"><?= $placeholder ?></label>
                    <?php endif; ?>
                    <div class="flex flex-col gap-3 w-full h-auto">
                        <?php foreach ($heroes as $hero) : ?>
                            <button type="button" data-hero-id="<?= $hero->id ?>" class="flex w-full items-center group/hero-list transition-all duration-500 <?= ($heroSelected->id == $hero->id) ? "selected hero-input-list-color" : "hero-input-list-color" ?> text-start border text-sm rounded-lg lg:rounded-xl outline-none overflow-hidden cursor-pointer">
                                <div class="w-auto h-full">
                                    <div class="flex h-full w-16 md:w-14 p-[5px]">
                                        <div class="relative h-full w-full aspect-square overflow-hidden rounded-r-2xl rounded-lg md:rounded-xl">
                                            <div class="absolute top-0 left-0 bg-black/10 h-full w-full z-10"></div>
                                            <img class="h-full w-full object-cover z-0" src="<?= esc($hero->image) ?>" alt="<?= esc($hero->name) ?>" aria-label="hero-image">
                                        </div>
                                    </div>
                                </div>
                                <div class="flex flex-col w-full bg-gradient-to-br pr-2 pl-1.5">
                                    <span class="text-sm truncate text-slate-300/90 font-medium md:font-semibold" aria-label="hero-name"><?= esc($hero->name) ?></span>
                                    <span class="text-xs truncate text-slate-300/60 font-medium md:font-semibold" aria-label="hero-role"><?= !empty($hero->detail->role) ? esc($hero->detail->role) : "" ?></span>
                                </div>
                            </button>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        <?php endif ?>
    </div>
</div>



<?php if (!$disable) : ?>
    <script src="<?= base_url('/js/input-game-hero.js') ?>" async></script>
<?php endif ?>