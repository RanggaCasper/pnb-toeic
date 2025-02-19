@extends('layouts.export')
@section('title', $title)

@section('content')
<div class="table-container">
    <table>
        <thead>
            <tr>
                <th>Name</th>
                <th>Identity</th>
                <th>Gender</th>
                <th>Program Study</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $item)
                <tr>
                    <td>{{ $item->name }}</td>
                    <td>{{ $item->identity }}</td>
                    <td>{{ $item->gender }}</td>
                    <td>{{ $item->programStudy->name ?? 'N/A' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection