<?php

namespace App\Traits;

trait OAuthProviders
{

    /**
     * Get OAuth login providers
     *
     * @param integer $columns
     *
     * @return array
     */
    private function oauthProviders($columns = 1)
    {
        $providers = [];
        $i = -1;
        foreach (config('services') as $key => $provider) {
            if (isset($provider['client_id'])
                && isset($provider['client_secret'])
                && isset($provider['redirect'])
            ) {
                $provider['key'] = $key;
                if ($columns > 1) {
                    if (!isset($providers[$i]) || count($providers[$i]) === $columns) {
                        $i++;
                        $providers[$i] = [];
                    }
                    $providers[$i][] = $provider;
                } else {
                    $providers[] = $provider;
                }
            }
        }
        return $providers;
    }
}
