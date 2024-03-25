<?php

declare(strict_types=1);

namespace BlackSeaDigital\Partners\Controllers;

use BackendMenu;
use Backend\Classes\Controller;

final class Partners extends Controller
{
    public $implement = [
        \Backend\Behaviors\FormController::class,
        \Backend\Behaviors\ListController::class,
        \Backend\Behaviors\ImportExportController::class,
        \Backend\Behaviors\RelationController::class,
    ];

    public string $formConfig = 'config_form.yaml';

    public string $listConfig = 'config_list.yaml';

    public string $importExportConfig = 'config_import_export.yaml';

    public string $relationConfig = 'config_relation.yaml';

    public function __construct()
    {
        parent::__construct();

        BackendMenu::setContext('BlackSeaDigital.Partners', 'partners', 'partners');
    }
}
