<?php namespace BlackSeaDigital\Partners;

use Blackseadigital\Partners\Components\PartnerPage;
use Blackseadigital\Partners\Components\PartnerList;
use System\Classes\PluginBase;

final class Plugin extends PluginBase
{
    public function registerComponents(): array
    {
        return [
            PartnerPage::class => 'PartnerPage',
            PartnerList::class => 'PartnerList',
        ];
    }
}
