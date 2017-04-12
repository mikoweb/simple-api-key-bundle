<?php

/*
 * (c) Rafał Mikołajun <rafal@mikoweb.pl>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Mikoweb\Bundle\SimpleApiKeyBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Test Controller.
 *
 * @author Rafał Mikołajun <rafal@mikoweb.pl>
 * @package mikoweb/simple-api-key-bundle
 */
class TestController extends Controller
{
    /**
     * @return JsonResponse
     */
    public function indexAction()
    {
        return new JsonResponse([true]);
    }

    /**
     * @return JsonResponse
     */
    public function somethingAction()
    {
        $this->denyAccessUnlessGranted('ROLE_DO_SOMETHING');

        return new JsonResponse([true]);
    }

    /**
     * @return JsonResponse
     */
    public function extendedAction()
    {
        $this->denyAccessUnlessGranted('ROLE_EXTENDED_ACCESS');

        return new JsonResponse([true]);
    }
}
