<?php

namespace App\Controller;

use App\Entity\Ordonnance;
use App\Entity\Prescription;
use App\Form\OrdonnanceType;
use App\Repository\MedicamentRepository;
use App\Repository\OrdonnanceRepository;
use App\Repository\PatientRepository;
use App\Repository\PrescriptionRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/ordonnance")
 *
 * @IsGranted("ROLE_USER")
 */
class OrdonnanceController extends AbstractController
{
    private $ordonanceRepository;
    private $patientRepository;
    private $prescriptionRepository;
    private $medicamentRepository;

    /**
     * OrdonnanceController constructor.
     * @param $ordonanceRepository
     * @param $patientRepository
     * @param $prescriptionRepository
     * @param $medicamentRepository
     */
    public function __construct(OrdonnanceRepository $ordonanceRepository,PatientRepository $patientRepository,PrescriptionRepository $prescriptionRepository, MedicamentRepository $medicamentRepository)
    {
        $this->ordonanceRepository = $ordonanceRepository;
        $this->patientRepository = $patientRepository;
        $this->prescriptionRepository = $prescriptionRepository;
        $this->medicamentRepository = $medicamentRepository;
    }

    /**
     * @Route("/", name="consult_ordonnance_index", methods={"GET"})
     */
    public function index(OrdonnanceRepository $ordonnanceRepository): Response
    {
        return $this->render('ordonnance/index.html.twig', [
            'ordonnances' => $ordonnanceRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="ordonnance_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $ordonnance = new Ordonnance();
        $form = $this->createForm(OrdonnanceType::class, $ordonnance);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($ordonnance);
            $entityManager->flush();

            return $this->redirectToRoute('ordonnance_index');
        }

        return $this->render('ordonnance/new.html.twig', [
            'ordonnance' => $ordonnance,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="ordonnance_show", methods={"GET"})
     */
    public function show(Ordonnance $ordonnance): Response
    {
        return $this->render('ordonnance/show.html.twig', [
            'ordonnance' => $ordonnance,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="ordonnance_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Ordonnance $ordonnance): Response
    {
        $form = $this->createForm(OrdonnanceType::class, $ordonnance);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('ordonnance_index');
        }

        return $this->render('ordonnance/edit.html.twig', [
            'ordonnance' => $ordonnance,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="ordonnance_delete", methods={"POST"})
     */
    public function delete(Request $request, Ordonnance $ordonnance): Response
    {
        if ($this->isCsrfTokenValid('delete'.$ordonnance->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($ordonnance);
            $entityManager->flush();
        }

        return $this->redirectToRoute('ordonnance_index');
    }
    /**
     * @Route("/post/saveordonance", name="saveordonance", methods={"GET","POST"})
     */
    public function postProduct(Request $request): JsonResponse
    {
        $entityManager = $this->getDoctrine()->getManager();
        $data = json_decode($request->getContent(), true);
        $ob = $data['ob'];
        $patient = $this->patientRepository->find($data['patient']);
       // $entrepot = $this->entrepotRepository->find($data['entrepot']);
        if ( null == $patient || null==$this->getUser()) {
            return new JsonResponse('error', 404);
        }
        $total = 0.0;
        $ord = new Ordonnance();
        $ord->setMedecin($this->getUser());
        $ord->setPatient($patient);
        $ord->setCreatedAt(new \DateTime('now'));
        $ord->setStatus('');
        $entityManager->persist($ord);
        for ($i = 0; $i < sizeof($ob); ++$i) {
            $product = $this->medicamentRepository->find($ob[$i]['id']);
            $quantity = $ob[$i]['quantity'];
            $taux = $ob[$i]['dosage'];
            $lineOrder = new Prescription();
            $lineOrder->setMedicament($product);
            $lineOrder->setQuantite($quantity);
            $lineOrder->setOrdonance($ord);
            $lineOrder->setDosage($taux);
            $entityManager->persist($lineOrder);
        }
        $entityManager->flush();
        return new JsonResponse($ord, 200);
    }
    /**
     * @Route("/get/getprescription", name="prescription_index_ajax", methods={"GET"})
     */
    public function getPrescriptions(Request $request): JsonResponse
    {
        $array = [];
        $idx = 0;
        try {
            $ordonance=$this->ordonanceRepository->find($request->get('ordonance'));
            $lists = $this->prescriptionRepository->findBy(['ordonance'=>$request->get('ordonance')]);
            foreach ($lists as $local) {
                $temp = [
                    'id' => $local->getId(),
                    'code' => $local->getMedicament()->getCode(),
                    'libelle' => $local->getMedicament()->getLibelle(),
                    'dosage' => $local->getDosage(),
                    'quantity' => $local->getQuantite(),
                    'medicament_id' => $local->getMedicament()->getId(),
                ];
                $array[$idx++] = $temp;
            }
            $array_final=[
                "patient"=>$ordonance->getPatient()->getNomComplet(),
                "data"=>$array
            ];

            return new JsonResponse($array_final,Response::HTTP_OK);
        } catch (\Exception $ex) {
            return new JsonResponse($ex->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
