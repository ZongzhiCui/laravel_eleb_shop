@extends('layout.default')
@section('title','查询统计')
@section('content')
    <table class="table table-bordered">
        <tr>
            <td>菜品ID</td>
            <td>菜品数量</td>
        </tr>
        @foreach($count as $row)
        <tr>
            <td>{{$row->foods_id}}</td>
            <td>{{$row->d}}</td>
        </tr>
        @endforeach
    </table>
    @stop