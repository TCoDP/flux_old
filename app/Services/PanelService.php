<?php

namespace App\Services;

use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Http;
use RuntimeException;

/**
 * Thin client for a 3X-UI panel (Xray / VLESS-Reality).
 * Authenticates with a Bearer API token (Settings → Security → API Token).
 * All panel responses share the { success, msg, obj } envelope.
 */
class PanelService
{
    public function enabled(): bool
    {
        return (bool) config('services.xui.enabled')
            && filled(config('services.xui.base_url'))
            && filled(config('services.xui.token'))
            && filled(config('services.xui.inbound_id'));
    }

    private function client(): PendingRequest
    {
        return Http::baseUrl(rtrim((string) config('services.xui.base_url'), '/'))
            ->withToken((string) config('services.xui.token'))
            ->withOptions(['verify' => (bool) config('services.xui.verify_tls')])
            ->acceptJson()
            ->timeout(15);
    }

    /** Unwrap the panel envelope or throw with a useful message. */
    private function unwrap(\Illuminate\Http\Client\Response $response, string $context): mixed
    {
        $json = $response->json();

        if (! $response->successful() || ! ($json['success'] ?? false)) {
            throw new RuntimeException(sprintf(
                '3X-UI %s failed (%d): %s',
                $context,
                $response->status(),
                $json['msg'] ?? 'unknown error',
            ));
        }

        return $json['obj'] ?? null;
    }

    /** @return array<int, mixed> */
    public function inbounds(): array
    {
        return (array) $this->unwrap($this->client()->get('/panel/api/inbounds/list'), 'inbounds.list');
    }

    /**
     * Create a client and attach it to the configured inbound.
     * $expiryMs — epoch milliseconds (0 = never). $bytes — quota in bytes (0 = unlimited).
     */
    public function addClient(string $email, int $expiryMs = 0, int $bytes = 0): void
    {
        $payload = [
            'client' => [
                'email' => $email,
                'enable' => true,
                'totalGB' => $bytes,        // bytes despite the name
                'expiryTime' => $expiryMs,
                'limitIp' => 0,
                'tgId' => 0,
            ],
            'inboundIds' => [(int) config('services.xui.inbound_id')],
        ];

        $this->unwrap($this->client()->post('/panel/api/clients/add', $payload), 'clients.add');
    }

    public function getClient(string $email): ?array
    {
        $obj = $this->unwrap($this->client()->get('/panel/api/clients/get/'.rawurlencode($email)), 'clients.get');

        return is_array($obj) ? $obj : null;
    }

    /** @return array<int, string> */
    public function getLinks(string $email): array
    {
        return array_values(array_filter(
            (array) $this->unwrap($this->client()->get('/panel/api/clients/links/'.rawurlencode($email)), 'clients.links'),
            'is_string',
        ));
    }

    public function getTraffic(string $email): ?array
    {
        $obj = $this->unwrap($this->client()->get('/panel/api/clients/traffic/'.rawurlencode($email)), 'clients.traffic');

        return is_array($obj) ? $obj : null;
    }

    /** @param array<string, mixed> $fields */
    public function updateClient(string $email, array $fields): void
    {
        $this->unwrap($this->client()->post('/panel/api/clients/update/'.rawurlencode($email), $fields), 'clients.update');
    }

    public function deleteClient(string $email): void
    {
        $this->unwrap($this->client()->post('/panel/api/clients/del/'.rawurlencode($email)), 'clients.del');
    }

    public function resetTraffic(string $email): void
    {
        $this->unwrap($this->client()->post('/panel/api/clients/resetTraffic/'.rawurlencode($email)), 'clients.resetTraffic');
    }

    /** Build the subscription URL from the configured base and a subId. */
    public function subscriptionUrl(?string $subId): ?string
    {
        $base = config('services.xui.sub_url_base');

        return ($base && $subId) ? rtrim((string) $base, '/').'/'.$subId : null;
    }
}
