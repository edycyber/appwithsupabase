<?php
class Login {
    private $supabaseUrl = 'https://mepgnqdwrlbqfowwuvol.supabase.co';
    private $supabaseKey = 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6Im1lcGducWR3cmxicWZvd3d1dm9sIiwicm9sZSI6ImFub24iLCJpYXQiOjE3MjUxMjA2MDMsImV4cCI6MjA0MDY5NjYwM30.vefLAf2tXKLHFndIK4g8bZvuvkrinAFwpK1INGxacx8';

    public function loginUser($email, $password) {
        $data = [
            'email' => $email,
            'password' => $password,
        ];

        $response = $this->makeRequest('/auth/v1/token?grant_type=password', $data);

        if (isset($response['error'])) {
            return $response['error']['message'];
        } else {
            $_SESSION['user'] = $response;
            return "Login successful!";
        }
    }

    private function makeRequest($endpoint, $data) {
        $url = $this->supbaseUrl . $endpoint;
        $options = [
            'http' => [
                'header'  => "Content-type: application/json\r\nAuthorization: Bearer " . $this->supabaseKey,
                'method'  => 'POST',
                'content' => json_encode($data),
            ],
        ];
        $context  = stream_context_create($options);
        $result = file_get_contents($url, false, $context);

        return json_decode($result, true);
    }
}
?>
