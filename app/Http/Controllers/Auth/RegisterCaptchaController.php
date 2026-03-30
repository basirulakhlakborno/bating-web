<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RegisterCaptchaController extends Controller
{
    /**
     * Serve a fresh captcha (PNG if GD is available, otherwise SVG) and store a hash in the session.
     */
    public function image(Request $request): Response
    {
        $code = $this->makeCode();

        $request->session()->put('register_captcha_hash', hash('sha256', strtolower($code)));

        if (function_exists('imagecreatetruecolor') && function_exists('imagepng')) {
            return $this->pngResponse($code);
        }

        return $this->svgResponse($code);
    }

    protected function makeCode(): string
    {
        $len = 5;
        $chars = 'ABCDEFGHJKLMNPQRSTUVWXYZ23456789';
        $code = '';
        for ($i = 0; $i < $len; $i++) {
            $code .= $chars[random_int(0, strlen($chars) - 1)];
        }

        return $code;
    }

    protected function pngResponse(string $code): Response
    {
        $w = 148;
        $h = 48;
        $im = imagecreatetruecolor($w, $h);
        $bg = imagecolorallocate($im, 248, 248, 248);
        $line = imagecolorallocate($im, 200, 210, 220);
        imagefilledrectangle($im, 0, 0, $w, $h, $bg);

        for ($n = 0; $n < 6; $n++) {
            imageline(
                $im,
                random_int(0, $w),
                random_int(0, $h),
                random_int(0, $w),
                random_int(0, $h),
                $line
            );
        }

        $x = 18;
        foreach (str_split($code) as $ch) {
            $color = imagecolorallocate($im, random_int(20, 80), random_int(20, 80), random_int(20, 90));
            imagestring($im, 5, $x, random_int(10, 16), $ch, $color);
            $x += 22;
        }

        ob_start();
        imagepng($im);
        imagedestroy($im);
        $png = ob_get_clean();

        return response($png, 200, $this->noCacheHeaders('image/png'));
    }

    /**
     * Fallback when ext-gd is not enabled (e.g. default XAMPP): still a server-side image, no external API.
     */
    protected function svgResponse(string $code): Response
    {
        $lines = '';
        for ($n = 0; $n < 6; $n++) {
            $lines .= sprintf(
                '<line x1="%d" y1="%d" x2="%d" y2="%d" stroke="rgb(190,200,210)" stroke-width="1" stroke-opacity="0.85"/>',
                random_int(0, 148),
                random_int(0, 48),
                random_int(0, 148),
                random_int(0, 48),
            );
        }

        $letters = '';
        $x = 20;
        foreach (str_split($code) as $ch) {
            $safe = htmlspecialchars($ch, ENT_XML1 | ENT_COMPAT, 'UTF-8');
            $letters .= sprintf(
                '<text x="%d" y="%d" transform="rotate(%d %d %d)" font-family="Consolas,Monaco,monospace" font-size="19" font-weight="700" fill="rgb(%d,%d,%d)">%s</text>',
                $x,
                30 + random_int(-2, 4),
                random_int(-14, 14),
                $x,
                24,
                random_int(18, 68),
                random_int(18, 68),
                random_int(28, 78),
                $safe
            );
            $x += 22;
        }

        $svg = '<?xml version="1.0" encoding="UTF-8"?>'
            .'<svg xmlns="http://www.w3.org/2000/svg" width="148" height="48" viewBox="0 0 148 48">'
            .'<rect width="100%" height="100%" fill="#f8f8f8"/>'
            .$lines
            .$letters
            .'</svg>';

        return response($svg, 200, $this->noCacheHeaders('image/svg+xml; charset=utf-8'));
    }

    /**
     * @return array<string, string>
     */
    protected function noCacheHeaders(string $contentType): array
    {
        return [
            'Content-Type' => $contentType,
            'Cache-Control' => 'no-store, no-cache, must-revalidate, max-age=0',
            'Pragma' => 'no-cache',
        ];
    }
}
