@extends('template.layout')
@section('title', 'Home Page')
@section('content')

<x-alert style="success">
    This is a success alert message.
</x-alert>

<x-alert style="info">
    This is an info alert message.
</x-alert>

@unless (Auth::check())
    <p>Welcome, Guest! Please login to access more features.</p>
@endunless

@auth
    <p>Welcome, {{ Auth::user()->name }}! You are logged in.</p>
@endauth

@isset($pengguna)
    <p>There are {{ count($pengguna) }} users available.</p>
@else
    <p>No users available.</p>
@endisset
@empty($pengguna)
    <p>No users found.</p>
@endempty

<h1>Welcome to the Home Page</h1>

<table border="1">
    <th>Name</th>
    <th>Age</th>
    <th>Address</th>
    @foreach ($users as $user)
        <tr>
            <td>{{ $user['name'] }}</td>
            <td>{{ $user['age'] }}</td>
            <td>{{ $user['address'] }}</td>
        </tr>
    @endforeach
</table>

@endsection

@push('styles')
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }

        th, td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
@endpush

@push('scripts')
    <script>
        console.log('Home page script loaded.');
    </script>
@endpush
