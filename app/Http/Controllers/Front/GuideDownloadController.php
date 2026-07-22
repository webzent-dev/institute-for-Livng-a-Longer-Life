<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Support\Str;

class GuideDownloadController extends Controller
{
    /**
     * Public, signature-protected download for a purchased guide PDF.
     *
     * The order confirmation email carries a signed link to this action instead
     * of the PDF itself (attachments bloat the message and bounce). The signature
     * proves the link was issued by us for this specific order item, so a guest —
     * who has no account to sign in to — can still download. We additionally
     * require the order to be paid before releasing the file.
     */
    public function download(int $orderItem)
    {
        $item = OrderItem::findOrFail($orderItem);
        $order = Order::findOrFail($item->order_id);

        abort_unless(
            $order->payment_status === 'completed',
            403,
            'This download becomes available once your payment is confirmed.'
        );

        $product = Product::findOrFail($item->product_id);
        $path = $product->pdfPath();

        abort_if(
            $product->product_type !== 'guide' || !$path,
            404,
            'This product does not have a downloadable file.'
        );

        return response()->download($path, Str::slug($product->name) . '.pdf', [
            'Content-Type' => 'application/pdf',
        ]);
    }
}
