<?PHP

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Contracts\HttpClient\HttpClientInterface;


class CallSpamCheckerService
{

    public function __construct(
        private HttpClientInterface $httpClient
    ) {
    }
    public function check
    (
        string $email
    ): bool {
        $url = "https://127.0.0.1:8000/check/" . $email;

        $reponse = $this->httpClient->request('GET', $url)->getContent();
        $reponse = json_decode($reponse, true)['result'];
        if (!$reponse = "ok") {
            return true;
        }
        return $reponse;
    }
}