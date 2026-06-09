<?php

namespace App\Console\Commands;

use App\Services\PanelService;
use Illuminate\Console\Command;

class XuiPing extends Command
{
    protected $signature = 'xui:ping';

    protected $description = 'Check connectivity to the configured 3X-UI panel and list its inbounds';

    public function handle(PanelService $panel): int
    {
        if (! $panel->enabled()) {
            $this->warn('3X-UI is disabled or misconfigured.');
            $this->line('Set XUI_ENABLED=true and fill XUI_BASE_URL, XUI_API_TOKEN, XUI_INBOUND_ID in .env.');

            return self::FAILURE;
        }

        $this->info('Pinging '.config('services.xui.base_url').' …');

        try {
            $inbounds = $panel->inbounds();
        } catch (\Throwable $e) {
            $this->error($e->getMessage());

            return self::FAILURE;
        }

        $this->info('Connected. Inbounds: '.count($inbounds));

        $rows = array_map(fn ($i) => [
            $i['id'] ?? '?',
            $i['remark'] ?? '',
            $i['protocol'] ?? '',
            $i['port'] ?? '',
            ($i['enable'] ?? false) ? 'yes' : 'no',
        ], $inbounds);

        $this->table(['ID', 'Remark', 'Protocol', 'Port', 'Enabled'], $rows);
        $this->line('Configured inbound for new clients: '.config('services.xui.inbound_id'));

        return self::SUCCESS;
    }
}
