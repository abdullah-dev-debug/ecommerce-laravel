@php
    $vendorStatus = [
        ["name" => "Pending", "value" => "pending"],
        ["name" => "Active", "value" => "active"],
        ["name" => "Suspended", "value" => "suspended"]
    ];
@endphp
<form action="{{ $action }}" method="post">
    <div class="card">
        <div class="myPage-inner-container">
            <h5><i class="fa fa-users mr-3"></i> {{ $vendor ? "Edit Vendor" : 'Add New Vendor' }}</h3>
                <hr>
                @csrf
                @if (!empty($vendor->id))
                    @method('PUT')
                @endif
                <div class="fm-group">
                    <label for="name">Name</label>
                    <input type="text" name="name" value="{{ old('name', $vendor->name ?? '') }}"
                        placeholder="Enter Name" class="form-control">
                </div>
                <div class="fm-group">
                    <label for="email">Email</label>
                    <input type="email" name="email" placeholder="Enter Email" class="form-control"
                        value="{{ old('email', $vendor->email ?? '') }}">
                </div>
                <div class="fm-group">
                    <label for="phone">Phone</label>
                    <input type="tel" name="phone" placeholder="Enter Phone" class="form-control"
                        value="{{ old('phone', $vendor->phone ?? '') }}">
                </div>
                <div class="fm-group">
                    <label for="address">Address</label>
                    <input type="text" name="address" placeholder="Enter Address" class="form-control"
                        value="{{ old('address', $vendor->address ?? '') }}">
                </div>
                @include('partials._password_field',["required" => ''])
                <div class="fm-group">
                    <label for="status">Status</label>
                    <select name="status" id="status" class="form-select">
                        <option value="" selected disabled>Select Status</option>
                        @foreach ($vendorStatus as $status)
                            <option value="{{ $status['value'] }}" {{ $vendor ? $vendor->status == $status['value'] ? 'selected' : '' : ''  }}>{{ $status['name'] }}</option>
                        @endforeach
                    </select>
                </div>

        </div>
    </div>
    <div class="myPage-item-align-end mt-4">
        <a href="{{ route('admin.vendor.list') }}" class="bs-btn bs-btn-cancel">
            Cancel
        </a>
        <button type="submit" class="bs-btn bs-btn-primary">
            {{ $vendor ? 'Save Change' : 'Save' }}
        </button>
    </div>
</form>