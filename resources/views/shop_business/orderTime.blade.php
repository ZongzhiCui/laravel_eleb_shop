@extends('layout.default')
@section('title','订单统计')
@section('content')
    <table class="table table-bordered">
        <tr>
            <td>{{$count}}</td>
        </tr>
    </table>
    @stop