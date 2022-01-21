<?php

namespace App\EventSubscriber;

use App\Event\NotificationListEvent;
use App\Repository\NotificationRepository;
use App\Utils\Constants;
use App\Utils\NotificationModel;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ControllerEvent;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\Security\Core\Security;

class NotificationSubscriber implements EventSubscriberInterface
{
    private $notificationRepository;
    /**
     * @var AuthorizationCheckerInterface
     */
    private $security;


    /**
     * @param AuthorizationCheckerInterface $security
     */
    public function __construct(NotificationRepository $notificationRepository,Security $security)
    {
        $this->security = $security;
        $this->notificationRepository=$notificationRepository;
    }


    public static function getSubscribedEvents()
    {
        return [
            NotificationListEvent::class => ['onNotifications', 100],
        ];
    }
    /**
     * @param NotificationListEvent $event
     */
    public function onNotifications(NotificationListEvent $event)
    {
        $notifications=$this->notificationRepository->findBy(['receiver'=>$this->security->getUser(),'status'=>'encours']);
        foreach ($notifications as $notifi){
            $notification = new NotificationModel();

            $notification
                ->setId($notifi->getNotifiedId())
                ->setMessage($notifi->getMessage())
                ->setType($notifi->getType())
                ->setIcon($notifi->getSender())
            ;
            $event->addNotification($notification);
        }

     /*

        $event->addNotification(new NotificationModel('Another message', Constants::TYPE_ERROR));
        $event->addNotification(new NotificationModel('Message 3', Constants::TYPE_INFO));
        $event->addNotification(new NotificationModel('Message 4', Constants::TYPE_WARNING));
        $event->addNotification(new NotificationModel('Message 5', Constants::TYPE_INFO, 'far fa-flag'));
        $event->addNotification(new NotificationModel('Message 6', Constants::TYPE_SUCCESS));
        $event->addNotification(new NotificationModel('Message 7', Constants::TYPE_SUCCESS));
        if (!$this->security->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            return;
        }

        $notification = new NotificationModel('You are logged-in!', Constants::TYPE_SUCCESS, 'fas fa-sign-in-alt');
        $notification->setId(2);
        $event->addNotification($notification);*/
    }
}
