@extends('layout.default')
@section('title','订单统计')
@section('content')
    <div class="panel panel-info">
        <div class="row">
            <div class="col-sm-12">
                <table class="table table-bordered">
                    <tr>
                        <td>订单日统计</td>
                        <td>订单月统计</td>
                        <td>订单总统计</td>
                    </tr>
                    <tr>
                        <td>{{$day}}</td>
                        <td>{{$month}}</td>
                        <td>{{$total}}</td>
                    </tr>
                    <tr>
                        <form action="{{route('order.time')}}" method="post" class="form-control">
                            <th>
                                日查询:<input type="date" name="date">
                                <button class="btn btn-group-sm btn-info">查询</button>
                            </th>
                            <th>
                                月查询:<input type="month" name="month">
                                <button class="btn btn-group-sm btn-info">查询</button>
                            </th>
                            <th>
                                范围查询:<input type="datetime-local" name="datetime1">--
                                <input type="datetime-local" name="datetime2">
                                <button class="btn btn-group-sm btn-info">查询</button>
                            </th>
                            {{ csrf_field() }}
                        </form>
                    </tr>
                </table>
            </div>
        </div>
    </div>
    @stop