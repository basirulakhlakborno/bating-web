@extends('admin.layout')

@section('pretitle', 'Payment methods')
@section('title', 'Add payment method')

@section('content')
    <form action="{{ route('admin.payment-methods.store') }}" method="post" class="card">
        <div class="card-body">
            @csrf
            @include('admin.payment-methods._form')
        </div>
        <div class="card-footer text-end">
            <a href="{{ route('admin.payment-methods.index') }}" class="btn btn-link me-2">Cancel</a>
            <button type="submit" class="btn btn-primary">Add method</button>
        </div>
    </form>
@endsection
