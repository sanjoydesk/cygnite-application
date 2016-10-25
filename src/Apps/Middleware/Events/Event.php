<?php
/*
 * This file is part of the Cygnite package.
 *
 * (c) Sanjoy Dey <dey.sanjoy0@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Apps\Middleware\Events;

use Cygnite\Container\ContainerAwareInterface;
use Cygnite\EventHandler\Event as EventListener;

/**
 * Class Event
 *
 * @package Apps\Middleware\Events
 */
class Event
{
    /** @var EventListener */
    protected $event;

    /**
     * The event handler mappings for the application.
     * You can add number of event in below array, When ever
     * you try to call/fire specified method before and after event will
     * get executed
     *
     * <code>
     * 'event.name' => '\Apps\Resources\Extensions\Api@run'
     *
     *  will executes
     *
     *  public function beforeRun() {}
     *  public function run() {}
     *  public function afterRun() {}
     *
     * $this->fire('event.api.run');
     * </code>
     *
     * @var array
     */
    protected $listen = [
        'event.api.run' => '\Apps\Resources\Extensions\Api@run',
    ];

    /**
     * Event constructor.
     *
     * @param EventListener $event
     */
    public function __construct(EventListener $event)
    {
        $this->event = $event;
    }

    /**
     * Activate application event, return true/false.
     *
     * @return bool
     */
    public function isAppEventEnabled() : bool
    {
        return true;
    }

    /**
     * This events will get executed before and after
     * Application::bootApplication() method.
     *
     * @return array
     */
    public function registerAppEvents() : array
    {
        return [
            'beforeBootingApplication' => '\Apps\Resources\Extensions\Api@payment',
            'afterBootingApplication' => '\Apps\Resources\Extensions\Api@paymentSuccess'
        ];
    }

    /**
     * Returns EventListener Instance.
     *
     * @return EventListener
     */
    public function getEventListener() : EventListener
    {
        return $this->event;
    }

    /**
     * Fire Registered events or set into container object.
     *
     * @param $container ContainerAwareInterface
     */
    public function handle(ContainerAwareInterface $container)
    {
        $this->event->boot($this->listen);
        $this->event->fire('event.api.run');
    }
}
