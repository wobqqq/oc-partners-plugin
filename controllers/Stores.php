<?php

declare(strict_types=1);

namespace BlackSeaDigital\Partners\Controllers;

use BackendMenu;
use Backend\Classes\Controller;

final class Stores extends Controller
{
    public $implement = [
        \Backend\Behaviors\FormController::class,
        \Backend\Behaviors\ImportExportController::class,
    ];

    public string $formConfig = 'config_form.yaml';

    public string $importExportConfig = 'config_import_export.yaml';

    public function __construct()
    {
        parent::__construct();

        BackendMenu::setContext('BlackSeaDigital.Partners', 'partners', 'partners');
    }
}
