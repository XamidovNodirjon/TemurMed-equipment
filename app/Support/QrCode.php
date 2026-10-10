<?php

namespace App\Support;

use BaconQrCode\Common\ErrorCorrectionLevel;
use BaconQrCode\Renderer\Color\Rgb;
use BaconQrCode\Renderer\Image\SvgImageBackEnd;
use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\Module\SquareModule;
use BaconQrCode\Renderer\RendererStyle\Fill;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;
use BaconQrCode\Writer;
use Illuminate\Support\Facades\Cache;

class QrCode
{
    /**
     * Berilgan matn uchun inline SVG QR kod qaytaradi (keshlanadi).
     * Xatoni tuzatish darajasi "H" — markazga logotip qo'yilsa ham skaner qilinadi.
     */
    public static function svg(string $data, int $size = 240): string
    {
        $key = 'qr-svg:' . md5($data . '|' . $size);

        return Cache::rememberForever($key, function () use ($data, $size) {
            $style = new RendererStyle(
                $size,
                1,
                SquareModule::instance(),
                null,
                Fill::uniformColor(new Rgb(255, 255, 255), new Rgb(15, 23, 42))
            );

            $svg = (new Writer(new ImageRenderer($style, new SvgImageBackEnd())))
                ->writeString($data, 'UTF-8', ErrorCorrectionLevel::H());

            // XML sarlavhasini olib tashlab, inline foydalanishga moslaymiz
            $svg = preg_replace('/^<\?xml[^>]*>\s*/', '', $svg);

            return preg_replace('/<svg /', '<svg class="w-full h-full" role="img" aria-label="QR code" ', $svg, 1);
        });
    }
}
