<?php

namespace App\Controller;

use App\Entity\Rendezvous;
use App\Form\RendezvousType;
use App\Repository\PatientRepository;
use App\Repository\RendezvousRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/rendezvous")
 *
 * @IsGranted("ROLE_USER")
 */
class RendezvousController extends AbstractController
{
    private $rendezvousRepository;
    private $patientrepository;

    /**
     * RendezvousController constructor.
     * @param $rendezvousRepository
     * @param $patientrepository
     */
    public function __construct(RendezvousRepository $rendezvousRepository, PatientRepository $patientrepository)
    {
        $this->rendezvousRepository = $rendezvousRepository;
        $this->patientrepository = $patientrepository;
    }

    /**
     * @Route("/", name="home_rendezvous_index", methods={"GET"})
     */
    public function index(RendezvousRepository $rendezvousRepository): Response
    {
        return $this->render('rendezvous/index.html.twig', [
            'rendezvouses' => $rendezvousRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="rendezvous_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $rendezvou = new Rendezvous();
        $form = $this->createForm(RendezvousType::class, $rendezvou);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $rendezvou->setMedecin($this->getUser());
            $rendezvou->setCreatedAt(new \DateTime('now'));
            $rendezvou->setLibelle("Rdv ".$rendezvou->getPatient());
            $entityManager->persist($rendezvou);
            $entityManager->flush();

            return $this->redirectToRoute('home_rendezvous_index');
        }

        return $this->render('rendezvous/new.html.twig', [
            'rendezvou' => $rendezvou,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="rendezvous_show", methods={"GET"})
     */
    public function show(Rendezvous $rendezvou): Response
    {
        return $this->render('rendezvous/show.html.twig', [
            'rendezvou' => $rendezvou,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="rendezvous_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Rendezvous $rendezvou): Response
    {
        $form = $this->createForm(RendezvousType::class, $rendezvou);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('home_rendezvous_index');
        }

        return $this->render('rendezvous/edit.html.twig', [
            'rendezvou' => $rendezvou,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="rendezvous_delete", methods={"POST"})
     */
    public function delete(Request $request, Rendezvous $rendezvou): Response
    {
        if ($this->isCsrfTokenValid('delete'.$rendezvou->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($rendezvou);
            $entityManager->flush();
        }

        return $this->redirectToRoute('home_rendezvous_index');
    }
    /**
     * @Route("/get/geteventsrendezvous", name="geteventsrendezvous", methods={"GET"})
     */
    public function getRendezVous(Request $request): JsonResponse
    {
        $array = [];
        $idx = 0;
        try {
            $lists = $this->rendezvousRepository->findBy([]);
            foreach ($lists as $local) {
                $temp = [
                    'groupId' => $local->getId(),
                    'title' => $local->getLibelle().'-'.$local->getMedecin(),
                    'start' => $local->getDateRdv()->format('Y-m-d h:m'),
                ];
                $array[$idx++] = $temp;
            }
            $array_final=[
                'events'=>$array,
            ];

            return new JsonResponse($array,Response::HTTP_OK);
        } catch (\Exception $ex) {
            //Log exception
            return new JsonResponse($ex->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
    /**
     * @Route("/get/getindexsrendezvous", name="getindexsrendezvous", methods={"GET"})
     */
    public function getRendezVousIndexAjax(Request $request): JsonResponse
    {
        $array = [];
        $idx = 0;
        try {
            $lists = $this->rendezvousRepository->findBy([]);
            foreach ($lists as $local) {
                $temp = [
                    'id' => $local->getId(),
                    'patient' => $local->getPatient()->getNomComplet(),
                    'medecin' => $local->getMedecin()->getFullName(),
                    'libelle' => $local->getLibelle(),
                    'status' => $local->getStatus(),
                    'daterv' => $local->getDateRdv()->format('Y-m-d'),
                ];
                $array[$idx++] = $temp;
            }
            $array_final=[
                'events'=>$array,
            ];

            return new JsonResponse($array,Response::HTTP_OK);
        } catch (\Exception $ex) {
            //Log exception
            return new JsonResponse($ex->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
