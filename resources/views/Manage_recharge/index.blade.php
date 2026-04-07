@extends('layouts.app')

@php
    $title = "Recharge";
    $subtitle = "Top up your balance";
@endphp

@section('content')
<div class="container py-4">
    <div class="card shadow-sm rounded-4 animate__animated animate__fadeInUp border-0">
        <div class="card-body p-lg-5">
            <div class="row g-4">

                <div class="col-lg-5 border-end pe-lg-4">
                    <div class="table-responsive shadow-sm rounded-3 border">
                        <table class="table table-hover mb-0">
                            <thead class="table-light small text-uppercase">
                                <tr>
                                    <th class="ps-3">Package (SMS)</th>
                                    <th class="text-end pe-3">Price / SMS</th>
                                </tr>
                            </thead>
                            <tbody class="small">
                                @forelse($packages as $pkg)
                                    <tr>
                                        <td class="ps-3">{{ number_format($pkg->min_limit) }} - {{ number_format($pkg->max_limit) }}</td>
                                        <td class="text-end pe-3 fw-bold text-dark bg-light">{{ $pkg->price_per_unit }} TZS</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="2" class="text-center py-3 text-muted">No pricing configured.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="alert alert-info border-0 mt-3 small rounded-3">
                        <i class="bi bi-info-circle-fill me-2"></i>
                        The total price is calculated automatically based on the SMS amount you enter in the form.
                    </div>

                    <div class="alert alert-secondary border-0 mt-3 small rounded-3">
                        <h6 class="fw-bold small"><i class="bi bi-credit-card-2-front-fill me-1"></i>How to Pay</h6>
                        <ol class="mb-0 ps-3">
                            <li>Enter the SMS amount you wish to recharge.</li>
                            <li>Enter your mobile money number (HaloPesa, TigoPesa, AirtelMoney).</li>
                            <li>Click <strong>"Click to Pay"</strong> to receive the USSD prompt.</li>
                            <li>Confirm with your PIN on your phone.</li>
                        </ol>
                    </div>
                </div>

                <div class="col-lg-7 ps-lg-4">
                    <h6 class="fw-bold mb-4 text-dark">Enter Recharge Details</h6>
                    <form id="submittingForm" action="{{ route('recharge.store') }}" method="POST">
                        @csrf

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label fw-bold small">SMS Amount <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-white border-end-0"><i class="bi bi-chat-dots text-muted"></i></span>
                                    <input type="number" class="form-control rounded-3 border-start-0 ps-0" name="SMS_amount" id="sms_amount" placeholder="0" required>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-bold small text-muted">Payable Amount (TZS)</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light text-success fw-bold border-end-0">TZS</span>
                                    <input type="text" class="form-control bg-light fw-bold text-dark rounded-3 border-start-0 ps-0" id="total_price" readonly value="0">
                                </div>
                            </div>
                        </div>

                        <div class="mb-4 mt-4">
                            <label class="form-label fw-bold small">Mobile Money Number <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text bg-white border-end-0"><i class="bi bi-phone text-muted"></i></span>
                                <input type="number" class="form-control rounded-3 border-start-0 ps-0" name="phone_number" required>
                            </div>
                            <small class="form-text text-muted">The number that will receive the payment prompt.</small>
                        </div>

                        <hr class="my-4 opacity-50">

                        <div class="d-grid">
                            <button type="submit" class="btn btn-dark py-3 rounded-3 shadow-sm fw-bold">Click to Pay</button>
                        </div>

                    </form>
                </div>

            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const smsInput = document.getElementById('sms_amount');
    const totalPrice = document.getElementById('total_price');
    const form = document.getElementById('submittingForm');

    // Fetch packages from PHP to JS
    const pricingTiers = @json($packages);

    function calculatePrice(count) {
        if (count <= 0 || pricingTiers.length === 0) return 0;
        
        // Find the matching tier from the database
        const tier = pricingTiers.find(t => count >= t.min_limit && count <= t.max_limit);
        
        if (tier) {
            return count * tier.price_per_unit;
        } else {
            // Fallback to the highest tier if count exceeds all max_limits
            const maxTier = pricingTiers[pricingTiers.length - 1];
            return count * maxTier.price_per_unit;
        }
    }

    smsInput.addEventListener('input', function () {
        let smsCount = parseInt(this.value) || 0;
        let amount = calculatePrice(smsCount);
        totalPrice.value = amount.toLocaleString();
    });

    form.addEventListener('submit', function() {
        document.getElementById('btnText').classList.add('d-none');
        document.getElementById('btnSpinner').classList.remove('d-none');
        document.getElementById('submitBtn').disabled = true;
    });
});
</script>
@endsection