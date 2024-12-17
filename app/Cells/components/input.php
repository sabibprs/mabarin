<div class="relative">
    <label class="block mb-2 text-sm font-medium text-white" for="<?= $name ?>"><?= $label ?></label>

    <?php if ($type == 'textarea') : ?>
        <textarea cols="<?= !empty($cols) ? $cols : 30 ?>" rows="<?= !empty($rows) ? $rows : 10 ?>" class="border <?= !empty($className) ? $className : "" ?> text-sm rounded-lg block w-full p-2.5 outline-none <?= !empty($errorMessage) ? 'invalid-input' : 'normal-input' ?>" id="<?= $name ?>" name="<?= $name ?>" placeholder="<?= $placeholder ?>" <?= !empty($required) ? 'required' : '' ?> <?= $disable ? "disabled='true'" : "" ?>><?= $value ?></textarea>
    <?php elseif ($type == 'boolean') : ?>
        <select id="<?= $name ?>" name="<?= $name ?>" type="<?= $type ?>" class="border <?= !empty($className) ? $className : "" ?> text-sm rounded-lg block w-full p-2.5 outline-none <?= !empty($errorMessage) ? 'invalid-input' : 'normal-input' ?>" <?= !empty($required) ? 'required' : '' ?> <?= $disable ? "disabled='true'" : "" ?>>
            <option class="bg-vulcan-700" value="true" <?= $value == 'true' || $value == true || $value == "1" || $value == 1 ? "selected" : "" ?>>Ya</option>
            <option class="bg-vulcan-700" value="false" <?= $value == 'false' || $value == false || $value == "0" || $value == 0 ? "selected" : "" ?>>Tidak</option>
        </select>
    <?php elseif ($type == 'select' && !empty($options)) : ?>
        <select id="<?= $name ?>" name="<?= $name ?>" type="<?= $type ?>" class="border <?= !empty($className) ? $className : "" ?> text-sm rounded-lg block w-full p-2.5 outline-none <?= !empty($errorMessage) ? 'invalid-input' : 'normal-input' ?>" <?= !empty($required) ? 'required' : '' ?>>
            <?php foreach ($options as $option) : ?>
                <option class="bg-vulcan-700" value="<?= $option->value ?>" <?= $value == $option->value ? "selected" : "" ?>><?= $option->text ?></option>
            <?php endforeach ?>
        </select>
    <?php else : ?>
        <input id="<?= $name ?>" name="<?= $name ?>" type="<?= $type ?>" value="<?= $value ?>" placeholder="<?= $placeholder ?>" class="border <?= !empty($className) ? $className : "" ?> text-sm rounded-lg block w-full p-2.5 outline-none <?= !empty($errorMessage) ? 'invalid-input' : 'normal-input' ?>" <?= !empty($required) ? 'required' : '' ?> <?= !empty($autoComplete) ? "autocomplete='$autoComplete'" : "" ?> <?= !empty($mathParent) ? "match-parent='$mathParent'" : "" ?> <?= !empty($mathParentSlug) ? "match-parent-slug='$mathParentSlug'" : "" ?> <?= $disable ? "disabled='true'" : "" ?> />
    <?php endif; ?>

    <?php if (!empty($type) && $type == 'password') : ?>
        <button type="button" aria-label="password-show" class="absolute transition-colors duration-300 top-9 right-3 text-xl <?= empty($errorMessage) ? "text-vulcan-400 hover:text-vulcan-300" : "text-red-200/70 hover:text-red-200" ?>">
            <i class="fa-solid fa-eye inline"></i>
            <i class="fa-solid fa-eye-slash hidden"></i>
        </button>
    <?php endif; ?>

    <?php if (!empty($errorMessage)) : ?>
        <span class="text-xs text-red-400 font-medium ml-0.5"><?= esc($errorMessage) ?></span>
    <?php endif; ?>
</div>