<div data-control="toolbar loader-container">
    <a
        href="<?= Backend::url('blackseadigital/partners/countries/create') ?>"
        class="btn btn-primary">
        <i class="icon-plus"></i>
        <?= __("New :name", ['name' => 'Country']) ?>
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

    <a href="<?= Backend::url('blackseadigital/partners/countries/import') ?>" class="btn btn-primary oc-icon-download">
        <?= __("Import countries") ?>
    </a>

    <div class="toolbar-divider"></div>

    <a href="<?= Backend::url('blackseadigital/partners/cities/import') ?>" class="btn btn-primary oc-icon-download">
        <?= __("Import cities") ?>
    </a>
</div>
