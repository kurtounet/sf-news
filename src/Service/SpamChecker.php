<?PHP

class SpamChecker
{
    public function check
    (
        string $email
    ): bool {
        $url = "https://127.0.0.1:8000/check/" . $email;
        $reponse = file_get_contents($url);
        $reponse = json_decode($reponse, true)['result'];
        if (!$reponse = "ok") {
            return true;
        }
        return $reponse;
    }
}