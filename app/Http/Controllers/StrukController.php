<?php

namespace App\Http\Controllers;

use App\Models\Pesanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class StrukController extends Controller
{
    public function show($id)
    {
        $pesanan = Pesanan::with(['pelanggan', 'items.menu'])->findOrFail($id);
        if ($redirect = $this->receiptAccessRedirect($pesanan)) {
            return $redirect;
        }

        return view('struk', compact('pesanan'));
    }

    public function bayar(Request $request, $id)
    {
        $pesanan = Pesanan::with(['pelanggan', 'items.menu'])->findOrFail($id);
        $pelanggan = Auth::guard('pelanggan')->user();

        abort_unless($pelanggan && $pesanan->pelanggan_id === $pelanggan->id, 403);

        if ($pesanan->status_pembayaran === 'lunas') {
            return redirect()->route('struk.show', $pesanan->id)
                ->with('success', 'Pesanan ini sudah dibayar.');
        }

        if ($pesanan->status_pembayaran === 'menunggu_konfirmasi') {
            return redirect()->route('struk.show', $pesanan->id)
                ->with('success', 'Konfirmasi pembayaran kamu sedang menunggu pemeriksaan admin.');
        }

        $data = $request->validate([
            'metode_pembayaran' => ['required', 'in:tunai,qris,transfer,ewallet'],
        ]);

        $pesanan->update([
            'status_pembayaran' => 'menunggu_konfirmasi',
            'metode_pembayaran' => $data['metode_pembayaran'],
            'dibayar_pada' => null,
        ]);

        return redirect()->route('struk.show', $pesanan->id)
            ->with('success', 'Konfirmasi pembayaran dikirim. Admin akan memeriksa pesanan kamu.');
    }

    public function pdf($id)
    {
        $pesanan = Pesanan::with(['pelanggan', 'items.menu'])->findOrFail($id);
        if ($redirect = $this->receiptAccessRedirect($pesanan)) {
            return $redirect;
        }

        $pdf = $this->buildReceiptPdf($pesanan);

        return response($pdf, 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'attachment; filename="struk-pesanan-' . $pesanan->id . '.pdf"',
        ]);
    }

    private function buildReceiptPdf(Pesanan $pesanan): string
    {
        $commands = [];

        $text = function (int $x, int $y, int $size, string $value, bool $bold = false) use (&$commands): void {
            $font = $bold ? 'F2' : 'F1';
            $commands[] = 'BT /' . $font . ' ' . $size . ' Tf 1 0 0 1 ' . $x . ' ' . $y . ' Tm (' . $this->pdfText($value) . ') Tj ET';
        };

        $line = function (int $x1, int $y1, int $x2, int $y2) use (&$commands): void {
            $commands[] = $x1 . ' ' . $y1 . ' m ' . $x2 . ' ' . $y2 . ' l S';
        };

        $formatRupiah = fn ($value): string => 'Rp ' . number_format((float) $value, 0, ',', '.');

        $text(72, 790, 20, 'Cafe Jejak Rasa', true);
        $text(72, 766, 11, 'Struk Pesanan', false);
        $line(72, 752, 523, 752);

        $text(72, 725, 11, 'Nomor Pesanan', true);
        $text(210, 725, 11, '#' . $pesanan->id);
        $text(72, 705, 11, 'Tanggal', true);
        $text(210, 705, 11, $pesanan->created_at->format('d M Y H:i'));
        $text(72, 685, 11, 'Pelanggan', true);
        $text(210, 685, 11, $pesanan->pelanggan->name ?? '-');
        $text(72, 665, 11, 'Status', true);
        $text(210, 665, 11, $pesanan->status_label);
        $text(72, 645, 11, 'Pembayaran', true);
        $text(210, 645, 11, $pesanan->payment_status_label);
        $text(72, 625, 11, 'Metode', true);
        $text(210, 625, 11, $pesanan->payment_method_label);

        $line(72, 600, 523, 600);
        $text(72, 580, 11, 'Menu', true);
        $text(285, 580, 11, 'Qty', true);
        $text(340, 580, 11, 'Harga', true);
        $text(445, 580, 11, 'Subtotal', true);
        $line(72, 568, 523, 568);

        $y = 548;
        foreach ($pesanan->items as $item) {
            if ($y < 120) {
                $text(72, $y, 10, 'Item lainnya tidak ditampilkan karena halaman penuh.');
                break;
            }

            $text(72, $y, 10, Str::limit($item->menu->nama_menu ?? 'Menu terhapus', 34, '...'));
            $text(285, $y, 10, (string) $item->qty);
            $text(340, $y, 10, $formatRupiah($item->harga_satuan));
            $text(445, $y, 10, $formatRupiah($item->subtotal));
            $y -= 22;
        }

        $line(72, $y - 4, 523, $y - 4);
        $text(340, $y - 28, 12, 'Total', true);
        $text(445, $y - 28, 12, $formatRupiah($pesanan->total_harga), true);

        $text(72, 78, 10, 'Terima kasih sudah memesan di Cafe Jejak Rasa.');

        return $this->makePdf(implode("\n", $commands));
    }

    private function pdfText(string $value): string
    {
        $value = iconv('UTF-8', 'Windows-1252//TRANSLIT//IGNORE', $value) ?: $value;

        return str_replace(
            ['\\', '(', ')', "\r", "\n"],
            ['\\\\', '\(', '\)', ' ', ' '],
            $value
        );
    }

    private function makePdf(string $content): string
    {
        $objects = [
            '<< /Type /Catalog /Pages 2 0 R >>',
            '<< /Type /Pages /Kids [3 0 R] /Count 1 >>',
            '<< /Type /Page /Parent 2 0 R /MediaBox [0 0 595 842] /Resources << /Font << /F1 4 0 R /F2 5 0 R >> >> /Contents 6 0 R >>',
            '<< /Type /Font /Subtype /Type1 /BaseFont /Helvetica >>',
            '<< /Type /Font /Subtype /Type1 /BaseFont /Helvetica-Bold >>',
            '<< /Length ' . strlen($content) . " >>\nstream\n" . $content . "\nendstream",
        ];

        $pdf = "%PDF-1.4\n";
        $offsets = [0];

        foreach ($objects as $index => $object) {
            $offsets[] = strlen($pdf);
            $pdf .= ($index + 1) . " 0 obj\n" . $object . "\nendobj\n";
        }

        $xrefOffset = strlen($pdf);
        $pdf .= "xref\n0 " . (count($objects) + 1) . "\n";
        $pdf .= "0000000000 65535 f \n";

        for ($i = 1; $i <= count($objects); $i++) {
            $pdf .= sprintf("%010d 00000 n \n", $offsets[$i]);
        }

        $pdf .= "trailer\n<< /Size " . (count($objects) + 1) . " /Root 1 0 R >>\n";
        $pdf .= "startxref\n" . $xrefOffset . "\n%%EOF";

        return $pdf;
    }

    private function receiptAccessRedirect(Pesanan $pesanan)
    {
        if (Auth::guard('web')->check()) {
            return null;
        }

        $pelanggan = Auth::guard('pelanggan')->user();

        if (! $pelanggan) {
            return redirect()->route('pelanggan.login')
                ->withErrors(['Silakan login untuk melihat struk pesanan.']);
        }

        abort_unless((int) $pesanan->pelanggan_id === (int) $pelanggan->id, 403);

        return null;
    }
}
