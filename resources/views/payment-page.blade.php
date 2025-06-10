<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout - B Laundry</title>
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <!-- Header -->
    <header class="checkout-header">
        <div class="container checkout-header-container">
            <a href="{{ route('home') }}" class="logo">
                <i class="fas fa-tshirt"></i>
                B Laundry
            </a>
            <div class="checkout-steps">
                <div class="step completed">
                    <div class="step-number">1</div>
                    <div class="step-text">Schedule</div>
                </div>
                <div class="step active">
                    <div class="step-number">2</div>
                    <div class="step-text">Payment</div>
                </div>
                <div class="step">
                    <div class="step-number">3</div>
                    <div class="step-text">Confirmation</div>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <div class="container">
        <div class="checkout-container">
            <!-- Main Checkout Section -->
            <main class="checkout-main">
                <!-- Order Summary -->
                <section class="order-summary">
                    <h2 class="summary-title"><i class="fas fa-clipboard-list"></i> Order Summary</h2>
                    
                    <div class="summary-section">
                        <div class="section-header">
                            <i class="fas fa-truck-pickup"></i>
                            <span>Pickup Details</span>
                        </div>
                        <div class="section-content">
                            <p><strong>Date:</strong> Tomorrow, {{ date('M d, Y', strtotime('+1 day')) }}</p>
                            <p><strong>Time:</strong> 8:00 AM - 12:00 PM</p>
                            <p><strong>Address:</strong> 123 Main St, Apt 4B, New York, NY 10001</p>
                            <p><strong>Special Instructions:</strong> Please ring doorbell twice</p>
                        </div>
                    </div>
                    
                    <div class="summary-section">
                        <div class="section-header">
                            <i class="fas fa-truck"></i>
                            <span>Delivery Details</span>
                        </div>
                        <div class="section-content">
                            <p><strong>Date:</strong> {{ date('M d, Y', strtotime('+3 days')) }}</p>
                            <p><strong>Time:</strong> 12:00 PM - 4:00 PM</p>
                            <p><strong>Address:</strong> Same as pickup address</p>
                        </div>
                    </div>
                    
                    <div class="summary-section">
                        <div class="section-header">
                            <i class="fas fa-concierge-bell"></i>
                            <span>Services</span>
                        </div>
                        <div class="section-content">
                            <p><strong>Wash & Fold:</strong> 10-15 lbs ($15.00)</p>
                            <p><strong>Dry Cleaning:</strong> 1 Suit, 2 Dresses ($12.50)</p>
                            <p><strong>Detergent:</strong> Eco-Friendly (+$3.00)</p>
                        </div>
                    </div>
                </section>

                <!-- Payment Methods -->
                <section class="payment-methods">
                    <h2 class="payment-title"><i class="fas fa-credit-card"></i> Payment Method</h2>
                    
                    <form action="{{ route('payment.process') }}" method="POST" id="checkout-form">
                        @csrf
                        <input type="hidden" name="order_total" value="32.95">
                        
                        <div class="payment-options">
                            <label class="payment-option active">
                                <input type="radio" name="payment_method" value="visa-4242" checked>
                                <div class="payment-icon visa">
                                    <i class="fab fa-cc-visa"></i>
                                </div>
                                <div class="payment-details">
                                    <h3>Visa ****4242</h3>
                                    <p>Expires 12/2025</p>
                                </div>
                            </label>

                            <label class="payment-option">
                                <input type="radio" name="payment_method" value="paypal">
                                <div class="payment-icon paypal">
                                    <i class="fab fa-cc-paypal"></i>
                                </div>
                                <div class="payment-details">
                                    <h3>PayPal</h3>
                                    <p>{{ Auth::user()->email }}</p>
                                </div>
                            </label>
                            
                            <label class="payment-option">
                                <input type="radio" name="payment_method" value="mastercard-8888">
                                <div class="payment-icon mastercard">
                                    <i class="fab fa-cc-mastercard"></i>
                                </div>
                                <div class="payment-details">
                                    <h3>Mastercard ****8888</h3>
                                    <p>Expires 08/2026</p>
                                </div>
                            </label>
                        </div>
                        
                        <div class="add-payment">
                            <a href="{{ route('payment.methods') }}">
                                <i class="fas fa-plus"></i>
                                <span>Add new payment method</span>
                            </a>
                        </div>
                    </form>
                </section>
            </main>

            <!-- Order Summary Sidebar -->
            <aside class="checkout-sidebar">
                <section class="order-total">
                    <h2 class="total-title"><i class="fas fa-receipt"></i> Order Total</h2>
                    
                    <div class="total-row">
                        <span class="total-label">Subtotal</span>
                        <span class="total-value">$27.50</span>
                    </div>
                    <div class="total-row">
                        <span class="total-label">Service Fee</span>
                        <span class="total-value">$3.00</span>
                    </div>
                    <div class="total-row">
                        <span class="total-label">Tax</span>
                        <span class="total-value">$2.45</span>
                    </div>
                    
                    <div class="total-row grand-total">
                        <span class="total-label">Total</span>
                        <span class="total-value">$32.95</span>
                    </div>
                    
                    <div class="checkout-actions">
                        <button type="submit" form="checkout-form" class="btn btn-primary" style="width: 100%;">
                            <i class="fas fa-lock"></i> Confirm & Pay $32.95
                        </button>
                    </div>
                    
                    <p style="font-size: 12px; color: #777; margin-top: 15px; text-align: center;">
                        <i class="fas fa-lock"></i> Your payment is secure and encrypted
                    </p>
                </section>
            </aside>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Payment method selection
            const paymentOptions = document.querySelectorAll('.payment-option');
            
            paymentOptions.forEach(option => {
                option.addEventListener('click', function() {
                    // Remove active class from all options
                    paymentOptions.forEach(opt => opt.classList.remove('active'));
                    
                    // Add active class to clicked option
                    this.classList.add('active');
                });
            });
        });
    </script>
</body>
</html>