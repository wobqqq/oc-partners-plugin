<div data-control="toolbar loader-container">
    <a
        href="<?= Backend::url('blackseadigital/partners/partners/create') ?>"
        class="btn btn-primary">
        <i class="icon-plus"></i>
        <?= __("New :name", ['name' => 'Partner']) ?>
    </a>

    <div class="toolbar-divider"></div>

    <button
        class="btn btn-secondary"
        data-request="onDelete"
        data-request-message="<?= __("Deleting...") ?>"
        data-request-confirm="<?= __("Are you sure?") ?>"
        data-list-checked-trigger
        data-list-checked-request
        disabled>
        <i class="icon-delete"></i>
        <?= __("Delete") ?>
    </button>

    <div class="toolbar-divider"></div>

    <a href="<?= Backend::url('blackseadigital/partners/partners/import') ?>" class="btn btn-primary oc-icon-download">
        <?= __("Import partners") ?>
    </a>

    <div class="toolbar-divider"></div>

    <a href="<?= Backend::url('blackseadigital/partners/stores/import') ?>" class="btn btn-primary oc-icon-download">
        <?= __("Import stores") ?>
    </a>
</div>
