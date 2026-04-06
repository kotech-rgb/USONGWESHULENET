@extends('layouts.app')

@php
    $title = 'SMS Result Portal';
    $schoolDetails = \App\Models\Configuration::first();
    $activeTerm = \DB::table('terms')->where('status', 'active')->first();
    $activeYear = \DB::table('years')->where('status', 'active')->first();

    $termName = $activeTerm ? $activeTerm->term_name : 'N/A';
    $yearName = $activeYear ? $activeYear->year_name : date('Y');
    $hasQueryParams = request()->has(['class_name']);
    $currentBalance = $schoolDetails->sms_balance ?? 0;
@endphp

@section('title', 'SMS Portal')

@section('content')

<style>
    /* Minimal custom CSS – only for sticky sidebar */
    .sticky-sidebar {
        position: sticky;
        top: 20px;
        align-self: start;
        z-index: 1020;
    }
    /* Three-dot animation */
    .dot-floating {
        display: inline-flex;
        gap: 6px;
        align-items: center;
        justify-content: center;
    }
    .dot-floating span {
        width: 8px;
        height: 8px;
        background-color: #0d6efd;
        border-radius: 50%;
        display: inline-block;
        animation: bounce 1.4s infinite ease-in-out both;
    }
    .dot-floating span:nth-child(1) { animation-delay: -0.32s; }
    .dot-floating span:nth-child(2) { animation-delay: -0.16s; }
    @keyframes bounce {
        0%, 80%, 100% { transform: scale(0); opacity: 0.3; }
        40% { transform: scale(1); opacity: 1; }
    }
</style>

<div class="container-fluid py-3">

    {{-- SEARCH --}}
    <div class="card mb-3">
        <div class="card-body p-2">
            <form method="GET" action="{{ route('sms.index') }}" class="d-flex gap-2">
                <input type="hidden" name="year" value="{{ $yearName }}">
                <input type="hidden" name="semester" value="{{ $termName }}">
                <select class="form-select form-select-sm" name="class_name" required>
                    <option value="">Select Class...</option>
                    @foreach($classes as $row)
                        <option value="{{ $row }}" {{ request('class_name') == $row ? 'selected' : '' }}>
                            {{ $row }}
                        </option>
                    @endforeach
                </select>
                <button class="btn btn-primary btn-sm">SEARCH</button>
            </form>
        </div>
    </div>

    @if($hasQueryParams)
    <div class="row">
        {{-- STUDENTS --}}
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header py-2 d-flex justify-content-between align-items-center">
                    <strong>Class: {{ request('class_name') }}</strong>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="masterSelect">
                        <label class="form-check-label small" for="masterSelect">Select All</label>
                    </div>
                </div>
                <div class="card-body p-2">
                    <input type="text" id="search" class="form-control form-control-sm mb-2" placeholder="Search student...">

                    <form method="POST" action="{{ route('sms.send') }}" id="form">
                        @csrf
                        <input type="hidden" name="year" value="{{ $yearName }}">
                        <input type="hidden" name="semester" value="{{ $termName }}">
                        <input type="hidden" name="send_date" id="hidden_date">
                        <input type="hidden" name="send_time" id="hidden_time">

                        <div class="vstack gap-2">
                            @foreach($students as $row)
                            @php
                                $schoolName = $schoolDetails->school_name ?? 'Shule';
                                $smsTemplate = trim($schoolDetails->sms_temp ?? '');
                                $formattedScores = str_replace(', ', "\n", $row->score_details);

                                $msg = "MZAZI WA {$row->firstname} {$row->lastname},\n";
                                $msg .= "MATOKEO YA MWANAO NI:\n";
                                $msg .= "{$formattedScores}\n";
                                $msg .= "Division: {$row->division}, Points: {$row->total_points}\n";
                                $msg .= $smsTemplate;

                                $length = strlen($msg);
                                $units = ($length <= 160) ? 1 : ceil($length / 153);
                                $search = strtolower($row->firstname.' '.$row->lastname);
                            @endphp

                            <div class="border rounded p-2 student-row"
                                 data-search="{{ $search }}"
                                 data-units="{{ $units }}"
                                 data-msg="{{ $msg }}">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div class="d-flex flex-column">
                                        <div class="form-check">
                                            @if(empty($row->sms))
                                                <input class="form-check-input cb" type="checkbox"
                                                       value="{{ $row->student_id }}"
                                                       name="selected_students[]"
                                                       id="student_{{ $row->student_id }}">
                                                <label class="form-check-label fw-bold" for="student_{{ $row->student_id }}">
                                                    {{ $row->firstname }} {{ $row->lastname }}
                                                </label>
                                            @else
                                                <span class="text-success small">✔ Sent</span>
                                                <span class="fw-bold">{{ $row->firstname }} {{ $row->lastname }}</span>
                                            @endif
                                            <div class="small text-muted">📞 {{ $row->phone ?? 'No phone' }}</div>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-center gap-2">
                                        <span class="badge bg-dark">{{ $units }} Unit(s)</span>
                                        <button type="button" class="btn btn-sm btn-outline-info preview">Preview</button>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- SIDEBAR (Sticky) --}}
        <div class="col-lg-4 sticky-sidebar">
            <div class="card bg-light text-dark">
                <div class="card-body">
                    <h5 class="card-title">SEND SMS</h5>
                    <hr>
                    <table class="table table-bordered table-sm text-dark">
                        <thead>
                            <tr>
                                <th>SMS BALANCE</th>
                                <th>Selected</th>
                                <th>Req units</th>
                                <th>Remains</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><span class="badge bg-success"><strong id="balance">{{ $currentBalance }}</strong></span></td>
                                <td><span class="badge bg-info" id="count">0</span></td>
                                <td><span class="badge bg-warning" id="cost">0</span></td>
                                <td><span class="badge bg-danger" id="remain">0</span></td>
                            </tr>
                        </tbody>
                    </table>
                    <div id="errorMessage" class="alert alert-warning small py-2 mt-2 d-none" style="font-size:0.8rem;"></div>
                    <button class="btn btn-primary w-100" id="sendBtn" disabled>
                        <span id="sendText">SEND</span>
                        <span id="sendSpinner" class="spinner-border spinner-border-sm d-none"></span>
                    </button>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>

