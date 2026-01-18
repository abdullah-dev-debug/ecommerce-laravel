@php
    $customers = $comanData['customers'] ?? [];
    $countries = $comanData['countries'] ?? [];
@endphp

{{-- CUSTOMER --}}
<div class="fm-group">
    <label for="customer_id">Customer</label>
    <select name="customer_id" id="customer_id" class="form-select">
        <option value="">Select Customer</option>
        @foreach ($customers as $customer)
            <option value="{{ $customer->id }}" {{ old('customer_id', $address->customer_id ?? '') == $customer->id ? 'selected' : '' }}>
                {{ $customer->name }}
            </option>
        @endforeach
    </select>
</div>
<div class="item-wrap">
    {{-- FIRST NAME --}}
    <div class="fm-group">
        <label for="first_name">First Name</label>
        <input type="text" name="first_name" id="first_name" class="form-control" placeholder="Enter First Name"
            value="{{ old('first_name', $address->first_name ?? '') }}">
    </div>

    {{-- LAST NAME --}}
    <div class="fm-group">
        <label for="last_name">Last Name</label>
        <input type="text" name="last_name" id="last_name" class="form-control" placeholder="Enter Last Name"
            value="{{ old('last_name', $address->last_name ?? '') }}">
    </div>
</div>

<div class="item-wrap">
    {{-- EMAIL --}}
    <div class="fm-group">
        <label for="email">Email</label>
        <input type="email" name="email" id="email" class="form-control" placeholder="Enter Email"
            value="{{ old('email', $address->email ?? '') }}">
    </div>

    {{-- PHONE --}}
    <div class="fm-group">
        <label for="phone">Phone</label>
        <input type="text" name="phone" id="phone" class="form-control" placeholder="Enter Phone"
            value="{{ old('phone', $address->phone ?? '') }}">
    </div>

</div>



{{-- ADDRESS TYPE --}}
<div class="fm-group">
    <label for="address_type">Address Type</label>
    <select name="address_type" id="address_type" class="form-select">
        <option value="" disabled selected>Select Address Type</option>

        <option value="shipping" {{ old('address_type', $address->address_type ?? 'shipping') == 'shipping' ? 'selected' : '' }}>
            Shipping
        </option>

        <option value="billing" {{ old('address_type', $address->address_type ?? '') == 'billing' ? 'selected' : '' }}>
            Billing
        </option>
    </select>
</div>


{{-- ADDRESS --}}
<div class="fm-group">
    <label for="address">Address</label>
    <textarea name="address" id="address" class="form-control" rows="3"
        placeholder="Enter Address">{{ old('address', $address->address ?? '') }}</textarea>
</div>

<div class="item-wrap">
    {{-- COUNTRY --}}
    <div class="fm-group">
        <label for="country_id">Country</label>
        <select name="country_id" id="country_id" class="form-select">
            <option value="">Select Country</option>
            @foreach ($countries as $country)
                <option value="{{ $country->id }}" {{ old('country_id', $address->country_id ?? '') == $country->id ? 'selected' : '' }}>
                    {{ $country->name }}
                </option>
            @endforeach
        </select>
    </div>

    {{-- STATE --}}
    <div class="fm-group">
        <label for="state">State</label>
        <input type="text" name="state" id="state" class="form-control" placeholder="Enter State"
            value="{{ old('state', $address->state ?? '') }}">
    </div>
</div>

<div class="item-wrap">
    
    {{-- CITY --}}
    <div class="fm-group">
        <label for="city">City</label>
        <input type="text" name="city" id="city" class="form-control" placeholder="Enter City"
            value="{{ old('city', $address->city ?? '') }}">
    </div>

    {{-- PIN CODE --}}
    <div class="fm-group">
        <label for="pin_code">Pin Code</label>
        <input type="text" name="pin_code" id="pin_code" class="form-control" placeholder="Enter Pin Code"
            value="{{ old('pin_code', $address->pin_code ?? '') }}">
    </div>
</div>