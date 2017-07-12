<?php

/**
 * This file is part of Packy.
 *
 * (c) Peter Nijssen
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Menu\Voter;

use Knp\Menu\ItemInterface;
use Knp\Menu\Matcher\Voter\VoterInterface;
use Symfony\Component\HttpFoundation\RequestStack;

class RouteVoter implements VoterInterface
{
    /**
     * @var RequestStack
     */
    private $requestStack;

    /**
     * Constructor.
     *
     * @param RequestStack $requestStack
     */
    public function __construct(RequestStack $requestStack)
    {
        $this->requestStack = $requestStack;
    }

    /**
     * match item to route.
     *
     * @param ItemInterface $item
     *
     * @return null|bool true if the item is current, null if not
     */
    public function matchItem(ItemInterface $item)
    {
        if (null === $this->requestStack->getCurrentRequest()) {
            return null;
        }

        $route = $this->requestStack->getCurrentRequest()->attributes->get('_route');
        if (null === $route) {
            return null;
        }

        $routes = (array) $item->getExtra('routes', []);

        foreach ($routes as $itemRoute) {
            if (isset($itemRoute['route'])) {
                if (is_string($itemRoute['route'])) {
                    $itemRoute = [
                        'route' => $itemRoute['route'],
                        'pattern' => '/' . $itemRoute['route'] . '/',
                    ];

                    if ($this->isMatchingRoute($itemRoute)) {
                        return true;
                    }
                }
            }
        }

        return null;
    }

    /**
     * Check if we can match a route.
     *
     * @param array $itemRoute An array with the route and the route pattern
     *
     * @return bool true if a match was found, false if not
     */
    private function isMatchingRoute(array $itemRoute)
    {
        $route = $this->requestStack->getCurrentRequest()->attributes->get('_route');
        $route = $this->getBaseRoute($route);

        if (!empty($itemRoute['route'])) {
            if ($this->getBaseRoute($itemRoute['route']) === $route) {
                return true;
            }
        }

        return false;
    }

    /**
     * Get the base of the route.
     *
     * @param $route
     *
     * @return string
     */
    private function getBaseRoute($route)
    {
        $chunks = explode('_', $route);

        return implode('_', array_slice($chunks, 0, 2));
    }
}
