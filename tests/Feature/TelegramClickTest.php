<?php

namespace Tests\Feature;

use App\Filament\Pages\TelegramStatistics;
use App\Filament\Widgets\StatsOverview;
use App\Filament\Widgets\TelegramClicksChart;
use App\Filament\Widgets\TelegramStatsOverview;
use App\Models\TelegramClick;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class TelegramClickTest extends TestCase
{
    use RefreshDatabase;

    private const BROWSER_UA = 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0 Safari/537.36';

    public function test_promo_modal_is_rendered_with_qr_and_join_button(): void
    {
        $this->get('/uz')
            ->assertOk()
            ->assertSee('tg-promo-title', false)
            ->assertSee('/uz/telegram?src=button', false)
            ->assertSee('aria-label="QR code"', false)
            ->assertSee(__('telegram.join', [], 'uz'));
    }

    public function test_button_click_is_recorded_and_redirects_to_channel(): void
    {
        $this->withHeader('User-Agent', self::BROWSER_UA)
            ->get('/uz/telegram?src=button')
            ->assertRedirect(config('services.telegram.channel_url'));

        $click = TelegramClick::sole();
        $this->assertSame('button', $click->source);
        $this->assertSame('uz', $click->locale);
        $this->assertSame(TelegramClick::now()->toDateString(), $click->clicked_date->toDateString());
        $this->assertSame(TelegramClick::now()->format('Y-m'), $click->clicked_month);
    }

    public function test_qr_scan_is_recorded_separately(): void
    {
        $this->withHeader('User-Agent', self::BROWSER_UA)->get('/ru/telegram?src=qr')->assertRedirect();

        $this->assertSame('qr', TelegramClick::sole()->source);
    }

    public function test_bots_are_not_counted_but_still_redirected(): void
    {
        $this->withHeader('User-Agent', 'TelegramBot (like TwitterBot)')
            ->get('/uz/telegram?src=button')
            ->assertRedirect(config('services.telegram.channel_url'));

        $this->assertSame(0, TelegramClick::count());
    }

    public function test_accidental_double_click_is_counted_once(): void
    {
        $this->withHeader('User-Agent', self::BROWSER_UA)->get('/uz/telegram?src=button');
        $this->withHeader('User-Agent', self::BROWSER_UA)->get('/uz/telegram?src=button');

        $this->assertSame(1, TelegramClick::count());
    }

    public function test_admin_report_page_shows_daily_and_monthly_counts(): void
    {
        $this->app['env'] = 'local';
        config(['app.env' => 'local']);

        $now = TelegramClick::now();
        foreach (range(1, 3) as $i) {
            TelegramClick::create([
                'source' => $i === 3 ? 'qr' : 'button',
                'ip_hash' => 'visitor-' . $i,
                'clicked_date' => $now->toDateString(),
                'clicked_month' => $now->format('Y-m'),
                'created_at' => now(),
            ]);
        }

        $this->actingAs(User::factory()->create())
            ->get('/admin/telegram-statistics')
            ->assertOk()
            ->assertSee('Ежедневный отчёт')
            ->assertSee('Ежемесячный отчёт')
            ->assertSee($now->format('d.m.Y'));

        Livewire::test(StatsOverview::class)->assertSee('Telegram сегодня');
        Livewire::test(TelegramStatsOverview::class)->assertSee('Сегодня')->assertSee('Кнопка: 2 · QR: 1');
        Livewire::test(TelegramClicksChart::class)->assertOk();

        Livewire::test(TelegramStatistics::class)
            ->set('month', $now->copy()->subMonthNoOverflow()->format('Y-m'))
            ->assertOk()
            ->call('showMonth', $now->format('Y-m'))
            ->assertSet('month', $now->format('Y-m'))
            ->callAction('exportDaily')
            ->assertFileDownloaded('telegram-report-' . $now->format('Y-m') . '.csv');
    }
}
