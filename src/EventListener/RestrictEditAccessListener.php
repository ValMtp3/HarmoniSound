<?php
namespace App\EventListener;

use Symfony\Component\HttpKernel\Event\ControllerEvent;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Core\Security;

class RestrictEditAccessListener
{
    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    public function onKernelController(ControllerEvent $event)
    {
        $controller = $event->getController();


        if (is_array($controller)) {
            $controllerMethod = $controller[1];

            // si la méthode du contrôleur est une méthode "edit"
            if (strpos($controllerMethod, 'edit') !== false) {
                // vérifie si l'utilisateur est connecté
                if (!$this->security->getUser()) {
                    throw new AccessDeniedException('Vous devez être connecté pour modifier.');
                }
            }
        }
    }
}