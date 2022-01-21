<?php

/*
 * This file is part of the AdminLTE-Bundle demo.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Controller;


use App\Repository\ConsultationRepository;
use App\Repository\PatientRepository;
use App\Repository\RendezvousRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;

use Laminas\Json\Expr;
use Ob\HighchartsBundle\Highcharts\Highchart;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

/**
 * Default controller.
 *
 * @IsGranted("ROLE_USER")
 */
class DefaultController extends AbstractController
{
    /**
     * @var AuthorizationCheckerInterface
     */
    private $security;
    private $patientRepository;
    private $userRepository;
    private $consultationRepository;
    private $rendezvousRepository;

    /**
     * DefaultController constructor.
     * @param AuthorizationCheckerInterface $security
     * @param $patientRepository
     * @param $userRepository
     * @param $consultationRepository
     * @param $rendezvousRepository
     */
    public function __construct(AuthorizationCheckerInterface $security, PatientRepository $patientRepository, UserRepository $userRepository, ConsultationRepository $consultationRepository, RendezvousRepository $rendezvousRepository)
    {
        $this->security = $security;
        $this->patientRepository = $patientRepository;
        $this->userRepository = $userRepository;
        $this->consultationRepository = $consultationRepository;
        $this->rendezvousRepository = $rendezvousRepository;
    }


    /**
     * @Route("/admin", defaults={}, name="homepage")
     */
    public function index()
    {
        $day = new \DateTime('now');
        $times = $day->sub(new \DateInterval('P00D'))->getTimestamp();
        return $this->render('default/index.html.twig', [
            'user' => $this->getUser(),
            'consultations' => $this->consultationRepository->count([]),
            'users' => $this->userRepository->count([]),
            'rendezvous' => $this->rendezvousRepository->count(['status' => 'complete']),
            'patients' => $this->patientRepository->count([]),
            'patientsM' => $this->patientRepository->count(['sexe' => 'm']),
            'patientsF' => $this->patientRepository->count(['sexe' => 'f']),
            'datet' => $day->sub(new \DateInterval('P2D')),
            'day' => date('D', $times)
        ]);

    }
    /**
     * @Route("/admin", defaults={}, name="init")
     */
    public function default()
    {
       return $this->redirectToRoute('homepage');
    }
    /**
     * @Route("/get/consultationdashboard", name="consultationdashboard", methods={"GET"})
     */
    public function getConsultationdashboard(Request $request): JsonResponse
    {
        $array = [];
        $idx = 0;
        $day = new \DateTime('now');
        $dayAfter7 = $day->sub(new \DateInterval('P07D'));
        $dayAfter6 = $day->sub(new \DateInterval('P06D'));
        $dayAfter5 = $day->sub(new \DateInterval('P05D'));
        $dayAfter4 = $day->sub(new \DateInterval('P04D'));
        $dayAfter3 = $day->sub(new \DateInterval('P03D'));
        $dayAfter2 = $day->sub(new \DateInterval('P02D'));
        $dayAfter1 = $day->sub(new \DateInterval('P01D'));
        $dayAfter0 = $day->sub(new \DateInterval('P00D'));
        $listDays = ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'];
        $listDay2s = [$dayAfter0, $dayAfter1, $dayAfter2, $dayAfter3, $dayAfter4, $dayAfter5, $dayAfter6, $dayAfter7];
        try {
            //$lists = $this->consultationRepository->findBy(['patient'=>$request->get("id")]);
            // foreach ($listDay2s as $local) {
            for ($i = 0; $i < 8; $i++) {
                //  $i=1;
                $duration = "P" . $i . "D";
                $day1 = new \DateTime('now');
                //date_create_from_format('Y-m-d',$day->format('Y-m-d'));
                $day2 = new \DateTime('now');
                $day3 = new \DateTime('now');
                $timest = $day1->sub(new \DateInterval($duration))->getTimestamp();
                $consuls = $this->consultationRepository->findByExampleField($day2);
                $temp = [
                    'day' => date('D', $timest),
                    'value' => $day3->sub(new \DateInterval($duration))->format('Y-m-d'),
                    'nbre' => sizeof($consuls)
                ];
                $array[$idx++] = $temp;
            }

            return new JsonResponse($array, Response::HTTP_OK);
        } catch (\Exception $ex) {
            //Log exception
            return new JsonResponse($ex->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
