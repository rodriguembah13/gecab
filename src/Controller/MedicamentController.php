<?php

namespace App\Controller;

use App\Entity\Medicament;
use App\Form\MedicamentType;
use App\Repository\MedicamentRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/medicament")
 *
 * @IsGranted("ROLE_USER")
 */
class MedicamentController extends AbstractController
{
    private $medicamentRepository;

    /**
     * MedicamentController constructor.
     * @param $medicamentRepository
     */
    public function __construct(MedicamentRepository $medicamentRepository)
    {
        $this->medicamentRepository = $medicamentRepository;
    }

    /**
     * @Route("/", name="entity_medicament_index", methods={"GET"})
     */
    public function index(MedicamentRepository $medicamentRepository): Response
    {
        return $this->render('medicament/index.html.twig', [
            'medicaments' => $medicamentRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="medicament_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $medicament = new Medicament();
        $form = $this->createForm(MedicamentType::class, $medicament)
            ->add('saveAndCreateNew', SubmitType::class, [
                'translation_domain' => 'action',
            ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($medicament);
            $entityManager->flush();
            if ($form->get('saveAndCreateNew')->isClicked()) {
                return $this->redirectToRoute('medicament_new');
            }
            return $this->redirectToRoute('entity_medicament_index');
        }

        return $this->render('medicament/new.html.twig', [
            'medicament' => $medicament,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="medicament_show", methods={"GET"})
     */
    public function show(Medicament $medicament): Response
    {
        return $this->render('medicament/show.html.twig', [
            'medicament' => $medicament,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="medicament_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Medicament $medicament): Response
    {
        $form = $this->createForm(MedicamentType::class, $medicament);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('entity_medicament_index');
        }

        return $this->render('medicament/edit.html.twig', [
            'medicament' => $medicament,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="medicament_delete", methods={"POST"})
     */
    public function delete(Request $request, Medicament $medicament): Response
    {
        if ($this->isCsrfTokenValid('delete'.$medicament->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($medicament);
            $entityManager->flush();
        }

        return $this->redirectToRoute('entity_medicament_index');
    }
    /**
     * @Route("/get/getmedicaments", name="medicament_index_ajax", methods={"GET"})
     */
    public function getMedicament(Request $request): JsonResponse
    {
        $array = [];
        $idx = 0;
        try {
            $lists = $this->medicamentRepository->findBy([]);
            foreach ($lists as $local) {
                $temp = [
                    'id' => $local->getId(),
                    'code' => $local->getCode(),
                    'libelle' => $local->getLibelle(),
                    'dosage' => $local->getDosage(),
                    'description' => $local->getDescription(),
                ];
                $array[$idx++] = $temp;
            }

            return new JsonResponse($array,Response::HTTP_OK);
        } catch (\Exception $ex) {
            return new JsonResponse($ex->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
    /**
     * @Route("/get/getonemedicament", name="getonemedicament", methods={"GET"})
     */
    public function getOneMedicament(Request $request): JsonResponse
    {
        try {
            $local = $this->medicamentRepository->find($request->get('id'));
            $temp = [
                'id' => $local->getId(),
                'code' => $local->getCode(),
                'libelle' => $local->getLibelle(),
                'dosage' => $local->getDosage(),
                'description' => $local->getDescription(),
            ];
            return new JsonResponse($temp,Response::HTTP_OK);
        } catch (\Exception $ex) {
            //Log exception
            return new JsonResponse($ex->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
