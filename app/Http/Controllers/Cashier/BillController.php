<?php

namespace App\Http\Controllers\Cashier;

use App\Food;
use App\FoodOrder;
use App\Http\Controllers\Controller;
use App\Order;
use App\Scheme;
use App\Stock;
// use App\Table;
use Carbon\Carbon;
use Illuminate\Http\Request;

class BillController extends Controller
{
    // public function index(){
    //     return view('pages.billing.index')->with('foods',Food::all());
    // }

    public function index()
    {
        return view('pages.billing.index')->with('foods', Food::all());
    }
    public function reprint($order){
        $order=Order::where('id',$order)->first();
        $foods=$order->foods;
        $reprint=true;
        return view('pages.billing.bill', compact('order', 'foods','reprint'));
    }
    public function checkout(Request $request)
    {
        if($request->discount){
            if($request->discount<0&&$request->discount>100){
                return redirect()->back();
            }
            $discount=($request->discount)/100;
            
        }else{
            $discount=0;
        }
        $grand_total=\Cart::session(auth()->id())->getTotal();
        $discountAmount = $discount*$grand_total;
        $required_amount=$grand_total-$discountAmount;

        if($request->paid_amount<($required_amount)){
            toastr()->error('Paid amount Rs ' . $request->paid_amount . ' is less than ' . $required_amount, 'Error!!!');
            return redirect()->back();
        }
        // dd(\Cart::session(auth()->id())->getContent());
        // dd($cartConditions);
        $items = \Cart::session(auth()->id())->getContent();
        if ($items->count() === 0) {
            return redirect()->back();
        }
        foreach ($items as $item) {
            $stock = Stock::where('food_id', $item->id)->whereDate('from_date', Carbon::today())->first();
            if ($stock) {
                if ($request->has('scheme')) {
                    $status = true;
                } else {
                    $status = false;
                }
                $scheme = Scheme::where('food_id', $item->id)->whereDate('start_date', '<=', Carbon::today())->whereDate('end_date', '>=', Carbon::today())->first();
                if ($scheme && $status) {
                    $add_quantity = intval($item->quantity / $scheme->quantity);
                    // dd($add_quantity);
                } else {
                    $add_quantity = 0;
                }
                if ($stock->remaining_quantity < ($item->quantity + $add_quantity)) {
                    if($add_quantity==0){
                        toastr()->error('You can only add ' . ($stock->remaining_quantity) . ' items for' . $stock->food->name, 'Error!!!');
                        return redirect()->back();
                    }else{
                        toastr()->error('You can only add ' . ($stock->remaining_quantity-$add_quantity) . ' items for ' . $stock->food->name .' including scheme quantity', 'Error!!!');
                        return redirect()->back();
                    }
                    
                }
            } else {
                toastr()->error('No Stock for the food ' . $item->name, 'Error!!!');
                return redirect()->back();
            }
            $scheme_quantity[] = $add_quantity;
        }
        // $table=Table::where('id',$request->table)->first();
        if($request->payment==1){
            $payment='Cash';
        }elseif($request->payment==2){

            $payment='Card';
        }else{
            $payment='Online';
        }
        $i = 0;

        foreach ($items as $item) {
            $stock = Stock::where('food_id', $item->id)->whereDate('from_date', Carbon::today())->first();
            $stock->remaining_quantity = $stock->remaining_quantity - ($item->quantity + $scheme_quantity[$i]);
            $stock->save();
            $i++;
        }



        $lastOrder = Order::orderBy('created_at', 'desc')->whereDate('created_at', Carbon::today())->first();
        if ($lastOrder) {
            $token_no = $lastOrder->token_no + 1;
        } else {
            $token_no = 1;
        }
        
        $order = Order::create([
            'user_id' => auth()->id(),
            'grand_total' => \Cart::session(auth()->id())->getSubTotal(),
            'sub_total' => \Cart::session(auth()->id())->getTotal(),
            'token_no' => $token_no,
            'payment'=>$payment,
            'paid_amount'=>$request->paid_amount
                    ]);
            $discountAmount = $discount*$order->grand_total;
            $order->grand_total= $order->grand_total - $discountAmount;
            $order->save();
        $i = 0;

        foreach ($items as $item) {
            FoodOrder::create([
                'food_id' => $item->id,
                'order_id' => $order->id,
                'price' => $item->price,
                'quantity' => $item->quantity,
                'scheme' => $scheme_quantity[$i]
            ]);
            $i++;
        }
        // dd($scheme_quantity);


        $cartConditions = \Cart::session(auth()->id())->getConditions();



        \Cart::session(auth()->id())->clear();
        \Cart::session(auth()->id())->clearCartConditions();
        $scheme_quantity[] = [];
        $foods = $order->foods;
        // dd($order->table);
        $reprint=false;


        return view('pages.billing.bill', compact('order', 'foods','reprint'));
    }

    public function search(Request $request){
        $searchTerm = '%'.$request->search.'%';

        $foods=Food::where('name','like',$searchTerm)->pluck('id');
        $stocks=[];
        foreach($foods as $food_id){
            $stock=Stock::where('food_id',$food_id)->whereDate('from_date',Carbon::today())->where('remaining_quantity','>',0)->get();
            
      
            if($stock->count()==0){
            
         
            }else{
                array_push($stocks,$stock);

            }
            return view('pages.billing.index')->with('foods');

        }
  
        return $stocks;
    
}
}
