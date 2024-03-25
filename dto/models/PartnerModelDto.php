<?php

declare(strict_types=1);

namespace BlackSeaDigital\Partners\Dto\Models;

final readonly class PartnerModelDto
{
    public function __construct(
        public string  $name,
        public int     $categoryId,
        public bool    $isActive,
        public bool    $isOnline,
        public bool    $isOffline,
        public ?string $onlinePoints,
        public ?string $offlinePoints,
        public ?string $interestFreeInstallments,
        public ?string $link,
        public ?string $description,
        public ?string $externalId = null,
        public ?string $logo = null,
        public ?array  $banners = [],
        public ?string $deletedAt = null,
    )
    {
    }
}
