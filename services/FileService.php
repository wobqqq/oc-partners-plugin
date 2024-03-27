<?php

declare(strict_types=1);

namespace BlackSeaDigital\Partners\Services;

use October\Rain\Database\Collection;
use October\Rain\Database\Relations\AttachMany;
use October\Rain\Database\Relations\AttachOne;
use System\Models\File;

final class FileService
{
    public function attachOne(?string $newFilePath, ?File $oldFile, AttachOne|AttachMany $attach): void
    {
        $newFileHash = !empty($newFilePath) && file_exists($newFilePath) && is_file($newFilePath)
            ? md5_file($newFilePath)
            : null;
        $oldFileHash = !empty($oldFile) && file_exists($oldFile->getLocalPath())
            ? md5_file($oldFile->getLocalPath())
            : null;

        if ($newFileHash === $oldFileHash) {
            return;
        }

        if (!empty($newFilePath) && file_exists($newFilePath) && is_file($newFilePath)) {
            $newFile = new File();
            $newFile->fromFile($newFilePath);
            $newFile->save();

            $attach->add($newFile);
        }

        if (!empty($oldFile)) {
            $oldFile->deleteThumbs();
            $oldFile->delete();
        }
    }

    public function attachMany(array $newFilePaths, Collection $oldFiles, AttachMany $attach): void
    {
        foreach ($newFilePaths as $newFilePath) {
            $newFileHash = !empty($newFilePath) && file_exists($newFilePath) && is_file($newFilePath)
                ? md5_file($newFilePath)
                : null;

            $oldFile = $oldFiles->first(
                fn(File $oldFile) => $newFileHash === file_exists($oldFile->getLocalPath()) && md5_file(
                        $oldFile->getLocalPath()
                    )
            );

            $this->attachOne($newFilePath, $oldFile, $attach);

            if (!empty($oldFile)) {
                $oldFiles->forget($oldFile);
            }
        }

        foreach ($oldFiles as $oldFile) {
            $oldFile->deleteThumbs();
            $oldFile->delete();
        }
    }
}
