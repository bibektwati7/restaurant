@extends('layouts.app')
@section('content')
<style>
    @page {
        size: A4;
        margin: 0;
    }

    .cancel {
        text-decoration: line-through;
    }

    @media print {
        #printButton {
            visibility: hidden;
        }

        #kt_header_mobile {
            visibility: hidden;
        }

        .table-responsive {
            overflow-x: visible;
        }
    }

</style>
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <div class="d-flex flex-column-fluid">
        <div class="container">
            <div class="row mt-0 mt-lg-8">
                <div class="col-xl-12">
                    <div class="card card-custom card-stretch card-shadowless gutter-b">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="text-left">
                                        <b>From : {{$start_date ?? ''}} </b><br>
                                        <b> To : {{$end_date ?? ''}} </b>
                                    </div>
                                    <div class="text-center">
                                        <span class="title text-capitalize">
                                            <h2>{{ Session::get('settings_restaurant_name') }}</h2>
                                        </span>
                                        <span
                                            class="text-uppercase">{{Session::get('settings_restaurant_address')}}</span>
                                        <h4 class="mt-2">Order Report</h4>

                                    </div>


                                </div>
                            </div>
                            <hr>
                            <div class="table-responsive">
                                <table class="table table-head-custom table-vertical-center"
                                    id="kt_advance_table_widget_1">
                                    <thead>
                                        <th>Bill no</th>
                                        <th>Date</th>
                                        <th>Food</th>
                                        <th>Quantity</th>
                                        <th>Price</th>
                                        <th>Total</th>
                                        <th>Discount</th>
                                        <th>User</th>
                                        <th>Grand Total</th>
                                        <th>Paid Amount</th>
                                        <th>Status</th>
                                    </thead>

                                    <tbody>

                                        @foreach($orders as $key => $order)
                                        <?php
                                         $order_id="";
                                        ?>

                                        @foreach($order->foods as $key => $food)


                                        <tr>
                                            @if($order_id == $order->id)
                                            <td></td>
                                            <td></td>
                                            @else
                                            <td class="{{ $order->status==1 ? 'cancel' : '' }}"> {{ $order->id}}</td>

                                            <td class="{{ $order->status==1 ? 'cancel' : '' }}">
                                                {{ $order->created_at->format('Y-m-d') }}</td>

                                            @endif


                                            <td class="{{ $order->status==1 ? 'cancel' : '' }}">{{ $food->name }}</td>
                                            <td class="{{ $order->status==1 ? 'cancel' : '' }}">
                                                {{ $food->pivot->quantity }}</td>
                                            <td class="{{ $order->status==1 ? 'cancel' : '' }}">
                                                {{ $food->pivot->price }}</td>
                                            <td class="{{ $order->status==1 ? 'cancel' : '' }}">
                                                {{ $food->pivot->price*$food->pivot->quantity }}</td>
                                            @if($order_id == $order->id)
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>


                                            @else
                                            <td class="{{ $order->status==1 ? 'cancel' : '' }}"> Rs
                                                {{ $order->sub_total-$order->grand_total}}</td>
                                            <td class="{{ $order->status==1 ? 'cancel' : '' }}">{{$order->user->name}}
                                            </td>

                                            <td class="{{ $order->status==1 ? 'cancel' : '' }}"><b> Rs
                                                    {{ $order->grand_total}}<b></td>
                                            <td class="{{ $order->status==1 ? 'cancel' : '' }}"> Rs
                                                {{ $order->paid_amount}}</td>

                                            @endif
                                            @if($order_id == $order->id)
                                            <td></td>
                                            @else
                                            @if($order->status===1)
                                            <td class="text-danger">Cancelled</td>
                                            @else
                                            <td class="text-success">Active</td>

                                            @endif
                                            @endif

                                        </tr>
                                        <?php $order_id=$order->id?>


                                        @endforeach

                                        @endforeach

                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td></td>

                                            <td></td>

                                            <td></td>
                                            <td></td>





                                            <td>Grand Total :</td>
                                            <td>Rs {{ $grand_total }}</td>
                                            <td></td>
                                            <td></td>
                                            <td></td>

                                        </tr>


                                    </tbody>
                                </table>
                                <div class="row justify-content-right py-8 px-8 py-md-10 px-md-0">
                                    <div class="col-md-12">
                                        <div class="d-flex justify-content-between">
                                            <button type="button" class="btn btn-primary font-weight-bold"
                                                id="printButton" onclick="window.print();">Print Report</button>
                                        </div>
                                    </div>
                                </div>

                            </div>

                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>

</div>

@endsection