{{-- BOOTSTRAP-BASED OVERLAY with three-dot animation and animated progress bar --}}
<div id="sendingOverlay" class="position-fixed top-0 start-0 w-100 h-100 bg-dark bg-opacity-75 d-none align-items-center justify-content-center" style="z-index: 9999;">
    <div class="card shadow-lg border-0" style="max-width: 400px; width: 90%;">
        <div class="card-body text-center p-4">
            <i class="fas fa-sms fa-4x text-primary mb-3"></i>
            <h5 class="card-title">Sending SMS</h5>
            <div class="dot-floating my-3">
                <span></span><span></span><span></span>
            </div>
            <div class="progress mt-3" style="height: 8px;">
                <div id="overlayProgressBar" class="progress-bar bg-primary progress-bar-striped progress-bar-animated" role="progressbar" style="width: 0%"></div>
            </div>
            <p id="overlayStatus" class="mt-2 text-muted small">Preparing...</p>
            <div id="overlayError" class="alert alert-danger py-1 small mt-2 d-none"></div>
            <div class="mt-3">
                <button id="overlayRetryBtn" class="btn btn-warning btn-sm d-none">Retry Batch</button>
                <button id="overlayCancelBtn" class="btn btn-secondary btn-sm d-none">Cancel</button>
            </div>
        </div>
    </div>
</div>

