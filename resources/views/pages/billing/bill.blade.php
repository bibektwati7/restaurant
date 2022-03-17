<style>
    * {
        font-size: 13px;
        font-weight: 500;
    }

    td,
    th,
    tr,
    table {
        text-align: center;
        border-top: 1px solid black;
        border-collapse: collapse;
    }

    td.sn,
    th.sn {
        width: 60px;
        text-align: center;

        max-width: 60px;
    }

    td.item,
    th.item {
        width: 60px;
        text-align: center;

        max-width: 60px;
        /*word-break: break-all;*/
    }

    td.qty,
    th.qty {
        width: 60px;
        text-align: center;

        max-width: 60px;
        word-break: break-all;
    }

    td.rate,
    th.rate {
        width: 60px;
        text-align: center;

        max-width: 60px;
        word-break: break-all;
    }

    td.total,
    th.total {
        width: 80px;
        text-align: center;

        max-width: 80x;
        word-break: break-all;
    }



    .centered {
        text-align: center;
        align-content: center;
    }

    .right {
        text-align: right;
    }

    .ticket {
        width: 320px;
        max-width: 320px;
        line-height: 5mm !important;

    }

    img {
        max-width: inherit;
        width: inherit;
    }



    @media print {

        html,
        body {
            font-size: 14px;
        }

        .ticket {
            width: 320px;
            max-width: 320px;
            min-height: 10px;
            line-height: 200%;
            min-height: 5px;
            font-weight: 400;

        }

        h6 {
            page-break-after: always;

        }

        .hidden-print,
        .hidden-print * {
            display: none !important;
        }
    }

</style>

<div class="ticket">
    @if($reprint)
    <p class="right">
        <span style="font-size:16px;font-weight:700;">REPRINT</span>
    </p>
    @endif
    <p class="centered"><span
            style="font-size:16px;font-weight:700;">{{ Session::get('settings_restaurant_name') }}</span>
        <br>{{ Session::get('settings_restaurant_address') }}

        <br>📞 {{ Session::get('settings_contact_number') }}</p>

    <p>Date: <?php $mytime = Carbon\Carbon::now();
echo $mytime->toDateTimeString();?><br>
        Token No: {{$order->token_no}}<br>
        Payment Mode: {{$order->payment}}
    </p>



    <table>
        <thead>
            <tr>
                <th class="sn">S.N.</th>
                <th class="item">Items</th>
                <th class="qty">Qty</th>
                <th class="rate">Rate</th>
                <th class="total">Total</th>


            </tr>
        </thead>
        <tbody>
            <?php $sn=0?>
            @foreach($order->foods as $key => $food)
            <tr>
                <td class="sn">{{++$sn}}</td>
                <td class="item">{{ $food->name }}</td>
                <td class="qty">{{ $food->pivot->quantity }}</td>
                <td class="rate">Rs. {{ $food->price }}</td>
                <th class="total">Rs. {{$food->pivot->price * $food->pivot->quantity}}</th>

            </tr>
            @if($food->pivot->scheme>=1)
            <td class="sn">{{++$sn}}</td>
            <td class="item">{{ $food->name }} (Scheme)</td>
            <td class="qty">{{ $food->pivot->scheme }}</td>
            <td class="rate">Rs. 0</td>
            <th class="total">Rs. 0</th>
            @endif
            @endforeach
            <tr>
                <td colspan="6" style="text-align:left;"> <b>Customer Paid Amount:</b> Rs.
                    {{ $order->paid_amount }}</td>
            </tr>
            <tr>
                <td colspan="6" style="text-align:left;"> <b>Discount:</b> Rs.
                    {{ $order->sub_total-$order->grand_total }}</td>
            </tr>

            <tr>
                <td colspan="6" style="text-align:left;"> <b> Grand Total:</b> Rs. {{ $order->grand_total }}</td>
            </tr>

        </tbody>
    </table>

    <h6 class="centered" id="page-break">Thank You for dining with us.<br>
        Visit Again.<br><br>
        <span style="font-size:9px;">* All prices are inclusive of Government Taxes. *</span></h6>

</div>
<button id="btnPrint " onclick="doPrint() " class="hidden-print">Print</button>
<script>
    function doPrint() {
        window.print();
        document.location.href = "http://localhost:8000/billing/";
    }

</script>