@extends('layouts.customer')
@section('title', 'Dashboard')

@section('content')
    <div class="container mx-auto px-4 py-6">
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-800">Welcome, {{ auth()->user()->name }}</h1>
            <p class="text-gray-600 mt-1">This is your customer dashboard.</p>
        </div>
        <div class="mb-6">
            <form method="GET" action="{{ route('customer.dashboard') }}" class="flex">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search products..."
                    class="flex-1 border border-gray-300 rounded-l px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-r hover:bg-blue-700 transition">
                    Search
                </button>
            </form>
        </div>
        <p>Order Status: <span id="order-status"></span></p>
        @if ($products->count())
            <div class="flex flex-wrap justify-center gap-6">
                @foreach ($products as $product)
                    <div
                        class="bg-white shadow-md rounded-lg overflow-hidden hover:shadow-xl transform hover:-translate-y-1 transition duration-300 w-56 flex flex-col">
                        <div class="h-48 w-full bg-gray-100 flex items-center justify-center overflow-hidden relative">
                           
                                <img src="{{ $product->image_url }}" alt="Default Image"
                                    class="object-cover h-16 w-16 transition-transform duration-300 hover:scale-110">
                            @if ($product->stock <= 0)
                                <span class="absolute top-2 left-2 bg-red-500 text-white text-xs px-2 py-1 rounded">Out of
                                    Stock</span>
                            @endif
                        </div>

                        <div class="flex-1 flex flex-col items-center p-4">
                            <h3 class="font-semibold text-sm text-gray-700 mt-2  text-center"
                                title="{{ $product->name }}">
                                {{ $product->name }}
                            </h3>

                            <p class="text-blue-600 font-bold text-sm my-1">${{ $product->price }}</p>
                            <p class="text-gray-500 text-xs truncate text-center">Category: {{ $product->category }}</p>
                            <p class="text-gray-500 text-xs mt-1">Stock: {{ $product->stock }}</p>

                            <button class="add-to-cart bg-blue-600 text-black font-semibold px-4 py-2 mt-3 rounded shadow-md hover:bg-blue-700 transition-colors duration-300 w-full" data-id="{{ $product->id }}">Add to Cart</button>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-6 flex justify-center">
                {{ $products->links() }}
            </div>
        @else
            <p class="text-gray-600 text-center mt-12 text-lg">No products found.</p>
        @endif
    </div>
@endsection


@push('scripts')
<script src="https://js.pusher.com/8.3.0/pusher.min.js"></script>

    <script type="text/javascript">
        Pusher.logToConsole = true;

        var pusher = new Pusher("1b7143aceaf8740d3ce2", {
            cluster: "ap2",
            forceTLS: true
        });

        const orderId = 2; // dynamically pass this (from backend, or JS variable)

        var channel = pusher.subscribe(`order.status`);
        channel.bind("OrderStatusUpdated", function (data) {
            console.log("Order Status Update received:", data);

            let $status = $('#order-status');
            $status.text(`Your OrderID #${data.orderId} status has been ${data.status}`);

            // Add highlight class
            $status.addClass('highlight');

            // Remove highlight after 1s so it animates back
            setTimeout(() => {
                $status.removeClass('highlight');
            }, 1000);
        });
        // var channel = pusher.subscribe("order.1");

        // channel.bind("OrderStatusUpdated", function (data) {
        //     // alert('Your OrderID #' + data.orderId + 'status has been ' + data.status);
        //     $('#order-status').text('Your OrderID #' + data.orderId + 'status has been ' + data.status);
        //     console.log("Order Status Update received:", data);
        // });
        channel.bind_global((eventName, data) => {
            console.log(`Global Event: ${eventName}`, data);
        });
        
        $(document).ready(function() {

            $('.add-to-cart').on('click', function(e) {
                e.preventDefault();

                let button = $(this);
                let product_id = button.data('id');

                $.ajax({
                    url: '/customer/cart/add/' + product_id,
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.success) {
                            alert('Product added to cart. Total items: ' + response.cart_count);
                            $('#cart-count').text(response.cart_count);
                            button.text('Added');
                            button.prop('disabled', true);
                            button.addClass('bg-gray-400 cursor-not-allowed');
                        }
                    },
                    error: function(xhr) {
                        console.log(xhr);
                        alert('Something went wrong. Please try again.');
                    }
                });
            });

        });
    </script>
@endpush
