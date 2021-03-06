<?php

namespace App\Controller;

use App\Entity\Patient;
use App\Form\PatientType;
use App\Repository\AntecedantPatientRepository;
use App\Repository\ConsultationRepository;
use App\Repository\PatientRepository;
use App\Repository\RendezvousRepository;
use Doctrine\ORM\QueryBuilder;
use Omines\DataTablesBundle\Adapter\Doctrine\ORMAdapter;
use Omines\DataTablesBundle\Column\TextColumn;
use Omines\DataTablesBundle\Column\TwigColumn;
use Omines\DataTablesBundle\DataTableFactory;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/patient")
 *
 * @IsGranted("ROLE_USER")
 */
class PatientController extends AbstractController
{
    private $patientRepository;
    private $consultationRepository;
    private $rendezvousRepository;
    private $antecedantRepository;
    private $dataTableFactory;

    /**
     * PatientController constructor.
     * @param $patientRepository
     */
    public function __construct(DataTableFactory $dataTableFactory,AntecedantPatientRepository $antecedantPatientRepository,ConsultationRepository $consultationRepository,RendezvousRepository $rendezvousRepository,PatientRepository $patientRepository)
    {
        $this->patientRepository = $patientRepository;
        $this->consultationRepository=$consultationRepository;
        $this->rendezvousRepository=$rendezvousRepository;
        $this->antecedantRepository=$antecedantPatientRepository;
        $this->dataTableFactory=$dataTableFactory;
    }

    /**
     * @Route("/", name="patient_index", methods={"GET","POST"})
     */
    public function index(Request $request): Response
    {
        $table = $this->dataTableFactory->create()

            ->add('code', TextColumn::class, [
                'label' => 'code',
            ])
            ->add('nomComplet', TextColumn::class,[
                'label' => 'name',
            ])
            ->add('sexe', TextColumn::class,[
                'label' => 'sexe',
            ])
            ->add('telephone', TextColumn::class,[
                'label' => 'phone',
            ])
            ->add('profession', TextColumn::class,[
                'label' => 'profession',
            ])
            ->add('situationfamiliale', TextColumn::class,[
                'label' => 'status',
            ])
            ->add('id', TwigColumn::class, [
                'className' => 'buttons',
                'label' => 'action',
                'template' => 'patient/button.html.twig',
                'render' => function ($value, $context) {
                    return $value;
                }])
            ->createAdapter(ORMAdapter::class, [
                'entity' => Patient::class,
                'query' => function (QueryBuilder $builder) {
                    $builder
                        ->select('e')
                        ->from(Patient::class, 'e')
                        ->orderBy('e.id', 'DESC')
                    ;
                }
            ])->handleRequest($request);
        if ($table->isCallback()) {
            return $table->getResponse();
        }
        return $this->render('patient/index.html.twig', [
            'datatable' => $table
        ]);
    }

    /**
     * @Route("/new", name="patient_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $patient = new Patient();
        $form = $this->createForm(PatientType::class, $patient);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $imageFilename = $form['photo']->getData();
            if ($imageFilename) {
                $destination = $this->getParameter('kernel.project_dir').'/public/uploads/patient/';
                $originalFilename = pathinfo($imageFilename->getClientOriginalName(), PATHINFO_FILENAME);
                $newFilename = $originalFilename.'-'.uniqid().'.'.$imageFilename->guessExtension();

                try {
                    $imageFilename->move(
                        $destination,
                        $newFilename
                    );
                } catch (FileException $e) {
                }
                $patient->setPhoto($newFilename);
            }
            $entityManager->persist($patient);
            $entityManager->flush();
            $this->getDoctrine()->getManager()->flush();
            $url = $this->generateUrl('patient_show', ['id' => $patient->getId()]);
            $this->addFlash('success', 'Operation execut??e avec success');

            return $this->redirect($url);
        }

        return $this->render('patient/new.html.twig', [
            'patient' => $patient,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="patient_show", methods={"GET"})
     */
    public function show(Patient $patient): Response
    {
        return $this->render('patient/show.html.twig', [
            'patient' => $patient,
            'consultations'=>$this->consultationRepository->findBy(['patient'=>$patient]),
            'rendezvous'=>$this->rendezvousRepository->findBy(['patient'=>$patient]),
            'antecedants'=>$this->antecedantRepository->findBy(['patient'=>$patient]),
        ]);
    }

    /**
     * @Route("/{id}/edit", name="patient_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Patient $patient): Response
    {
        $form = $this->createForm(PatientType::class, $patient);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $imageFilename = $form['photo']->getData();
            if ($imageFilename) {
                $destination = $this->getParameter('kernel.project_dir').'/public/uploads/patient/';
                $originalFilename = pathinfo($imageFilename->getClientOriginalName(), PATHINFO_FILENAME);
                $newFilename = $originalFilename.'-'.uniqid().'.'.$imageFilename->guessExtension();

                try {
                    $imageFilename->move(
                        $destination,
                        $newFilename
                    );
                } catch (FileException $e) {
                }
                $patient->setPhoto($newFilename);
            }
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('patient_index');
        }

        return $this->render('patient/edit.html.twig', [
            'patient' => $patient,
            'form' => $form->createView(),
            'age'=>$patient->calulAge()
        ]);
    }

    /**
     * @Route("/{id}", name="patient_delete", methods={"POST"})
     */
    public function delete(Request $request, Patient $patient): Response
    {
        if ($this->isCsrfTokenValid('delete'.$patient->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($patient);
            $entityManager->flush();
        }

        return $this->redirectToRoute('patient_index');
    }
    /**
     * @Route("/get/getpatients", name="patient_index_ajax", methods={"GET"})
     */
    public function getPatients(Request $request): JsonResponse
    {
       // $product = $this->productRepository->find($request->query->getInt('id_product'));
        $array = [];
        $idx = 0;
        try {
            $lists = $this->patientRepository->findBy([]);
            foreach ($lists as $local) {
                $temp = [
                    'id' => $local->getId(),
                    'code' => $local->getCode(),
                    'phone' => $local->getTelephone(),
                    'name' => $local->getNomComplet(),
                    'civilite' => $local->getCivilite(),
                    'adresse' => $local->getAdresse(),
                    'profession' => $local->getProfession(),
                    'situation' => $local->getSituationfamiliale(),
                    'sexe' => $local->getSexe(),
                    'birtday'=>$local->getDateNaissance()->format('Y-m-d')
                ];
                $array[$idx++] = $temp;
            }

            return new JsonResponse($array,Response::HTTP_OK);
        } catch (\Exception $ex) {
            //Log exception
            return new JsonResponse($ex->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
