<?php

namespace App\Traits;

trait ResolversTrait
{
    public function resolversFactory(string $method, array $args)
    {
        try {
            $this->authService->checkAuthentication();
            return call_user_func([$this, $method], $args);
        } catch (\Exception $e) {
            throw $this->userErrorFactory->create($e);
        }
    }
}
