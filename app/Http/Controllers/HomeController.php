<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Comment;
use App\Models\Order;
use App\Models\Product;
use App\Models\Reply;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Session;
use Stripe\Charge;
use Stripe\Stripe;
use RealRashid\SweetAlert\Facades\Alert;

class HomeController extends Controller
{
    public function index()
    {
        $products = Product::paginate(3);
        $comments = Comment::orderby('id', 'desc')->get();
        $replys = Reply::orderby('id', 'desc')->get();
        return view('home.userpage', compact('products', 'comments', 'replys'));
    }

    public function redirect()
    {
        $usertype = Auth::user()->usertype;
        if ($usertype == '1') {
            $total_product = Product::all()->count();
            $total_order = Order::all()->count();
            $total_customer = User::all()->count();
            $orders = Order::all();
            $total_revenue = 0;
            foreach ($orders as $order) {
                $total_revenue = $total_revenue + $order->price;
            }
            $total_delivered = Order::where('delivery_status', '=', 'delivered')->get()->count();
            $total_processing = Order::where('delivery_status', '=', 'processing')->get()->count();
            return view('admin.home', compact('total_product', 'total_order', 'total_customer', 'total_revenue', 'total_delivered', 'total_processing'));
        } else {
            $products = Product::paginate(3);
            $comments = Comment::orderby('id', 'desc')->get();
            $replys = Reply::orderby('id', 'desc')->get();
            return view('home.userpage', compact('products', 'comments', 'replys'));
        }
    }

    public function product_details($id)
    {
        $product = Product::find($id);
        return view('home.product_details', compact('product'));
    }

    public function add_cart(Request $request, $id)
    {
        if (Auth::id()) {
            $user = Auth::user();
            $useris = $user->id;

            $product = Product::find($id);

            $product_exist_id = Cart::where('product_id', '=', $id)->where('user_id', '=', $useris)->get('id')->first();

            if ($product_exist_id) {
                $cart = Cart::find($product_exist_id)->first();
                $quantity = $cart->quantity;
                $cart->quantity = $quantity + $request->quantity;
                if ($product->discount_price != null) {
                    $cart->price = $request->quantity * $product->discount_price;
                } else {
                    $cart->price = $request->quantity * $product->price;
                }

                $cart->save();
                Alert::success('Product Added Succesfully', 'We have added product to the cart');
                return redirect()->back();
                // return redirect()->back()->with('message', 'Product Have been Added Succesfully !');
            } else {
                $cart = new Cart();
                $cart->name = $user->name;
                $cart->email = $user->email;
                $cart->phone = $user->phone;
                $cart->address = $user->address;
                $cart->user_id = $user->id;

                $cart->product_title = $product->title;
                if ($product->discount_price != null) {
                    $cart->price = $request->quantity * $product->discount_price;
                } else {
                    $cart->price = $request->quantity * $product->price;
                }

                $cart->image = $product->image;
                $cart->product_id = $product->id;

                $cart->quantity = $request->quantity;

                $cart->save();
                Alert::success('Product Added Succesfully', 'We have added product to the cart');
                return redirect()->back();
                // return redirect()->back()->with('message', 'Product Have been Added Succesfully !');
            }
        } else {
            return redirect('login');
        }
    }

    public function show_cart()
    {
        if (Auth::id()) {
            $id = Auth::user()->id;
            $carts = Cart::where('user_id', '=', $id)->get();
            return view('home.showcart', compact('carts'));
        } else {
            return redirect('login');
        }
    }

    public function remove_cart($id)
    {
        $cart = Cart::find($id);
        $cart->delete();
        return redirect()->back();
    }

    public function cash_order()
    {
        // if (Auth::id()) {
        $user = Auth::user();
        $userid = $user->id;

        $data = Cart::where('user_id', '=', $userid)->get();

        foreach ($data as $data) {
            $order = new Order();
            $order->name = $data->name;
            $order->email = $data->email;
            $order->phone = $data->phone;
            $order->address = $data->address;
            $order->user_id = $data->user_id;

            $order->product_title = $data->product_title;
            $order->price = $data->price;
            $order->quantity = $data->quantity;
            $order->image = $data->image;
            $order->product_id = $data->product_id;

            $order->payment_status = 'Cash on Delivery';
            $order->delivery_status = 'Processing';

            $order->save();
            $cart_id = $data->id;
            $cart = Cart::find($cart_id);
            $cart->delete();

            $product_id = $data->product_id;
            $product = Product::find($product_id);
            $product->quantity = $product->quantity - $order->quantity;
            $product->save();
        }
        return redirect()->back()->with('message', 'Pesanan Berhasil Diproses !');
    }

