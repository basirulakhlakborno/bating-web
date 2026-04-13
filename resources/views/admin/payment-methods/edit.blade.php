@extends('admin.layout')

@section('pretitle', 'Payment methods')
@section('title', 'Edit payment method')

@section('content')
    <form action="{{ route('admin.payment-methods.update', $method) }}" method="post" class="card">
        <div class="card-body">
            @csrf
            @method('PUT')
            @include('admin.payment-methods._form', ['method' => $method])
        </div>
        <div class="card-footer text-end">
            <a href="{{ route('admin.payment-methods.index') }}" class="btn btn-link me-2">Cancel</a>
            <button type="submit" class="btn btn-primary">Save changes</button>
        </div>
    </form>
@endsection