{{-- MODAL --}}
<div class="modal fade" id="modal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">SMS Preview</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <pre id="modalText" class="bg-light p-2 rounded" style="white-space:pre-wrap;"></pre>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function(){
    const checkboxes = document.querySelectorAll('.cb');
    const master = document.getElementById('masterSelect');
    let balance = parseInt(document.getElementById('balance')?.innerText || 0);
    const sendBtn = document.getElementById('sendBtn');
    const sendText = document.getElementById('sendText');
    const sendSpinner = document.getElementById('sendSpinner');
    const errorMsgDiv = document.getElementById('errorMessage');
    
    // Overlay elements
    const overlay = document.getElementById('sendingOverlay');
    const overlayProgressBar = document.getElementById('overlayProgressBar');
    const overlayStatus = document.getElementById('overlayStatus');
    const overlayError = document.getElementById('overlayError');
    const overlayRetryBtn = document.getElementById('overlayRetryBtn');
    const overlayCancelBtn = document.getElementById('overlayCancelBtn');

    const BATCH_SIZE = 10;
    let studentIds = [];
    let totalSent = 0;
    let totalUnitsUsed = 0;
    let failedBatch = null;
    let isSending = false;

    function updateUI() {
        let count = 0, cost = 0;
        checkboxes.forEach(cb => {
            if(cb.checked){
                count++;
                cost += parseInt(cb.closest('.student-row').dataset.units);
            }
        });
        document.getElementById('count').innerText = count;
        document.getElementById('cost').innerText = cost;
        const remaining = balance - cost;
        document.getElementById('remain').innerText = remaining;

        let errorMsg = '';
        let disable = false;

        if (count === 0) {
            errorMsg = 'Please select at least one student.';
            disable = true;
        } else if (cost > balance) {
            errorMsg = 'Insufficient SMS balance. Required units: ' + cost + ', Available: ' + balance;
            disable = true;
        }

        if (errorMsg) {
            errorMsgDiv.innerText = errorMsg;
            errorMsgDiv.classList.remove('d-none');
        } else {
            errorMsgDiv.classList.add('d-none');
        }

        sendBtn.disabled = disable || isSending;
    }

    function showOverlay(showRetry = false, errorMsg = '') {
        overlay.classList.remove('d-none');
        overlay.classList.add('d-flex');
        if (errorMsg) {
            overlayError.innerText = errorMsg;
            overlayError.classList.remove('d-none');
        } else {
            overlayError.classList.add('d-none');
        }
        overlayRetryBtn.classList.toggle('d-none', !showRetry);
        overlayCancelBtn.classList.toggle('d-none', !showRetry);
        overlayProgressBar.classList.add('progress-bar-striped', 'progress-bar-animated');
    }

    function hideOverlay() {
        overlay.classList.add('d-none');
        overlay.classList.remove('d-flex');
        overlayProgressBar.classList.remove('progress-bar-striped', 'progress-bar-animated');
    }

    function updateOverlayProgress(processed, total) {
        const percent = total > 0 ? Math.round((processed / total) * 100) : 0;
        overlayProgressBar.style.width = percent + '%';
        overlayProgressBar.setAttribute('aria-valuenow', percent);
        overlayStatus.innerText = `Sending ${processed} of ${total} SMS...`;
    }

    async function sendBatch(batchIds) {
        const formData = new FormData();
        formData.append('_token', '{{ csrf_token() }}');
        formData.append('year', '{{ $yearName }}');
        formData.append('semester', '{{ $termName }}');
        batchIds.forEach(id => formData.append('selected_students[]', id));

        const response = await fetch('{{ route("sms.sendBatch") }}', {
            method: 'POST',
            body: formData
        });
        if (!response.ok) throw new Error(`HTTP ${response.status}`);
        const result = await response.json();
        if (!result.success) throw new Error(result.message || 'Batch failed');
        return result;
    }

    async function sendBatches() {
        if (isSending) return;
        const selected = Array.from(document.querySelectorAll('.cb:checked'));
        if (selected.length === 0) {
            alert('Please select at least one student.');
            return;
        }

        // Double-check balance before starting
        let totalCost = 0;
        selected.forEach(cb => {
            totalCost += parseInt(cb.closest('.student-row').dataset.units);
        });
        if (totalCost > balance) {
            alert(`Insufficient balance. Required: ${totalCost}, Available: ${balance}`);
            return;
        }

        studentIds = selected.map(cb => cb.value);
        totalSent = 0;
        totalUnitsUsed = 0;
        failedBatch = null;
        isSending = true;
        
        sendBtn.disabled = true;
        sendText.innerText = 'SENDING...';
        sendSpinner.classList.remove('d-none');
        showOverlay(false);
        updateOverlayProgress(0, studentIds.length);
        
        try {
            for (let i = 0; i < studentIds.length; i += BATCH_SIZE) {
                const batch = studentIds.slice(i, i + BATCH_SIZE);
                try {
                    const result = await sendBatch(batch);
                    totalSent += result.sent;
                    totalUnitsUsed += result.units_used;
                    balance = result.new_balance;
                    document.getElementById('balance').innerText = balance;
                    updateUI();
                    updateOverlayProgress(Math.min(i + batch.length, studentIds.length), studentIds.length);
                } catch (err) {
                    failedBatch = { startIndex: i, batchIds: batch };
                    showOverlay(true, `Network error: ${err.message}. Retry this batch?`);
                    overlayRetryBtn.onclick = () => retryFailedBatch();
                    overlayCancelBtn.onclick = () => cancelSending();
                    return;
                }
            }
            hideOverlay();
            alert(`✅ Success! Sent ${totalSent} out of ${studentIds.length} SMS. Units used: ${totalUnitsUsed}.`);
            location.reload();
        } catch (err) {
            hideOverlay();
            alert('Unexpected error: ' + err.message);
        } finally {
            isSending = false;
            sendText.innerText = 'SEND';
            sendSpinner.classList.add('d-none');
            updateUI();
        }
    }

    async function retryFailedBatch() {
        if (!failedBatch) return;
        overlayRetryBtn.classList.add('d-none');
        overlayCancelBtn.classList.add('d-none');
        overlayError.classList.add('d-none');
        showOverlay(false);
        try {
            const result = await sendBatch(failedBatch.batchIds);
            totalSent += result.sent;
            totalUnitsUsed += result.units_used;
            balance = result.new_balance;
            document.getElementById('balance').innerText = balance;
            updateUI();
            const nextStart = failedBatch.startIndex + failedBatch.batchIds.length;
            if (nextStart < studentIds.length) {
                for (let i = nextStart; i < studentIds.length; i += BATCH_SIZE) {
                    const batch = studentIds.slice(i, i + BATCH_SIZE);
                    try {
                        const res = await sendBatch(batch);
                        totalSent += res.sent;
                        totalUnitsUsed += res.units_used;
                        balance = res.new_balance;
                        document.getElementById('balance').innerText = balance;
                        updateUI();
                        updateOverlayProgress(Math.min(i + batch.length, studentIds.length), studentIds.length);
                    } catch (err) {
                        failedBatch = { startIndex: i, batchIds: batch };
                        showOverlay(true, `Network error: ${err.message}. Retry this batch?`);
                        overlayRetryBtn.onclick = () => retryFailedBatch();
                        overlayCancelBtn.onclick = () => cancelSending();
                        return;
                    }
                }
            }
            hideOverlay();
            alert(`✅ Success! Sent ${totalSent} out of ${studentIds.length} SMS. Units used: ${totalUnitsUsed}.`);
            location.reload();
        } catch (err) {
            showOverlay(true, `Retry failed: ${err.message}. Please try again later.`);
            overlayRetryBtn.onclick = () => retryFailedBatch();
            overlayCancelBtn.onclick = () => cancelSending();
        }
    }

    function cancelSending() {
        if (confirm('Cancel sending? Already sent SMS will remain sent.')) {
            hideOverlay();
            isSending = false;
            sendText.innerText = 'SEND';
            sendSpinner.classList.add('d-none');
            updateUI();
            location.reload();
        }
    }

    // Event listeners
    checkboxes.forEach(cb => cb.addEventListener('change', updateUI));
    master?.addEventListener('change', () => {
        checkboxes.forEach(cb => {
            if (window.getComputedStyle(cb.closest('.student-row')).display !== 'none') {
                cb.checked = master.checked;
            }
        });
        updateUI();
    });
    
    sendBtn?.addEventListener('click', (e) => {
        e.preventDefault();
        if (!isSending) sendBatches();
    });
    
    document.querySelectorAll('.preview').forEach(btn => {
        btn.onclick = function(){
            document.getElementById('modalText').innerText = this.closest('.student-row').dataset.msg;
            new bootstrap.Modal(document.getElementById('modal')).show();
        };
    });
    
    document.getElementById('search')?.addEventListener('keyup', function(){
        let val = this.value.toLowerCase();
        document.querySelectorAll('.student-row').forEach(row => {
            row.style.display = row.dataset.search.includes(val) ? 'block' : 'none';
        });
    });
    
    updateUI();
});
</script>
@endsection