    public function stripe($totalprice)
    {
        return view('home.stripe', compact('totalprice'))->with('message', 'Pesanan Berhasil Diproses !');
    }

    public function stripePost(Request $request, $totalprice)
    {
        Stripe::setApiKey(env('STRIPE_SECRET'));

        Charge::create([
            "amount" => $totalprice * 100,
            "currency" => "usd",
            "source" => $request->stripeToken,
            "description" => "Thanks for Payment"
        ]);

        $user = Auth::user();
        $userid = $user->id;

        $data = Cart::where('user_id', '=', $userid)->get();

        foreach ($data as $data) {
            $order = new Order();
            $order->name = $data->name;
            $order->email = $data->email;
            $order->phone = $data->phone;
            $order->address = $data->address;
            $order->user_id = $data->user_id;

            $order->product_title = $data->product_title;
            $order->price = $data->price;
            $order->quantity = $data->quantity;
            $order->image = $data->image;
            $order->product_id = $data->product_id;

            $order->payment_status = 'Paid';
            $order->delivery_status = 'Processing';

            $order->save();
            $cart_id = $data->id;
            $cart = Cart::find($cart_id);
            $cart->delete();

            $product_id = $data->product_id;
            $product = Product::find($product_id);
            $product->quantity = $product->quantity - $order->quantity;
            $product->save();
        }

        Session::flash('success', 'Payment successful!');

        return back();
    }

    public function show_order()
    {
        if (Auth::id()) {
            $id = Auth::user()->id;
            $orders = Order::where('user_id', '=', $id)->get();
            return view('home.order', compact('orders'));
        } else {
            return redirect('login');
        }
    }

    public function cancel_order($id)
    {
        $order = Order::find($id);

        $order->delivery_status = 'Cancelled Order';
        $order->save();

        return redirect()->back();
    }

    public function add_comment(Request $request)
    {
        if (Auth::id()) {
            $id = Auth::user()->id;
            $comment = new Comment();

            $comment->name = Auth::user()->name;
            $comment->comment = $request->comment;
            $comment->user_id = $id;
            $comment->save();
            return redirect()->back();
        } else {
            return redirect('login');
        }
    }

    public function add_reply(Request $request)
    {
        if (Auth::id()) {
            $id = Auth::user()->id;
            $reply = new Reply();

            $reply->name = Auth::user()->name;
            $reply->comment_id = $request->commentId;
            $reply->reply = $request->reply;
            $reply->user_id = $id;
            $reply->save();
            return redirect()->back();
        } else {
            return redirect('login');
        }
    }

    public function product_search(Request $request)
    {
        $searchText = $request->search;
        $products = Product::where('title', 'LIKE', "%$searchText%")->orWhere('category', 'LIKE', "$searchText")->orWhere('description', 'LIKE', "%$searchText%")->paginate(3);
        $products->appends(['search' => $searchText]);
        $comments = Comment::orderby('id', 'desc')->get();
        $replys = Reply::orderby('id', 'desc')->get();

        return view('home.userpage', compact('products', 'comments', 'replys'));
    }

    public function products()
    {
        $products = Product::paginate(10);
        $comments = Comment::orderby('id', 'desc')->get();
        $replys = Reply::orderby('id', 'desc')->get();
        return view('home.all_product', compact('products', 'comments', 'replys'));
    }

    public function product_search1(Request $request)
    {
        $searchText = $request->search;
        $products = Product::where('title', 'LIKE', "%$searchText%")->orWhere('category', 'LIKE', "$searchText")->orWhere('description', 'LIKE', "%$searchText%")->paginate(10);
        $products->appends(['search' => $searchText]);
        $comments = Comment::orderby('id', 'desc')->get();
        $replys = Reply::orderby('id', 'desc')->get();

        return view('home.all_product', compact('products', 'comments', 'replys'));
    }
}
