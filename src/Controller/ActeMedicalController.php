<?php

namespace App\Controller;

use App\Entity\ActeMedical;
use App\Form\ActeMedicalType;
use App\Repository\ActeMedicalRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/acte/medical")
 *
 * @IsGranted("ROLE_USER")
 */
class ActeMedicalController extends AbstractController
{
    private $acteMedicalRepository;

    /**
     * ActeMedicalController constructor.
     * @param $acteMedicalRepository
     */
    public function __construct(ActeMedicalRepository $acteMedicalRepository)
    {
        $this->acteMedicalRepository = $acteMedicalRepository;
    }

    /**
     * @Route("/", name="entity_acte_medical_index", methods={"GET"})
     */
    public function index(ActeMedicalRepository $acteMedicalRepository): Response
    {
        return $this->render('acte_medical/index.html.twig', [
            'acte_medicals' => $acteMedicalRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="entity_acte_medical_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $acteMedical = new ActeMedical();
        $form = $this->createForm(ActeMedicalType::class, $acteMedical)->add('saveAndCreateNew', SubmitType::class, [
            'translation_domain' => 'action',
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($acteMedical);
            $entityManager->flush();
            if ($form->get('saveAndCreateNew')->isClicked()) {
                return $this->redirectToRoute('entity_acte_medical_new');
            }
            return $this->redirectToRoute('entity_acte_medical_index');
        }

        return $this->render('acte_medical/new.html.twig', [
            'acte_medical' => $acteMedical,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="entity_acte_medical_show", methods={"GET"})
     */
    public function show(ActeMedical $acteMedical): Response
    {
        return $this->render('acte_medical/show.html.twig', [
            'acte_medical' => $acteMedical,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="entity_acte_medical_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, ActeMedical $acteMedical): Response
    {
        $form = $this->createForm(ActeMedicalType::class, $acteMedical)->add('saveAndCreateNew', SubmitType::class, [
            'translation_domain' => 'action',
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            if ($form->get('saveAndCreateNew')->isClicked()) {
                return $this->redirectToRoute('entity_acte_medical_index');
            }
            return $this->redirectToRoute('entity_acte_medical_index');
        }

        return $this->render('acte_medical/edit.html.twig', [
            'acte_medical' => $acteMedical,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="entity_acte_medical_delete", methods={"POST"})
     */
    public function delete(Request $request, ActeMedical $acteMedical): Response
    {
        if ($this->isCsrfTokenValid('delete'.$acteMedical->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($acteMedical);
            $entityManager->flush();
        }

        return $this->redirectToRoute('entity_acte_medical_index');
    }
    /**
     * @Route("/get/getactemedicals", name="getactemedicals", methods={"GET"})
     */
    public function getActeMedicaux(Request $request): JsonResponse
    {
        $array = [];
        $idx = 0;
        try {
            $lists = $this->acteMedicalRepository->findBy([]);
            foreach ($lists as $local) {
                $temp = [
                    'id' => $local->getId(),
                    'code' => $local->getCode(),
                    'libelle' => $local->getLibelle(),
                    'prix' => $local->getPrix(),
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
     * @Route("/get/getoneactemedicals", name="getoneactemedicals", methods={"GET"})
     */
    public function getOneActesMedical(Request $request): JsonResponse
    {
        $array = [];
        $idx = 0;
        try {
            $local = $this->acteMedicalRepository->find($request->get('id'));

                $temp = [
                    'id' => $local->getId(),
                    'code' => $local->getCode(),
                    'libelle' => $local->getLibelle(),
                    'prix' => $local->getPrix(),
                ];
                $array[$idx++] = $temp;

            return new JsonResponse($temp,Response::HTTP_OK);
        } catch (\Exception $ex) {
            //Log exception
            return new JsonResponse($ex->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
