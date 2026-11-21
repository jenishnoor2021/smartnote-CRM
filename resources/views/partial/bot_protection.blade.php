@php
    $key = $formKey ?? 'default';
    $requireMath = $includeMath ?? true;
    $challenge = \App\Services\BotProtectionService::generateChallenge($key);
@endphp

<!-- Anti-Bot Honeypot Trap (invisible to humans, traps automated spam crawlers) -->
<div class="sn-hp-trap" style="display:none!important; position:absolute; left:-9999px; z-index:-1; opacity:0; pointer-events:none;" aria-hidden="true">
    <label for="website_hp_{{ $key }}">Leave this field blank</label>
    <input type="text" name="website_hp" id="website_hp_{{ $key }}" tabindex="-1" autocomplete="off" value="">
</div>
<input type="hidden" name="_form_time" class="sn-form-time" value="{{ $challenge['rendered_at'] }}">

@if($requireMath)
<div class="sn-bot-security-box mb-3 p-3 rounded" id="snBotBox_{{ $key }}" style="background: #f8fafc; border: 1px dashed #cbd5e1;">
    <div class="d-flex align-items-center justify-content-between mb-2">
        <label class="form-label mb-0 fw-bold small text-dark d-flex align-items-center gap-1">
            <i class="fa-solid fa-shield-halved text-primary"></i>
            <span>{{ $label ?? 'Human Verification / સુરક્ષા ચકાસણી' }} <span class="text-danger">*</span></span>
        </label>
        <button type="button" class="btn btn-sm btn-link text-decoration-none py-0 px-1 text-muted sn-btn-refresh-captcha" data-target="{{ $key }}" title="Get another question">
            <i class="fa-solid fa-arrows-rotate"></i> <span class="small" style="font-size: 12px;">Refresh</span>
        </button>
    </div>
    <div class="d-flex align-items-center gap-2">
        <div class="sn-captcha-badge px-3 py-2 rounded bg-white text-dark fw-bold border text-center shadow-sm" style="font-size: 15px; min-width: 95px; letter-spacing: 1px; user-select: none;">
            <span class="sn-captcha-question-text">{{ $challenge['question'] }}</span>
        </div>
        <div style="flex: 1; max-width: 150px;">
            <input type="number" name="captcha_answer" class="form-control sn-captcha-input" placeholder="Answer..." required min="0" max="99" style="height: 42px; border-radius: 6px;">
        </div>
        <input type="hidden" name="captcha_token" class="sn-captcha-token" value="{{ $challenge['token'] }}">
    </div>
    <div class="text-muted small mt-1" style="font-size: 11px;">
        <i class="fa-solid fa-lock text-success me-1"></i> Protected by Smart Notes Anti-Bot Shield.
    </div>
</div>
@endif

