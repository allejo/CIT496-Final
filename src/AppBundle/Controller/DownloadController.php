<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/download")
 */
class DownloadController extends Controller
{
    /**
     * @Route("/image/{name}", name="image_loader")
     *
     * @param string $name The name of the file to serve
     *
     * @return BinaryFileResponse
     */
    public function imageAction($name)
    {
        $rootDir = $this->get('kernel')->getRootDir() . '/../assets/secret/images';

        return (new BinaryFileResponse(
            sprintf('%s/%s', $rootDir, $name)
        ));
    }
}
