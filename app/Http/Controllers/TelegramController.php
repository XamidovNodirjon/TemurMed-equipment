<?php

namespace App\Http\Controllers;

use App\Models\TelegramClick;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class TelegramController extends Controller
{
    /**
     * Bosishni hisoblab, foydalanuvchini Telegram kanalga yo'naltiradi.
     * Tugma (?src=button) va QR kod (?src=qr) shu manzilga olib keladi.
     */
    public function go(Request $request)
    {
        $channelUrl = config('services.telegram.channel_url');

        try {
            $this->record($request);
        } catch (\Throwable $e) {
            report($e);
        }

        return redirect()->away($channelUrl);
    }

    protected function record(Request $request): void
    {
        $userAgent = (string) $request->userAgent();

        // Link preview botlari va crawlerlarni hisobga olmaymiz
        if ($userAgent === '' || preg_match('/bot|crawl|spider|slurp|preview|facebookexternalhit|whatsapp|curl|wget|python|headless/i', $userAgent)) {
            return;
        }

        $source = $request->query('src') === TelegramClick::SOURCE_QR
            ? TelegramClick::SOURCE_QR
            : TelegramClick::SOURCE_BUTTON;

        $ipHash = hash('sha256', $request->ip() . '|' . config('app.key'));

        // Bir xil foydalanuvchining tasodifiy ikki marta bosishini (5 soniya ichida) bitta deb hisoblaymiz
        if (! Cache::add('tg-click:' . $source . ':' . $ipHash, true, 5)) {
            return;
        }

        $now = TelegramClick::now();

        TelegramClick::create([
            'source' => $source,
            'locale' => in_array($request->route('locale'), ['uz', 'ru', 'en']) ? $request->route('locale') : null,
            'ip_hash' => $ipHash,
            'user_agent' => Str::limit($userAgent, 500, ''),
            'clicked_date' => $now->toDateString(),
            'clicked_month' => $now->format('Y-m'),
            'created_at' => now(),
        ]);
    }
}
