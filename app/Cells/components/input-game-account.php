<div class="relative">
    <?php if (!empty($label)) : ?>
        <label class="block mb-2 text-[15px] font-medium text-white" for="<?= esc($name) ?>"><?= esc($label) ?></label>
    <?php endif ?>

    <?php if (!empty($name)) : ?>
        <input id="<?= esc($name) ?>" name="<?= esc($name) ?>" type="hidden" value="<?= !empty($value) ? esc($value) : $accountSelected->id ?>">
    <?php endif ?>

    <div class="relative flex flex-col w-full transition-all duration-1000 overflow">
        <div control="<?= !$disable ? "account-input" : "none" ?>" control-input="<?= esc($name) ?>" control-expand-element="account-input-<?= esc($name) ?>" class="flex w-full transition-colors duration-500 items-center border text-sm rounded-lg md:rounded-lg outline-none account-input overflow-hidden cursor-pointer hover:shadow-lg z-10">
            <div class="flex w-full flex-col py-2 px-4 gap-0.5">
                <div class="flex flex-row justify-between items-center w-full">
                    <span class="text-sm text-slate-300/80 font-medium">User Id</span>
                    <span class="text-sm text-slate-300 font-semibold" aria-label="account-identity"><?= esc($accountSelected->identity) ?></span>
                </div>
                <div class="flex flex-row justify-between items-center w-full">
                    <span class="text-sm text-slate-300/80 font-medium">Zone Id</span>
                    <span class="text-sm text-slate-300 font-semibold" aria-label="account-identity-zone-id"><?= !empty($accountSelected->identity_zone_id) && $accountSelected->identity_zone_id !== 0 ? esc($accountSelected->identity_zone_id) : "-" ?></span>
                </div>
            </div>
        </div>
        <?php if (!$disable) : ?>
            <div control="account-input-<?= esc($name) ?>" control-expanded="false" class="transition-all duration-500 account-input-expander rounded-b-xl bg-vulcan-700 bg-clip-padding backdrop-filter backdrop-blur-sm bg-opacity-20 overflow-hidden -mt-1 pt-1">
                <div class="flex flex-col w-full h-full mt-2 pt-4 pb-6 px-4 overflow-y-auto">
                    <?php if (!empty($placeholder)) : ?>
                        <label class="block mb-4 pb-2 border-b border-vulcan-700 text-sm font-semibold text-slate-200"><?= $placeholder ?></label>
                    <?php endif; ?>
                    <div class="flex flex-col gap-3 w-full h-auto">
                        <?php foreach ($accounts as $account) : ?>
                            <button type="button" data-account-id="<?= $account->id ?>" class="flex w-full items-center group/account-list transition-all duration-500 <?= ($accountSelected->id == $account->id) ? "selected account-input-list-color" : "account-input-list-color" ?> text-start border text-sm rounded-lg outline-none overflow-hidden cursor-pointer">
                                <div class="flex w-full flex-col p-2 px-3">
                                    <div class="flex flex-row justify-between items-center w-full">
                                        <span class="text-sm text-slate-300/80 font-medium">User Id</span>
                                        <span class="text-sm text-slate-300 font-semibold" aria-label="account-identity"><?= esc($account->identity) ?></span>
                                    </div>
                                    <div class="flex flex-row justify-between items-center w-full">
                                        <span class="text-sm text-slate-300/80 font-medium">Zone Id</span>
                                        <span class="text-sm text-slate-300 font-semibold" aria-label="account-identity-zone-id"><?= !empty($account->identity_zone_id) && $account->identity_zone_id !== 0 ?  esc($account->identity_zone_id) : "-" ?></span>
                                    </div>
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
    <script src="<?= base_url('/js/input-game-account.js') ?>" async></script>
<?php endif ?>