<?php

declare(strict_types=1);

namespace BlackSeaDigital\Partners\Dto\Rows;

final readonly class PartnerRowDto
{
    public function __construct(
        public string $name,
        public string $externalId,
        public string $categoryExternalId,
        public bool   $isActive,
        public bool   $isOnline,
        public bool   $isOffline,
        public string $onlinePoints,
        public string $offlinePoints,
        public string $interestFreeInstallments,
        public string $link,
        public string $description,
        public string $logo,
        public array  $banners,
    )
    {
    }
}
