<?php

namespace App\Controller;

use App\Entity\Music;
use App\Repository\MusicRepository;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\SerializerInterface;

class ApiController extends AbstractController
{
    /**
     * @Rest\Get("/musics", name="app_api_musics")
     */
    public function getMusics(MusicRepository $musicRepository, SerializerInterface $serializer): JsonResponse
    {
        $musics = $musicRepository->findAll();

        $data = [];
        foreach ($musics as $music) {
            $data[] = [
                'id' => $music->getId(),
                'title' => $music->getTitle(),
                'duration' => $music->getDurationString(),
                'album' => $music->getAlbum()->getTitle(),
            ];
        }

        $json = $serializer->serialize($data, 'json');

        return new JsonResponse($json, Response::HTTP_OK, [], true);
    }
}
