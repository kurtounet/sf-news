<?php

namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class SpamCheckerApi
{
    public function __construct(
        private HttpClientInterface $spamChecker
    ) {
    }

    public function isSpam(string $email): bool
    {
        $response = $this->spamChecker->request('POST', '/api/check', [
            'json' => ['email' => $email]
        ]);

        $resContent = $response->toArray();

        return $resContent['result'] === 'spam';
    }
}
