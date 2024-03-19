<?php

declare (strict_types = 1);

namespace App\Controller;

use Core\Base\BaseController;
use OpenApi\Attributes as OA;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Utils\Exception\BadRequest;

final class UploadFileController extends BaseController {
    protected $repository;

    public function __construct(ContainerInterface $container) {
        $this->repository = $container->get('UploadFileRepository');
        parent::__construct($container);
    }

    #[OA\Post(
        path: '/v1/UploadFile/CreateFile',
        summary: 'It is used to upload files to the system.',
        tags: ['UploadFile'],
        security: [['Bearer' => []]],
        requestBody: new OA\RequestBody(content: new OA\MediaType(mediaType: 'multipart/form-data', schema: new OA\Schema(type: 'object', properties: [new OA\Property(property: 'file', type: 'file', format: 'binary'), new OA\Property(property: 'fileTitle', type: 'string')]))),
        responses: [new OA\Response(response: 200, description: 'Başarılı', content: new OA\JsonContent(ref: '#/components/schemas/FileModel'))],
    )]
    public function CreateFile(Request $request, Response $response): Response {

        $uploadedFile = $request->getUploadedFiles();
        $createFile = $uploadedFile['file'];
        $fileTitle = $request->getParsedBody()['fileTitle'];

        if ($createFile) {
            if ($createFile->getError() === UPLOAD_ERR_OK) {

                $createItem = $this->repository->CreateFile($createFile, $fileTitle);
                $createItem->url = PROJECT_DOMAIN . $createItem->url;
                return $this->withJson($response, $createItem, 201);

            }
        } else {
            throw new BadRequest('File not found.');
        }

    }

}
