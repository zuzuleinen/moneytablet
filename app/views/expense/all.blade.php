@extends('layout/layout')
@section('content')
<h3>All expenses for {{$tablet->name}}</h3>
<table class="table table-condensed">
      <thead>
        <tr>
          <th>Exense</th>
          <th>Value</th>
          <th>Date</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($expenses as $expense)
        <tr>
            <td>{{ $expense->name }}</td>
            <td>{{ $expense->value }}</td>
            <td>{{ $expense->created_at }}</td>
        </tr>
        @endforeach
      </tbody>
    </table>
@stop