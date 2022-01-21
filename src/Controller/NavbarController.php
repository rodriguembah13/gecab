<?php

/*
 * This file is part of the AdminLTE bundle.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Controller;

use App\Event\NotificationListEvent;
use App\Utils\Constants;
use App\Utils\ContextHelper;
use App\Utils\NotificationModel;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\Response;

class NavbarController extends EmitterController
{
    /**
     * @var int|null
     */
    private $maxNotifications;
    /**
     * @var int|null
     */
    private $maxMessages;
    /**
     * @var int|null
     */
    private $maxTasks;

    public function __construct(EventDispatcherInterface $dispatcher, ContextHelper $helper)
    {
        parent::__construct($dispatcher);
        $this->maxNotifications = $helper->getOption('max_navbar_notifications');
       // $this->maxMessages = $helper->getOption('max_navbar_messages');
       // $this->maxTasks = $helper->getOption('max_navbar_tasks');
    }

    /**
     * @param int|null $max
     * @return Response
     */
    public function notificationsAction($max = null): Response
    {
        if (!$this->hasListener(NotificationListEvent::class)) {
            return new Response();
        }

        if (null === $max) {
            $max = (int) $this->maxNotifications;
        }

        /** @var NotificationListEvent $listEvent */
        $listEvent = $this->dispatch(new NotificationListEvent($max));
        $np=[new NotificationModel('Message 3', Constants::TYPE_INFO),];

        return $this->render(
            'default/notificationNav.html.twig',
            [
                'notifications' => $listEvent->getNotifications(),
                'total' => $listEvent->getTotal(),
            ]
        );
    }
}
