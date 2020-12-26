@extends('admin.layouts.app')

@section('main')
@livewire('subscription-member-form', ['id' => $id])
@endsection