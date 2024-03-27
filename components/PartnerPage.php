<?php

namespace Blackseadigital\Partners\Components;

use Blackseadigital\Partners\Models\Partner;
use Cms\Classes\ComponentBase;
use Exception;

final class PartnerPage extends ComponentBase
{
    private readonly Partner $partner;

    public function componentDetails(): array
    {
        return [
            'name' => 'Partner page',
            'description' => ''
        ];
    }

    public function defineProperties(): array
    {
        return [
            'slug' => [
                'title' => 'Slug',
                'type' => 'string',
            ],
        ];
    }

    public function init(): void
    {
        $slug = (string)$this->property('slug');
        $partner = Partner::whereSlug($slug)->first();

        if (empty($partner) || $partner->is_active === false) {
            $this->controller->run('404');
        } else {
            $this->partner = $partner;
        }
    }

    /**
     * @throws Exception
     */
    public function getPartner(): Partner
    {
        return $this->partner;
    }
}
