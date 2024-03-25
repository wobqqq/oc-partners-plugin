<?php

declare(strict_types=1);

namespace Blackseadigital\Partners\Enums;

enum QueryListMode: string
{
    case PAGINATION = 'pagination';
    case ALL = 'all';
}
