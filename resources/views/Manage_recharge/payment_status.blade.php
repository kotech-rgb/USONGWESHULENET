@extends('layouts.app')

@php
    $title = 'Payment Status';
    $subtitle = 'Tracking your transaction in real-time';
@endphp

@section('content')
<div class="card shadow-sm border-0 animate__animated animate__fadeIn">
    <div class="card-body py-5" id="payment-status-container"
         style="min-height: 400px; display:flex; align-items:center; justify-content:center;">

        <div class="text-center status-transition show">
            <div class="spinner-border text-primary mb-3" style="width:3rem;height:3rem;"></div>
            <h4 class="text-muted fw-light">Connecting to Gateway...</h4>
        </div>

    </div>
</div>

<style>
.status-transition {
    transition: all 0.5s cubic-bezier(0.4,0,0.2,1);
    opacity: 0;
    transform: translateY(20px);
    text-align: center;
}
.status-transition.show {
    opacity: 1;
    transform: translateY(0);
}
.status-transition.hide {
    opacity: 0;
    transform: translateY(-20px);
    position: absolute;
}

.status-icon {
    font-size: 5rem;
    margin-bottom: 1.5rem;
}

.pulse-icon { animation: pulseAnim 2s infinite; }
@keyframes pulseAnim {
    0% { transform: scale(1); }
    50% { transform: scale(1.08); }
    100% { transform: scale(1); }
}

.pop-icon {
    animation: popIn .5s cubic-bezier(.26,.53,.74,1.48);
}
@keyframes popIn {
    0% { transform: scale(.5); opacity: 0; }
    100% { transform: scale(1); opacity: 1; }
}

.rotate-icon { animation: rotate 2s linear infinite; }
@keyframes rotate {
    to { transform: rotate(360deg); }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', () => {

    const container = document.getElementById('payment-status-container');
    let currentStatus = null;

    const STATUS_MAP = {
        PENDING: {
            icon: 'bi-phone-vibrate',
            color: '#f59e0b',
            animate: 'pulse-icon',
            title: 'Action Required',
            message: phone =>
                `Please check phone <strong>${phone}</strong> and enter your PIN to authorize the payment.`
        },
        PROCESSING: {
            icon: 'bi-arrow-repeat',
            color: '#3b82f6',
            animate: 'rotate-icon',
            title: 'Processing...',
            message: () =>
                'Verifying your transaction. Please do not close this window.'
        },
        PAID: {
            icon: 'bi-check-circle-fill',
            color: '#10b981',
            animate: 'pop-icon',
            title: 'Payment Successfully',
            message: () =>
                'Your units have been credited. Thank you for your business!'
        },
        FAILED: {
            icon: 'bi-x-circle-fill',
            color: '#ef4444',
            animate: 'pop-icon',
            title: 'Payment Failed',
            message: () =>
                'The transaction was declined or timed out. Please try again.'
        }
    };

    function renderStatus(recharge) {
        const status = recharge.status?.toUpperCase() || 'FAILED';
        if (status === currentStatus) return;
        currentStatus = status;

        const cfg = STATUS_MAP[status] || STATUS_MAP.FAILED;
        const finished = ['PAID','FAILED'].includes(status);

        container.innerHTML = `
            <div class="status-transition show text-center">
                <i class="bi ${cfg.icon} status-icon ${cfg.animate}" style="color:${cfg.color}"></i>
                <h2 style="color:${cfg.color};font-weight:800">${cfg.title}</h2>
                <p class="text-muted mt-3 mb-4" style="max-width:450px;margin:auto">
                    ${cfg.message(recharge.phone_number || '')}
                </p>

                ${
                    finished
                    ? `<a href="{{ route('recharge.history') }}"
                          class="btn btn-outline-secondary rounded-pill px-4 shadow-sm">
                          Go back
                       </a>`
                    : `<div class="spinner-grow spinner-grow-sm text-primary"></div>`
                }
            </div>
        `;

        if (finished) {
            clearInterval(uiPolling);
            clearInterval(webhookPolling);
        }
    }

    async function fetchPaymentStatus() {
        try {
            const res = await fetch(
                "{{ route('recharge.status.json', $recharge->reference) }}",
                { headers: { 'X-Requested-With': 'XMLHttpRequest' } }
            );
            const data = await res.json();
            if (data?.recharge) renderStatus(data.recharge);
        } catch (_) {}
    }

    // Silent webhook trigger
    function pingWebhook() {
        fetch("{{ route('check.payment.status') }}", {
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        }).catch(() => {});
    }

    // Start polling
    fetchPaymentStatus();
    const uiPolling = setInterval(fetchPaymentStatus, 2000); // UI refresh
    const webhookPolling = setInterval(pingWebhook, 5000);   // backend check

});
</script>
@endsection
