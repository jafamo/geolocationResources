<?php

namespace App\Controller;

use App\Entity\Location;
use App\Form\LocationType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

class LocationController extends AbstractController
{
    #[Route('/location', name: 'app_location')]
    public function index(Request $request): Response
    {
        $googleMapsApiKey = $this->getParameter('google_maps_api_key');

        // Crear una nueva instancia de la entidad Location
        $location = new Location();

        // Crear el formulario
        $form = $this->createForm(LocationType::class, $location);

        // Manejar la solicitud POST
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Obtener la dirección desde el formulario
            $direccion = $location->getAddress();

            // Llamar a la API de Google Maps para obtener la latitud y longitud
            $url = 'https://maps.googleapis.com/maps/api/geocode/json?address=' . urlencode($direccion) . '&key=' . $googleMapsApiKey;
            $response = file_get_contents($url);
            $data = json_decode($response, true);

            if (!empty($data['results'])) {
                $coordenadas = $data['results'][0]['geometry']['location'];
                $location->setLatitude($coordenadas['lat']);
                $location->setLongitude($coordenadas['lng']);
            }

//             Persistir los datos de la ubicación
//            $entityManager = $this->getDoctrine()->getManager();
//            $entityManager->persist($location);
//            $entityManager->flush();
        }

        return $this->render('mapa/index2.html.twig', [
            'form' => $form->createView(),
            'location' => $location,
            'google_maps_api_key' => $googleMapsApiKey
        ]);

    }
}
