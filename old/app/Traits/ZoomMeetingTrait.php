<?php 
namespace App\Traits;

use GuzzleHttp\Client;
use Log;

/**
 * trait ZoomMeetingTrait
 */
trait ZoomMeetingTrait
{
    public $client;
    public $jwt;
    public $headers;

    public function __construct()
    {
        $this->client = new Client();
        $this->jwt = $this->generateZoomToken();
        $this->headers = [
            'Authorization' => 'Bearer '.$this->jwt,
            'Content-Type'  => 'application/json',
            'Accept'        => 'application/json',
        ];
        //$this->status = config('constant');
    }
    public function generateZoomToken()
    {
        $key = env('ZOOM_API_KEY', '');
        $secret = env('ZOOM_API_SECRET', '');

        // HS256 requires a key of at least 256 bits (32 bytes).
        $requiredBytes = 32;
        $hasEnoughLength = false;

        if (\is_string($secret) && \strlen($secret) >= $requiredBytes) {
            $hasEnoughLength = true;
        } else {
            // If the secret is base64-encoded, allow that as long as the decoded
            // length meets the requirement.
            $decoded = base64_decode($secret, true);
            if ($decoded !== false && \strlen($decoded) >= $requiredBytes) {
                $hasEnoughLength = true;
            }
        }

        if (! $hasEnoughLength) {
            throw new \DomainException(
                'Zoom API secret is too short for HS256. Provide at least 32 raw bytes ' .
                '(256 bits). Example: `php -r "echo base64_encode(random_bytes(32));"` ' .
                'and set ZOOM_API_SECRET in your .env to that value.'
            );
        }

        $payload = [
            'iss' => $key,
            'exp' => strtotime('+1 minute'),
        ];

        return \Firebase\JWT\JWT::encode($payload, $secret, 'HS256');
    }

    private function retrieveZoomUrl()
    {
        return env('ZOOM_API_URL', '');
    }

    public function toZoomTimeFormat(string $dateTime)
    {
        try {
            $date = new \DateTime($dateTime);
            return $date->format('Y-m-d\TH:i:s');
        } catch (\Exception $e) {
            Log::error('ZoomJWT->toZoomTimeFormat : '.$e->getMessage());
            return '';
        }
    }

    public function createMeeting($data)
    {
        $path = 'users/me/meetings';
        $url = $this->retrieveZoomUrl();

        $body = [
            'headers' => $this->headers,
            'body'    => json_encode([
                'topic'      => $data['session_title'],
                'type'       => self::MEETING_TYPE_SCHEDULE,
                'start_time' => $this->toZoomTimeFormat($data['time']),
                'duration'   => $data['duration'],
                'timezone'     => 'Asia/Kolkata',
                'settings'   => [
                    // 'host_video'        => ($data['host_video'] == "1") ? true : false,
                    // 'participant_video' => ($data['participant_video'] == "1") ? true : false,
                    // 'waiting_room'      => true,
                    'join_before_host' => false,
                    'mute_upon_entry'  => true,
                    'waiting_room'     => true,
                ],
            ]),
        ];

        $response =  $this->client->post($url.$path, $body);
        echo '<pre>';print_r($response);exit;

        return [
            'success' => $response->getStatusCode() === 201,
            'data'    => json_decode($response->getBody(), true),
        ];
    }

    public function updateMeeting($id, $data)
    {
        $path = 'meetings/'.$id;
        $url = $this->retrieveZoomUrl();

        $body = [
            'headers' => $this->headers,
            'body'    => json_encode([
                'topic'      => $data['topic'],
                'type'       => self::MEETING_TYPE_SCHEDULE,
                'start_time' => $this->toZoomTimeFormat($data['start_time']),
                'duration'   => $data['duration'],
                'agenda'     => (! empty($data['agenda'])) ? $data['agenda'] : null,
                'timezone'     => 'Asia/Kolkata',
                'settings'   => [
                    'host_video'        => ($data['host_video'] == "1") ? true : false,
                    'participant_video' => ($data['participant_video'] == "1") ? true : false,
                    'waiting_room'      => true,
                ],
            ]),
        ];
        $response =  $this->client->patch($url.$path, $body);

        return [
            'success' => $response->getStatusCode() === 204,
            'data'    => json_decode($response->getBody(), true),
        ];
    }

    public function getMeetingDetail($id)
    {
        $path = 'meetings/'.$id;
        $url = $this->retrieveZoomUrl();
        $this->jwt = $this->generateZoomToken();
        $body = [
            'headers' => $this->headers,
            'body'    => json_encode([]),
        ];

        $response =  $this->client->get($url.$path, $body);

        return [
            'success' => $response->getStatusCode() === 204,
            'data'    => json_decode($response->getBody(), true),
        ];
    }

    /**
     * @param string $id
     *
     * @return bool[]
     */
    public function deleteMeeting($id)
    {
        $path = 'meetings/'.$id;
        $url = $this->retrieveZoomUrl();
        $body = [
            'headers' => $this->headers,
            'body'    => json_encode([]),
        ];

        $response =  $this->client->delete($url.$path, $body);

        return [
            'success' => $response->getStatusCode() === 204,
        ];
    }
}