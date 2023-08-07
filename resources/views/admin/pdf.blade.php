<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>

<body>
    <h1>Order Details</h1>

    <h3>ID Order : {{ $order->id }}</h3>
    <h3>Customer ID :{{ $order->user_id }}</h3>
    <h3>Customer Name :{{ $order->name }}</h3>
    <h3>Customer Email :{{ $order->email }}</h3>
    <h3>Phone :{{ $order->phone }}</h3>
    <h3>Address :{{ $order->address }}</h3>

    <h3>Product ID :{{ $order->product_id }}</h3>
    <h3>Product Title :{{ $order->product_title }}</h3>
    <h3>Quantity : {{ $order->quantity }}</h3>
    <h3>Price : {{ $order->price }}</h3>
    <img height="250" width="450" src="product/{{ $order->image }}" alt="null">

    <h3>Payment Status : {{ $order->payment_status }}</h3>
    <h3>Delivery Status : {{ $order->delivery_status }}</h3>
</body>

</html>
