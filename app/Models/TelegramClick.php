<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;

class TelegramClick extends Model
{
    public const SOURCE_BUTTON = 'button';
    public const SOURCE_QR = 'qr';

    public const UPDATED_AT = null;

    protected $guarded = [];

    protected $casts = [
        'clicked_date' => 'date',
    ];

    public static function timezone(): string
    {
        return config('services.telegram.report_timezone', 'Asia/Tashkent');
    }

    /**
     * Hisobot vaqt mintaqasidagi joriy vaqt.
     */
    public static function now(): Carbon
    {
        return now(static::timezone());
    }

    /**
     * Berilgan sanalar oralig'idagi bosishlarni kunlar bo'yicha qaytaradi.
     * Natija: ['Y-m-d' => (object) [total, button, qr, unique]]
     */
    public static function dailyStats(string $from, string $to): Collection
    {
        return static::query()
            ->selectRaw('clicked_date as day')
            ->selectRaw('COUNT(*) as total')
            ->selectRaw("SUM(CASE WHEN source = 'button' THEN 1 ELSE 0 END) as button")
            ->selectRaw("SUM(CASE WHEN source = 'qr' THEN 1 ELSE 0 END) as qr")
            ->selectRaw('COUNT(DISTINCT ip_hash) as visitors')
            ->whereBetween('clicked_date', [$from, $to])
            ->groupBy('clicked_date')
            ->toBase()
            ->get()
            ->keyBy(fn ($row) => Carbon::parse($row->day)->format('Y-m-d'));
    }

    /**
     * Berilgan yil oylari bo'yicha bosishlar.
     * Natija: ['Y-m' => (object) [total, button, qr, unique]]
     */
    public static function monthlyStats(int $year): Collection
    {
        return static::query()
            ->selectRaw('clicked_month as month')
            ->selectRaw('COUNT(*) as total')
            ->selectRaw("SUM(CASE WHEN source = 'button' THEN 1 ELSE 0 END) as button")
            ->selectRaw("SUM(CASE WHEN source = 'qr' THEN 1 ELSE 0 END) as qr")
            ->selectRaw('COUNT(DISTINCT ip_hash) as visitors')
            ->where('clicked_month', 'like', $year . '-%')
            ->groupBy('clicked_month')
            ->toBase()
            ->get()
            ->keyBy('month');
    }
}
