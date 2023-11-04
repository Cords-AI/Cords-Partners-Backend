<?php

namespace App\Security;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Http\Authenticator\AbstractAuthenticator;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Passport;
use Symfony\Component\Security\Http\Authenticator\Passport\SelfValidatingPassport;

class Authenticator extends AbstractAuthenticator
{
    public function supports(Request $request): ?bool
    {
        $auth = $request->headers->get('Authorization');
        return !empty($auth);
    }

    public function authenticate(Request $request): Passport
    {
        $auth = $request->headers->get('Authorization');

        $token = str_replace("Bearer ", "", $auth);

        $user = User::create($token);

        $passport = new SelfValidatingPassport(new UserBadge("", function () use ($user) {
            return $user;
        }));

        return $passport;
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $firewallName): ?Response
    {
        return null;
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception): ?Response
    {
        return new JsonResponse([], Response::HTTP_UNAUTHORIZED);
    }
}