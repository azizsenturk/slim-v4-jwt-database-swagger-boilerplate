<?php

declare (strict_types = 1);

namespace App\Repository;

use App\Model\UploadFile\FileModel;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\UploadedFileInterface as UploadedFile;
use Utils\Libs\Converter;
use Utils\Service\Generator;
use Utils\Service\JWTService;
use \Gumlet\ImageResize;

class UploadFileRepository {
    private $pdo, $table;

    public function __construct(ContainerInterface $container) {
        $this->pdo = $container->get('pdo');
        $this->table = 'files';
    }

    public function CreateFile(UploadedFile $createFile, ?string $fileTitle = null): FileModel {

        $uploadFolderDir = DIRECTORY_SEPARATOR . 'uploads';
        $this->isFolderExists($uploadFolderDir);

        $originalFileName = $this->explodeFileName($createFile->getClientFilename())['name'];
        $createItem = [
            'uploadDir' => $uploadFolderDir,
            'uniqId' => Generator::UniqId($this->table),
            'file' => $createFile,
            'fileType' => strtolower(explode('/', $createFile->getClientMediaType())[0]),
            'fileSize' => $createFile->getSize(),
            'fileName' => @$fileTitle ? $fileTitle : $originalFileName,
            'extension' => $this->explodeFileName($createFile->getClientFilename())['extension'],
            'fileSlug' => @$fileTitle ? Generator::Slug($fileTitle) : Generator::Slug($originalFileName),
        ];

        if (strpos($createItem['fileType'], 'image') !== false) {
            $uploadedFileInfo = $this->uploadFileToHost($createItem, 'images');
            $this->resizeToImage($uploadedFileInfo, IMAGE_RESIZE_LONG_SIDE);
            $this->cropToImage($uploadedFileInfo, IMAGE_CROP_SIZE);
        } else if (strpos($createItem['fileType'], 'audio') !== false) {
            $uploadedFileInfo = $this->uploadFileToHost($createItem, 'audios');
        } else if (strpos($createItem['fileType'], 'video') !== false) {
            $uploadedFileInfo = $this->uploadFileToHost($createItem, 'videos');
        } else {
            $uploadedFileInfo = $this->uploadFileToHost($createItem, 'files');
        }

        return new FileModel($uploadedFileInfo);

    }

    private function uploadFileToHost(array $payloadData, ?string $folderPath = null): array {
        $data = $payloadData;

        $uploadFolderDir = $data['uploadDir'] . ($folderPath ? DIRECTORY_SEPARATOR . $folderPath : '');
        $this->isFolderExists($uploadFolderDir);

        $newFile = $this->getRightFileSlug($uploadFolderDir, Converter::ToObject($data));

        $createItem = [
            'id' => $data['uniqId'],
            'userId' => JWTService::GetInfo('userId') ?? null,
            'name' => $data['fileName'],
            'extension' => $data['extension'],
            'size' => $data['fileSize'],
            'url' => $newFile['fileUrl'],
            'type' => $data['fileType'],
        ];

        $data['file']->moveTo(APP_ROOT . $uploadFolderDir . DIRECTORY_SEPARATOR . $newFile['fileSlug'] . '.' . $data['extension']);
        $this->pdo->table($this->table)->insert($createItem);

        return $createItem;
    }

    private function resizeToImage(array $payloadData, ?int $imageSize = 1024) {
        $data = Converter::ToObject($payloadData);

        $itemFullUrl = $data->url;
        $explodedFullUrl = explode(DIRECTORY_SEPARATOR, $itemFullUrl);
        $uploadFolderDir = str_replace(end($explodedFullUrl), '', $itemFullUrl);
        $fileSlug = end($explodedFullUrl);
        $fileExtension = $data->extension;

        $uploadFolderDir = $uploadFolderDir . DIRECTORY_SEPARATOR . 'optimized';
        $this->isFolderExists($uploadFolderDir);

        $image = new ImageResize(APP_ROOT . $itemFullUrl);
        $image->resizeToLongSide($imageSize, true);
        $image->save(APP_ROOT . $uploadFolderDir . DIRECTORY_SEPARATOR . $fileSlug, $this->fileSaveExtension($fileExtension));

    }

    private function cropToImage(array $payloadData, ?int $imageSize = 1024) {
        $data = Converter::ToObject($payloadData);

        $itemFullUrl = $data->url;
        $explodedFullUrl = explode(DIRECTORY_SEPARATOR, $itemFullUrl);
        $uploadFolderDir = str_replace(end($explodedFullUrl), '', $itemFullUrl);
        $fileSlug = end($explodedFullUrl);
        $fileExtension = $data->extension;

        $uploadFolderDir = $uploadFolderDir . DIRECTORY_SEPARATOR . 'cropped';
        $this->isFolderExists($uploadFolderDir);

        $image = new ImageResize(APP_ROOT . $itemFullUrl);
        $image->resizeToShortSide($imageSize, true);
        $image->crop($imageSize, $imageSize, true);
        $image->save(APP_ROOT . $uploadFolderDir . DIRECTORY_SEPARATOR . $fileSlug, $this->fileSaveExtension($fileExtension));

    }

    private function isFolderExists(string $folderDir) {
        if (!file_exists(APP_ROOT . $folderDir)) {mkdir(APP_ROOT . $folderDir);}
    }

    private function explodeFileName(string $fileName): array {
        $explodedFileName = explode('.', $fileName);
        $fileExtension = end($explodedFileName);
        $fileName = str_replace('.' . $fileExtension, '', $fileName);
        return ['name' => $fileName, 'extension' => $fileExtension];
    }

    private function getRightFileSlug(string $uploadFolderDir, object $data): array {
        $fileSlug = $data->fileSlug;
        $fileUrl = $uploadFolderDir . DIRECTORY_SEPARATOR . $fileSlug . '.' . $data->extension;

        $count = 1;
        while ($this->isFileExists($fileUrl)) {
            $count++;
            $fileSlug = $data->fileSlug . '-' . $count;
            $fileUrl = $uploadFolderDir . DIRECTORY_SEPARATOR . $fileSlug . '.' . $data->extension;
        }

        return ['fileSlug' => $fileSlug, 'fileUrl' => $fileUrl];
    }

    private function isFileExists(string $url): bool {
        $count = $this->pdo->table($this->table)->like('url', "%$url%")->count('url', 'total')->get();
        return $count->total > 0;
    }

    private function fileSaveExtension(string $fileType) {
        if ($fileType == 'png') {
            return IMAGETYPE_PNG;
        } else if ($fileType == 'gif') {
            return IMAGETYPE_GIF;
        } else {
            return IMAGETYPE_JPEG;
        }
    }

}
