<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Notifications\MyFirstNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Notification;
use Illuminate\Support\Facades\Notification as FacadesNotification;
use Illuminate\Support\Facades\Storage;
use PDF;

class AdminController extends Controller
{
    public function view_category()
    {
        if (Auth::id()) {
            return view('admin.category', [
                'categories' => Category::all(),
            ]);
        } else {
            return redirect('login');
        }
    }

    public function add_category(Request $request)
    {
        if (Auth::id()) {
            $data = new Category();
            $data->category_name = $request->category;

            $data->save();
            return redirect()->back()->with('message', 'Kategori Berhasil Ditambahkan !');
        } else {
            return redirect('login');
        }
    }

    public function update_category_confirm(Request $request, $id)
    {
        if (Auth::id()) {
            $data = Category::find($id);
            $data->category_name = $request->category;

            $data->save();
            return redirect('/view_category')->with('message_edit', 'Kategori Berhasil Diedit !');
        } else {
            return redirect('login');
        }
    }

    public function delete_category($id)
    {
        if (Auth::id()) {
            $data = Category::find($id);

            $data->delete();
            return redirect()->back()->with('message_delete', 'Kategori Berhasil Dihapus !');
        } else {
            return redirect('login');
        }
    }

    public function view_product()
    {
        // $data = Category::all();
        // return view('admin.category',compact('data'));
        if (Auth::id()) {
            return view('admin.product', [
                'categories' => Category::all(),
            ]);
        } else {
            return redirect('login');
        }
    }

    public function show_product()
    {
        if (Auth::id()) {
            return view('admin.show_product', [
                'products' => Product::all(),
            ]);
        } else {
            return redirect('login');
        }
    }

    public function add_product(Request $request)
    {
        if (Auth::id()) {
            $product = new Product();
            $product->title = $request->title;
            $product->description = $request->description;
            $product->price = $request->price;
            $product->discount_price = $request->discount_price;
            $product->quantity = $request->quantity;
            $product->category = $request->category;

            $image = $request->image;
            $imagename = time() . '.' . $image->getClientOriginalExtension();
            $request->image->move('product', $imagename);
            $product->image = $imagename;

            $product->save();
            return redirect()->back()->with('message', 'Product Berhasil Ditambahkan !');
        } else {
            return redirect('login');
        }
    }

    public function update_product($id)
    {
        // $data = Category::all();
        // $product = Product::all();
        // return view('admin.category',compact('data','product'));
        if (Auth::id()) {
            return view('admin.update_product', [
                'categories' => Category::all(),
                'product' => Product::find($id),
            ]);
        } else {
            return redirect('login');
        }
    }

    public function update_product_confirm(Request $request, $id)
    {
        $product = Product::find($id);
        $product->title = $request->title;
        $product->description = $request->description;
        $product->price = $request->price;
        $product->discount_price = $request->discount_price;
        $product->quantity = $request->quantity;
        $product->category = $request->category;

        $image = $request->image;
        $imagename = time() . '.' . $image->getClientOriginalExtension();
        $request->image->move('product', $imagename);
        $product->image = $imagename;

        $product->save();
        return redirect('/show_product')->with('message_edit', 'Product Berhasil Diedit !');
    }

    public function delete_product($id)
    {
        if (Auth::id()) {
            $data = Product::find($id);
            // if ($data->image) {
            //     Storage::delete($data->image);
            // }

            $data->delete();
            return redirect()->back()->with('message_delete', 'Product Berhasil Dihapus !');
        } else {
            return redirect('login');
        }
    }

    public function order()
    {
        if (Auth::id()) {
            return view('admin.order', [
                'orders' => Order::all(),
            ]);
        } else {
            return redirect('login');
        }
    }

    public function delivered($id)
    {
        $order = Order::find($id);

        $order->delivery_status = "Delivered";
        $order->payment_status = "Paid";
        $order->save();
        return redirect()->back()->with('message_deliver', 'Status Delivered Berhasil Diubah !');
    }

    public function print_pdf($id)
    {
        $order = Order::find($id);
        $pdf = PDF::loadView('admin.pdf', compact('order'));
        return $pdf->download('order_details.pdf');
    }

    public function send_email($id)
    {
        $order = Order::find($id);
        return view('admin.email_info', compact('order'));
    }

    public function send_user_email(Request $request, $id)
    {
        $order = Order::find($id);
        $details = [
            'greeting' => $request->greeting,
            'firstline' => $request->firstline,
            'body' => $request->body,
            'button' => $request->button,
            'url' => $request->url,
            'lastline' => $request->lastline,
        ];

        Notification::send($order, new MyFirstNotification($details));
        return redirect()->back();
    }

    public function searchdata(Request $request)
    {
        $searchText = $request->search;
        $orders = Order::where('name', 'LIKE', "%$searchText%")->orWhere('product_title', 'LIKE', "%$searchText%")->orWhere('phone', 'LIKE', "%$searchText%")->orWhere('email', 'LIKE', "%$searchText%")->get();

        return view('admin.order', compact('orders'));
    }
}
