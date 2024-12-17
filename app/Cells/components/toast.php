<div class="fixed top-2 md:top-5 right-0 px-2 md:pr-5 md:pl-0 flex justify-end w-auto overflow-hidden z-50">
    <?php if (!empty($message) && !empty($type) && $type == "info") : ?>
        <div class="toast group/toast transition-all duration-700">
            <div class="flex items-center w-full max-w-xs md:max-w-sm p-2 md:p-4 rounded-lg shadow text-blue-200 border border-blue-600/60 bg-blue-600 bg-clip-padding backdrop-filter backdrop-blur-2xl bg-opacity-30" role="alert">
                <div class="inline-flex items-center justify-center flex-shrink-0 w-8 h-8 rounded-lg bg-blue-700/80 text-blue-200">
                    <i class="fa-solid fa-info-circle"></i>
                </div>
                <div class="ms-3 text-[14px] md:text-sm transition-all duration-1000 font-medium"><?= esc($message) ?></div>
                <button type="button" aria-label="Close" class="transition-all inline-flex opacity-0 w-0 h-0 md:group-hover/toast:opacity-100 md:group-hover/toast:ms-auto md:group-hover/toast:-mr-1.5 md:group-hover/toast:ml-2 md:group-hover/toast:-my-1.5 rounded-lg focus:ring-2 focus:ring-blue-400/30 md:group-hover/toast:p-1.5 items-center justify-center md:group-hover/toast:h-8 md:group-hover/toast:w-8 text-slate-400 hover:text-slate-300 hover:bg-blue-600 hover:bg-clip-padding hover:backdrop-filter hover:backdrop-blur-2xl hover:bg-opacity-10">
                    <span class="sr-only">Close</span>
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                    </svg>
                </button>
            </div>
        </div>
    <?php endif; ?>

    <?php if (!empty($message) && !empty($type) && $type == "success") : ?>
        <div class="toast group/toast transition-all duration-700">
            <div class="flex items-center w-full max-w-xs md:max-w-sm p-2 md:p-4 rounded-lg shadow text-green-100 border border-green-600/60 bg-green-600 bg-clip-padding backdrop-filter backdrop-blur-2xl bg-opacity-30" role="alert">
                <div class="inline-flex items-center justify-center flex-shrink-0 w-8 h-8 rounded-lg bg-green-700/80 text-green-200">
                    <i class="fa-solid fa-check"></i>
                </div>
                <div class="ms-3 text-[14px] md:text-sm transition-all duration-1000 font-medium"><?= esc($message) ?></div>
                <button class="transition-all inline-flex opacity-0 w-0 h-0 md:group-hover/toast:opacity-100 md:group-hover/toast:ms-auto md:group-hover/toast:-mr-1.5 md:group-hover/toast:ml-2 md:group-hover/toast:-my-1.5 rounded-lg focus:ring-2 focus:ring-green-400/30 md:group-hover/toast:p-1.5 items-center justify-center md:group-hover/toast:h-8 md:group-hover/toast:w-8 text-slate-400 hover:text-slate-300 hover:bg-green-600 hover:bg-clip-padding hover:backdrop-filter hover:backdrop-blur-2xl hover:bg-opacity-10" type="button" aria-label="Close">
                    <span class="sr-only">Close</span>
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                    </svg>
                </button>
            </div>
        </div>
    <?php endif; ?>

    <?php if (!empty($message) && !empty($type) && $type == "warning") : ?>
        <div class="toast group/toast transition-all duration-700">
            <div class="flex items-center w-full max-w-xs md:max-w-sm p-2 md:p-4 rounded-lg shadow text-orange-100 border border-orange-600/60 bg-orange-600 bg-clip-padding backdrop-filter backdrop-blur-2xl bg-opacity-30" role="alert">
                <div class="inline-flex items-center justify-center flex-shrink-0 w-8 h-8 rounded-lg bg-orange-700/80 text-orange-200">
                    <i class="fa-solid fa-triangle-exclamation -mt-0.5"></i>
                </div>
                <div class="ms-3 text-[14px] md:text-sm transition-all duration-1000 font-medium"><?= esc($message) ?></div>
                <button class="transition-all inline-flex opacity-0 w-0 h-0 md:group-hover/toast:opacity-100 md:group-hover/toast:ms-auto md:group-hover/toast:-mr-1.5 md:group-hover/toast:ml-2 md:group-hover/toast:-my-1.5 rounded-lg focus:ring-2 focus:ring-orange-400/30 md:group-hover/toast:p-1.5 items-center justify-center md:group-hover/toast:h-8 md:group-hover/toast:w-8 text-slate-400 hover:text-slate-300 hover:bg-orange-600 hover:bg-clip-padding hover:backdrop-filter hover:backdrop-blur-2xl hover:bg-opacity-10" type="button" aria-label="Close">
                    <span class="sr-only">Close</span>
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                    </svg>
                </button>
            </div>
        </div>
    <?php endif; ?>

    <?php if (!empty($message) && !empty($type) && $type == "error") : ?>
        <div class="toast group/toast transition-all duration-700">
            <div class="flex items-center w-full max-w-xs md:max-w-sm p-2 md:p-4 rounded-lg shadow text-red-100 border border-red-600/60 bg-red-600 bg-clip-padding backdrop-filter backdrop-blur-2xl bg-opacity-30" role="alert">
                <div class="inline-flex items-center justify-center flex-shrink-0 w-8 h-8 rounded-lg bg-red-700/80 text-red-200">
                    <i class="fa-solid fa-circle-exclamation"></i>
                </div>
                <div class="ms-3 text-[14px] md:text-sm transition-all duration-1000 font-medium"><?= esc($message) ?></div>
                <button type="button" aria-label="Close" class="transition-all inline-flex opacity-0 w-0 h-0 md:group-hover/toast:opacity-100 md:group-hover/toast:ms-auto md:group-hover/toast:-mr-1.5 md:group-hover/toast:ml-2 md:group-hover/toast:-my-1.5 rounded-lg focus:ring-2 focus:ring-red-400/30 md:group-hover/toast:p-1.5 items-center justify-center md:group-hover/toast:h-8 md:group-hover/toast:w-8 text-slate-400 hover:text-slate-300 hover:bg-red-600 hover:bg-clip-padding hover:backdrop-filter hover:backdrop-blur-2xl hover:bg-opacity-10">
                    <span class="sr-only">Close</span>
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                    </svg>
                </button>
            </div>
        </div>
    <?php endif; ?>
</div>

<script src="<?= base_url('/js/toast.js') ?>" async></script>