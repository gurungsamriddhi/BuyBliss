@extends('admin.dashboard') <!-- This is your dashboard.blade.php layout -->

@section('admin_content')
<div class="container mt-4">
    <h2>Welcome, {{ Auth::user()->name }} </h2>
    <p>This is the main admin dashboard page.</p>

    <!-- Example cards -->
    <div class="row mt-3">
        <div class="col-md-4">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    Total Users: 123
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card bg-success text-white">
                <div class="card-body">
                    Pending Orders: 45
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
