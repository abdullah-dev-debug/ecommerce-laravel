@php
$defaultLabel = "Password";
@endphp
<div class="fm-group">
    <label for="password">{{ $label ?? $defaultLabel }}</label>
    <div class="password-input-wrap">
        <input type="password" placeholder="Enter {{ $label ?? $defaultLabel }}" name="{{ $name ?? 'password' }}" class="form-control password-input"
            autocomplete="off" {{ $required ?? 'required' }} >
        <i class="fa fa-eye-slash password-eye-btn"></i>
    </div>
</div>