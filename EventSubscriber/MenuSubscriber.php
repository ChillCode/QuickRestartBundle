<?php

/**
 * QuickRestartBundle
 *
 * @package QuickRestartBundle
 *
 * Copyright: (c) 2003 Chillcode
 */

namespace KimaiPlugin\QuickRestartBundle\EventSubscriber;

use App\Event\ConfigureMainMenuEvent;
use App\Utils\MenuItemModel;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class MenuSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents(): array
    {
        return [
            ConfigureMainMenuEvent::class => ['onMenuConfigure', 100],
        ];
    }

    public function onMenuConfigure(ConfigureMainMenuEvent $event): void
    {
        $model = new MenuItemModel(
            'quickRestartBundle',
            'Quick Restart',
            'quick_start',
            [],
            'fas fa-play',
        );

        $event->getMenu()->addChild($model);
    }
}
