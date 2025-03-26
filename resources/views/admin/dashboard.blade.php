@extends('layouts.admin')

@section('content')
    <div class="container">
        <h1>Welcome, Admin</h1>
        <div class="row">
            <div class="col-md-4">
                <div class="card bg-primary text-white p-3">
                    <h3>Total Users</h3>
                    <p>{{ \App\Models\User::count() }}</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card bg-success text-white p-3">
                    <h3>Total Products</h3>
                    <p>{{ \App\Models\Product::count() }}</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card bg-warning text-dark p-3">
                    <h3>Total Orders</h3>
                    <p>{{ \App\Models\Order::count() }}</p>
                </div>
            </div>
        </div>
    </div>
@endsection
