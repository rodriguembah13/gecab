<?php

namespace App\Controller;

use App\Entity\Notification;
use App\Entity\Patient;
use App\Entity\SalleAttente;
use App\Form\PatientType;
use App\Form\SalleAttenteType;
use App\Repository\SalleAttenteRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/salle/attente")
 *
 * @IsGranted("ROLE_USER")
 */
class SalleAttenteController extends AbstractController
{
    private $salledattenteRepository;

    /**
     * SalleAttenteController constructor.
     * @param $salledattenteRepository
     */
    public function __construct(SalleAttenteRepository $salledattenteRepository)
    {
        $this->salledattenteRepository = $salledattenteRepository;
    }

    /**
     * @Route("/", name="home_salle_attente_index", methods={"GET"})
     */
    public function index(SalleAttenteRepository $salleAttenteRepository): Response
    {
        return $this->render('salle_attente/index.html.twig', [
            'salle_attentes' => $salleAttenteRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="home_salle_attente_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $salleAttente = new SalleAttente();
        $form = $this->createForm(SalleAttenteType::class, $salleAttente);
        $form->handleRequest($request);
        $patient = new Patient();
        $formpatient = $this->createForm(PatientType::class, $patient);
        $formpatient->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $salleAttente->setStatus('attente');
            $salleAttente->setCreatedBy($this->getUser());
            $salleAttente->setHeureArrive(new \DateTimeImmutable('now'));
            $notification=new Notification();
            $notification->setType('salleattente');
            $notification->setStatus('encours');
            $notification->setSender($this->getUser()->getFullName());
            $notification->setMessage("New ".$salleAttente->getMotif());
            $notification->setReceiver($form['medecin']->getData());
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($salleAttente);
            $entityManager->flush();
            $notification->setNotifiedId($salleAttente->getId());
            $entityManager->persist($notification);
            $entityManager->flush();

            return $this->redirectToRoute('home_salle_attente_index');
        }
        if ($formpatient->isSubmitted() && $formpatient->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($patient);
            $entityManager->flush();

            return $this->redirectToRoute('home_salle_attente_new');
        }
        return $this->render('salle_attente/new.html.twig', [
            'salle_attente' => $salleAttente,
            'form' => $form->createView(),
            'formpatient' => $formpatient->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="home_salle_attente_show", methods={"GET"})
     */
    public function show(SalleAttente $salleAttente): Response
    {
        return $this->render('salle_attente/show.html.twig', [
            'salle_attente' => $salleAttente,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="home_salle_attente_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, SalleAttente $salleAttente): Response
    {
        $form = $this->createForm(SalleAttenteType::class, $salleAttente);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('home_salle_attente_index');
        }

        return $this->render('salle_attente/edit.html.twig', [
            'salle_attente' => $salleAttente,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="salle_attente_delete", methods={"POST"})
     */
    public function delete(Request $request, SalleAttente $salleAttente): Response
    {
        if ($this->isCsrfTokenValid('delete'.$salleAttente->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($salleAttente);
            $entityManager->flush();
        }

        return $this->redirectToRoute('home_salle_attente_index');
    }
    /**
     * @Route("/get/getsalleattente", name="salle_attente_index_ajax", methods={"GET"})
     */
    public function getPatients(Request $request): JsonResponse
    {
        // $product = $this->productRepository->find($request->query->getInt('id_product'));
        $array = [];
        $idx = 0;
        try {
            $lists = $this->salledattenteRepository->findBystaut();
            foreach ($lists as $local) {
                $temp = [
                    'id' => $local->getId(),
                    'begin' => $local->getHeureArrive()->format('H:i:s'),
                    'end' => $local->getHeureFin()? $local->getHeureFin()->format('H:i:s'): '',
                    'motif' => $local->getMotif(),
                    'patient' => $local->getPatient()->getNomComplet(),
                    'patient_id' => $local->getPatient()->getId(),
                    'status'=>$local->getStatus(),
                    'day'=>$local->getCreatedAt()->format('Y-m-d')
                ];
                $array[$idx++] = $temp;
            }

            return new JsonResponse($array,Response::HTTP_OK);
        } catch (\Exception $ex) {
            //Log exception
            return new JsonResponse($ex->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
    /**
     * @Route("/get/getonesalleattente", name="getonesalleattente", methods={"GET"})
     */
    public function getSalleOne(Request $request): JsonResponse
    {
        try {
            $local = $this->salledattenteRepository->find($request->get('id'));
                $temp = [
                    'id' => $local->getId(),
                    'begin' => $local->getHeureArrive()->format('H:i:s'),
                    'end' => $local->getHeureFin()? $local->getHeureFin()->format('H:i:s'): '',
                    'motif' => $local->getMotif(),
                    'patient' => $local->getPatient()->getNomComplet(),
                    'patient_id' => $local->getPatient()->getId(),
                    'status'=>$local->getStatus(),
                    'day'=>$local->getCreatedAt()->format('Y-m-d')
                ];
            return new JsonResponse($temp,Response::HTTP_OK);
        } catch (\Exception $ex) {
            //Log exception
            return new JsonResponse($ex->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
