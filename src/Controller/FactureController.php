<?php

namespace App\Controller;

use App\Entity\AntecedantPatient;
use App\Entity\Facture;
use App\Entity\FactureItem;
use App\Form\FactureType;
use App\Repository\ActeMedicalPatientRepository;
use App\Repository\ActeMedicalRepository;
use App\Repository\FactureItemRepository;
use App\Repository\FactureRepository;
use App\Repository\PatientRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/facture")
 *
 * @IsGranted("ROLE_USER")
 */
class FactureController extends AbstractController
{
    private $factureItemRepository;
    private $factureRepository;
    private $acteMedicalRepository;
    private $acteMedicalPatientRepository;
    private $patientRepository;

    /**
     * FactureController constructor.
     * @param $factureItemRepository
     * @param $factureRepository
     * @param $acteMedicalRepository
     */
    public function __construct(ActeMedicalPatientRepository $acteMedicalPatientRepository,PatientRepository $patientRepository,FactureItemRepository $factureItemRepository, FactureRepository $factureRepository, ActeMedicalRepository $acteMedicalRepository)
    {
        $this->factureItemRepository = $factureItemRepository;
        $this->factureRepository = $factureRepository;
        $this->acteMedicalRepository = $acteMedicalRepository;
        $this->patientRepository=$patientRepository;
        $this->acteMedicalPatientRepository=$acteMedicalPatientRepository;

    }

    /**
     * @Route("/", name="facture_index", methods={"GET"})
     */
    public function index(FactureRepository $factureRepository): Response
    {
        return $this->render('facture/index.html.twig', [
            'factures' => $factureRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="facture_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $facture = new Facture();
        $form = $this->createForm(FactureType::class, $facture);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($facture);
            $entityManager->flush();

            return $this->redirectToRoute('facture_index');
        }

        return $this->render('facture/new.html.twig', [
            'facture' => $facture,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="facture_show", methods={"GET"})
     */
    public function show(Facture $facture): Response
    {
        return $this->render('facture/show.html.twig', [
            'facture' => $facture,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="facture_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Facture $facture): Response
    {
        $form = $this->createForm(FactureType::class, $facture);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('facture_index');
        }

        return $this->render('facture/edit.html.twig', [
            'facture' => $facture,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="facture_delete", methods={"POST"})
     */
    public function delete(Request $request, Facture $facture): Response
    {
        if ($this->isCsrfTokenValid('delete'.$facture->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($facture);
            $entityManager->flush();
        }

        return $this->redirectToRoute('facture_index');
    }
    /**
     * @Route("/get/getfactures", name="facture_index_ajax", methods={"GET"})
     */
    public function getFactures(Request $request): JsonResponse
    {
        $array = [];
        $idx = 0;
        try {
            $lists = $this->factureRepository->findBy([]);
            foreach ($lists as $local) {
                $temp = [
                    'id' => $local->getId(),
                    'patient' => $local->getPatient()->getNomComplet(),
                    'created_at' => $local->getCreatedAt()->format("Y-m-d"),
                    'amount' => $local->getAmount(),
                    'amountdue' => $local->getAmountDue(),
                    'status' => $local->getStatus(),
                ];
                $array[$idx++] = $temp;
            }

            return new JsonResponse($array,Response::HTTP_OK);
        } catch (\Exception $ex) {
            return new JsonResponse($ex->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
    /**
     * @Route("/post/postfactureajax", name="postfactureajax", methods={"GET"})
     */
    public function postfactureajax(Request $request): JsonResponse
    {
        $entityManager = $this->getDoctrine()->getManager();
        $idx = 0;

        $patient=$this->patientRepository->find($request->get('patient'));
        $actes=$this->acteMedicalPatientRepository->findBy(['patient'=>$patient,'status'=>'encours']);
        $montant=$request->get('montant');
        $montantht=0.0;
        $montanttva=0.0;
        try {
            $facture=new Facture();

            $facture->setCreatedBy($this->getUser());
            $facture->setCreatedAt(new \DateTime('now'));
            $facture->setPatient($patient);
            $entityManager->persist($facture);
            foreach ($actes as $local) {
                $factureItem= new FactureItem();
                $factureItem->setAmount($local->getAmount());
                $factureItem->setQuantity($local->getQuantity());
                $factureItem->setItem($local->getActeMedical()->getLibelle());
                $factureItem->setTva(0.0);
                $factureItem->setFacture($facture);
                $temp = [
                    'id' => $local->getId(),
                    'item' => $local->getActeMedical()->getLibelle(),
                    'price' => $local->getAmount(),
                    'tva'=> 0.0,
                    'quantite' => $local->getQuantity(),
                    'total' => $local->getQuantity() * $local->getAmount(),
                ];
                $array[$idx++] = $temp;
                $montantht+= ($local->getQuantity() * $local->getAmount());
                $montanttva+= 0.0;
                $entityManager->persist($factureItem);
            }
            $facture->setAmount($montantht);
            $facture->setTotaltva($montanttva);
            $facture->setTotal($montanttva+$montantht);
            $facture->setAmountDue(($montanttva+$montantht)-$montant);
            $temp=[
                'total'=>$facture->getTotal(),
            ];
            $entityManager->persist($facture);
            $entityManager->flush();
            return new JsonResponse($temp,Response::HTTP_OK);
        } catch (\Exception $ex) {
            //Log exception
            return new JsonResponse($ex->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
