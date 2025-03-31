@extends('layouts.main')

@section('head')
    <style>
        .stripe-element {
            box-sizing: border-box;
            height: 40px;
            padding: 10px 12px;
            border: 1px solid #ced4da;
            border-radius: 4px;
            background-color: white;
            box-shadow: 0 1px 3px 0 #e6ebf1;
            transition: box-shadow 150ms ease;
        }

        .stripe-element--focus {
            box-shadow: 0 1px 3px 0 #cfd7df;
            border-color: #80bdff;
        }

        .stripe-element--invalid {
            border-color: #fa755a;
        }

        .stripe-element--webkit-autofill {
            background-color: #fefde5 !important;
        }

        .payment-loader {
            display: inline-block;
            margin-right: 10px;
        }
    </style>
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            @if (session('success'))
                <div class="col-md-8 mb-4">
                    <div class="alert alert-success text-center">
                        <h4>{{ session('success') }}</h4>
                        @if (session('charge_id'))
                            <p class="mb-0">رقم العملية: {{ session('charge_id') }}</p>
                        @endif
                    </div>
                </div>
            @endif

            <div class="col-md-8">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <i class="fas fa-credit-card mr-2"></i>الدفع باستخدام البطاقة الائتمانية
                    </div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('products.purchase') }}" class="card-form" id="payment-form">
                            @csrf

                            <input type="hidden" name="payment_method" class="payment-method">

                            <div class="form-group">
                                <label for="card-holder-name">اسم صاحب البطاقة</label>
                                <input class="form-control" id="card-holder-name" name="card_holder_name"
                                    placeholder="اسم صاحب البطاقة كما هو مدون على البطاقة" required>
                            </div>

                            <div class="form-group">
                                <label>معلومات البطاقة</label>
                                <div id="card-element" class="stripe-element"></div>
                                <small class="form-text text-muted">لن نقوم بتخزين أي معلومات عن بطاقتك</small>
                            </div>

                            <div id="card-errors" class="text-danger" role="alert"></div>

                            <div class="form-group mt-4">
                                <button type="submit" class="btn btn-primary btn-lg btn-block pay" id="submit-button">
                                    <span class="payment-loader" style="display: none;">
                                        <i class="fas fa-sync fa-spin"></i>
                                    </span>
                                    دفع {{ number_format($total, 2) }} $
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="https://js.stripe.com/v3/"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const stripe = Stripe("{{ env('STRIPE_KEY') }}");
            const elements = stripe.elements();
            const form = document.getElementById('payment-form');
            const submitButton = document.getElementById('submit-button');
            const loader = document.querySelector('.payment-loader');

            const style = {
                base: {
                    color: '#32325d',
                    fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
                    fontSmoothing: 'antialiased',
                    fontSize: '16px',
                    '::placeholder': {
                        color: '#aab7c4'
                    }
                },
                invalid: {
                    color: '#fa755a',
                    iconColor: '#fa755a'
                }
            };

            const card = elements.create('card', {
                style: style,
                hidePostalCode: true
            });

            card.mount('#card-element');

            // Handle real-time validation errors
            card.addEventListener('change', function(event) {
                const displayError = document.getElementById('card-errors');
                if (event.error) {
                    displayError.textContent = event.error.message;
                } else {
                    displayError.textContent = '';
                }
            });

            // Handle form submission
            form.addEventListener('submit', async function(e) {
                e.preventDefault();

                const cardHolderName = document.getElementById('card-holder-name').value;
                if (!cardHolderName) {
                    alert('الرجاء إدخال اسم صاحب البطاقة');
                    return;
                }

                submitButton.disabled = true;
                loader.style.display = 'inline-block';

                try {
                    const {
                        setupIntent,
                        error
                    } = await stripe.confirmCardSetup(
                        "{{ $intent->client_secret }}", {
                            payment_method: {
                                card: card,
                                billing_details: {
                                    name: cardHolderName
                                }
                            }
                        }
                    );

                    if (error) {
                        document.getElementById('card-errors').textContent = error.message;
                        submitButton.disabled = false;
                        loader.style.display = 'none';
                    } else {
                        document.querySelector('.payment-method').value = setupIntent.payment_method;
                        form.submit();
                    }
                } catch (err) {
                    console.error('Error:', err);
                    document.getElementById('card-errors').textContent = 'حدث خطأ أثناء معالجة الدفع';
                    submitButton.disabled = false;
                    loader.style.display = 'none';
                }
            });
        });
    </script>
@endsection
