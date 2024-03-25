<?php

declare(strict_types=1);

namespace BlackSeaDigital\Partners\Services;

use BlackSeaDigital\Partners\Dto\Models\PartnerModelDto;
use Blackseadigital\Partners\Models\Partner;
use Exception;
use Illuminate\Support\Facades\DB;
use Str;

final readonly class PartnerService
{
    public function __construct(private FileService $fileService)
    {
    }

    /**
     * @throws Exception
     */
    public function create(PartnerModelDto $partnerModelDto): Partner
    {
        try {
            DB::beginTransaction();

            $partner = Partner::create([
                'name' => $partnerModelDto->name,
                'external_id' => $partnerModelDto->externalId,
                'slug' => Str::slug($partnerModelDto->name, '-'),
                'category_id' => $partnerModelDto->categoryId,
                'is_active' => $partnerModelDto->isActive,
                'is_offline' => $partnerModelDto->isOffline,
                'is_online' => $partnerModelDto->isOnline,
                'description' => $partnerModelDto->description,
                'offline_points' => $partnerModelDto->offlinePoints,
                'interest_free_installments' => $partnerModelDto->interestFreeInstallments,
                'online_points' => $partnerModelDto->onlinePoints,
                'link' => $partnerModelDto->link,
                'deleted_at' => $partnerModelDto->deletedAt,
            ]);

            $this->fileService->attachOne($partnerModelDto->logo, $partner->logo, $partner->logo());
            $this->fileService->attachMany($partnerModelDto->banners, $partner->banners, $partner->banners());

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }

        return $partner;
    }

    /**
     * @throws Exception
     */
    public function update(PartnerModelDto $partnerModelDto, Partner $partner): Partner
    {
        try {
            DB::beginTransaction();

            $partner->update([
                'name' => $partnerModelDto->name,
                'external_id' => $partnerModelDto->externalId,
                'category_id' => $partnerModelDto->categoryId,
                'is_active' => $partnerModelDto->isActive,
                'is_offline' => $partnerModelDto->isOffline,
                'is_online' => $partnerModelDto->isOnline,
                'description' => $partnerModelDto->description,
                'offline_points' => $partnerModelDto->offlinePoints,
                'interest_free_installments' => $partnerModelDto->interestFreeInstallments,
                'online_points' => $partnerModelDto->onlinePoints,
                'link' => $partnerModelDto->link,
                'deleted_at' => $partnerModelDto->deletedAt,
            ]);

            $this->fileService->attachOne($partnerModelDto->logo, $partner->logo, $partner->logo());
            $this->fileService->attachMany($partnerModelDto->banners, $partner->banners, $partner->banners());

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }

        return $partner;
    }
}
