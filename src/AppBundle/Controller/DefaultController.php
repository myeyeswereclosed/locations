<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..'),
        ]);
    }

    /**
     * @Route("/success_mock/")
     */
    public function successfulLocations()
    {
        return
            Response::create(
                '
                {
                    "data": {
                        "locations": [
                            {
                                "name": "Eiffel Tower",
                                "coordinates": {
                                    "lat": 12.34,
                                    "long": 13.24
                                }
                            },
                            {
                                "name": "Moscow Kremlin",
                                "coordinates": {
                                    "lat": 23.21,
                                    "long": 34.21
                                }
                            }
                        ]
                    },
                    "success": true
                }
                '
            );
    }
}
