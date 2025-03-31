<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// use LaravelLang\Lang\Plugins\Spark\Stripe;
use Srmklive\PayPal\Services\PayPal as PayPalClient;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Log;
use Stripe\Stripe;
use Stripe\Checkout\Session;
use Stripe\PaymentIntent;


class PurchaseController extends Controller
{

    private $provider;

    // function __construct()
    // {
    //     $provider = new PayPalClient;
    //     $this->provider->setApiCredentails(config('paypal'));
    //     $token = $this->provider->getAccessToken();
    //     $this->provider->setAccessToken($token);
    // }
    // public function createPayment(Request $request)
    // {

    //     $data = json_decode($request->getContent(), true);

    //     $books = User::find($data['userId'])->booksInCart;
    //     $total = 0;

    //     foreach ($books as $book) {
    //         $total += $book->price * $book->pivot->number_of_copies;
    //     }

    //     $order = $this->provider->createOrder([
    //         'intent' => 'CAPTURE',
    //         'purchase_units' => [
    //             [
    //                 'amount' => [
    //                     'currency_code' => "USD",
    //                     'value' => $total
    //                 ],
    //                 'description' => 'Order Description'
    //             ]
    //         ],
    //     ]);

    //     return response()->json($order);
    // }

    // public function executePayment(Request $request)
    // {

    //     $data = json_decode($request->getContent(), true);

    //     $result = $this->provider->capturePaymentOrder($data['orderId']);

    //     if ($result['status'] === 'COMPLETED') {
    //         $user = User::find($data['userId']);
    //         $books = $user->booksInCart;
    //         $this->sendOrderConfirmationMail($books, auth()->user());

    //         foreach ($books as $book) {
    //             $bookPrice = $book->price;
    //             $purchaseTime = Carbon::now();
    //             $user->booksInCart()->updateExistingPivot($book->id, ['bought' => TRUE, 'price' => $bookPrice, 'created_at' => $purchaseTime]);
    //             $book->save();
    //         }
    //     }
    //     return response()->json($result);
    // }

    public function creditCheckout(Request $request)
    {
        $intent = User::find(auth()->id())->createSetupIntent();
        $userId = auth()->id();

        $books = User::find($userId)->booksInCart;
        $total = 0;

        foreach ($books as $book) {
            $total += $book->price * $book->pivot->number_of_copies;
        }

        return view('credit.checkout', compact(['total', 'intent']));
    }

    public function purchase(Request $request)
    {
        $request->validate([
            'payment_method' => 'required|string'
        ]);

        $user = $request->user();
        $paymentMethod = $request->input('payment_method');

        // تحميل الكتب مع pivot data مرة واحدة
        $books = $user->booksInCart()->withPivot('number_of_copies')->get();

        if ($books->isEmpty()) {
            return redirect()->back()->with('error', 'سلة الشراء فارغة');
        }
        // حساب المبلغ الإجمالي
        $total = $books->sum(function ($book) {
            return $book->price * $book->pivot->number_of_copies;
        });

        try {
            // إنشاء عميل Stripe إذا لم يكن موجوداً
            $user->createOrGetStripeCustomer();
            $user->updateDefaultPaymentMethod($paymentMethod);

            $charge = $user->charge($total * 100, $paymentMethod, [
                'description' => 'شراء كتب من المتجر',
                'metadata' => [
                    'book_count' => $books->count(),
                    'user_id' => $user->id
                ]
            ]);



            // تحديث حالة الكتب كمشتراة
            $now = now();
            $updates = [];

            foreach ($books as $book) {
                $updates[$book->id] = [
                    'bought' => 1,
                    'price' => $book->price,
                    'created_at' => $now,
                ];
            }

            $user->booksInCart()->sync($updates);

            // إرسال إشعار بالشراء (يمكن تفعيله لاحقاً)
            // $this->sendOrderConfirmationMail($books, $user);
            return redirect('/cart')->with([
                'success' => 'تم شراء المنتج بنجاح',
                'charge_id' => $charge->id
            ]);
        } catch (Exception $exception) {
            Log::error('Purchase failed: ' . $exception->getMessage(), [
                'user_id' => $user->id,
                'total' => $total
            ]);

            return back()->with('error', 'حصل خطأ أثناء عملية الدفع: ' . $exception->getMessage());
        }
    }

    // public function purchase(Request $request)
    // {
    //     $user = $request->user();
    //     // $paymentMethod = $request->input('payment_method');

    //     $userId = auth()->user()->id;
    //     $books = User::find($userId)->booksInCart;
    //     $total = 0;
    //     foreach ($books as $book) {
    //         $total += $book->price * $book->pivot->number_of_copies;
    //     }

    //     Stripe::setApiKey(env('STRIPE_SECRET'));

    //     // try {
    //     //     $session = Session::create([
    //     //         'payment_method_types' => ['card'],
    //     //         'line_items' => [[
    //     //             'price_data' => [
    //     //                 'currency' => 'usd',

    //     //                 'unit_amount' => $total * 100, // $10.00 in cents
    //     //             ],
    //     //             // 'quantity' => 1,
    //     //         ]],
    //     //         'mode' => 'payment',
    //     //         'success_url' => route('cart.show'),
    //     //         'cancel_url' => route('gallery.index'),
    //     //     ]);

    //     //     return redirect($session->url, 303);
    //     // } catch (Exception $e) {
    //     //     return back()->withErrors(['error' => 'Unable to create payment session: ' . $e->getMessage()]);
    //     // }

    //     try {
    //         $user->createOrGetStripeCustomer();
    //         $user->updateDefaultPaymentMethod($paymentMethod);
    //         $user->charge($total * 100, $paymentMethod);
    //     } catch (\Exception $exception) {
    //         return back()->with('حصل خطأ أثناء شراء المنتج، الرجاء التأكد منمعلومات البطاقة', $exception->getMessage());
    //     }
    //     // $this->sendOrderConfirmationMail($books, auth()->user());

    //     foreach ($books as $book) {
    //         $bookPrice = $book->price;
    //         $purchaseTime = Carbon::now();
    //         $user->booksInCart()->updateExistingPivot($book->id, ['bought' => TRUE, 'price' => $bookPrice, 'created_at' => $purchaseTime]);
    //         $book->save();
    //     }
    //     return redirect('/cart')->with('message', 'تم شراء المنتج بنجاح');
    // }
}
