<?php

namespace AppBundle\Controller;

use AppBundle\Entity\SubTrip;
use AppBundle\Entity\Trip;
use AppBundle\Form\TripType;
use AppBundle\Model\TripModel;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class TripController extends Controller
{
    /**
     * @Route("/trip", name="trip")
     *
     * @param Request $request
     * @param int $items
     * @return Response
     * @internal param int $page
     */
    public function listAction(Request $request, $items = 10)
    {
        $page = $request->query->get('page', 1);
        $tripModel = new TripModel($this->getDoctrine());

        $trips = $tripModel->findLatest($page, $items);

        $content = $this->render(':trip:list.html.twig', [
            'trips' => $trips,
            'filter' => $request->query->all(),
            'page' => $page,
            'pages' => 2,
        ]);

        return new Response($content);
    }

    /**
     * @Route("/trip/{id}", name="trip_show_details",
     *     requirements={"id": "\d+"})
     *
     * @param Trip $trip The trip to show
     * @return Response
     */
    public function showAction(Trip $trip)
    {
        $content = $this->render(':trip:show.html.twig', [
            'trip' => $trip,
        ]);

        return new Response($content);
    }

    /**
     * Create a new trip
     *
     * @Route("/trip/create", name="trip_create")
     *
     * @param Request $request
     * @return Response
     */
    public function createAction(Request $request)
    {
        $trip = new Trip();
        $trip->addSubtrip(new SubTrip);

        $createForm = $this->createForm(TripType::class, $trip);
        $createForm->handleRequest($request);

        if ($createForm->isSubmitted() && $createForm->isValid()) {
            $trip
                ->setCreatedAt(new \DateTime)
                ->setCreatedBy($this->getUser());

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($trip);
            $entityManager->flush();

            $this->addFlash('success', 'trip.updated_successfully');

            return $this->redirectToRoute('trip');
        }

        return $this->render(':trip:createOrUpdate.html.twig', [
            'create' => true,
            'form' => $createForm->createView(),
        ]);
    }

    /**
     * @Route("/trip/{id}/update", name="trip_update",
     *     requirements={"id": "\d+"})
     *
     * @param Request $request
     * @param Trip $trip The trip to update
     * @return Response
     */
    public function updateAction(Request $request, Trip $trip)
    {
        $member = $this->getUser();
        if ($trip->getCreatedBy() !== $member) {
            throw new AccessDeniedException();
        }

        $updateForm = $this->createForm(TripType::class, $trip);

        $updateForm->handleRequest($request);

        if ($updateForm->isSubmitted() && $updateForm->isValid()) {
            $trip
                ->setUpdatedAt(new \DateTime);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($trip);
            $entityManager->flush();

            $this->addFlash('success', 'trip.updated_successfully');

            return $this->redirectToRoute('trip');
        }

        return $this->render(':trip:createOrUpdate.html.twig', [
            'create' => false,
            'form' => $updateForm->createView(),
        ]);
    }
}
