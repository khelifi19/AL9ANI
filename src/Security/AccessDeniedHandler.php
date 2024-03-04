<?php

namespace App\Security;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Http\Authorization\AccessDeniedHandlerInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Http\Util\TargetPathTrait;

class AccessDeniedHandler implements AccessDeniedHandlerInterface
{
    use TargetPathTrait;

    public function __construct(private UrlGeneratorInterface $urlGenerator)
    {
    }

    public function handle(Request $request, AccessDeniedException $accessDeniedException): ?Response
    {
        if (str_starts_with($request->getPathInfo(), '/premium')) {
            // Redirect to the premium user dashboard or any other page
            $url = $this->urlGenerator->generate('app_user_premium');
            return new RedirectResponse($url);
        }

        // Generate the URL using the UrlGeneratorInterface
        $url = $this->urlGenerator->generate('app_404');

        // Redirect to the generated URL
        return new RedirectResponse($url);
    }
}
