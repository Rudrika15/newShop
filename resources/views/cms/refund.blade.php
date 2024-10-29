@extends('visitor.layouts.app')
@section('content')
    <nav aria-label="breadcrumb" style="background-color: #1582d4;height: 100px; padding-top: 35px ;padding-left:40%">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-light">Home</a></li>
            <li class="breadcrumb-item " class="text-light" aria-current="page">Refund</li>
        </ol>
    </nav>

    <div class="container">
        <div class="row py-5">
            <div class="col-12">
                <h1>Refund Policy</h1>
                <p>
                    At MJ Dream, we strive to provide our customers with the highest quality products and a delightful
                    shopping experience. However, we understand that there may be times when you need to return an item.
                    Please review our refund policy below:
                </p>

                <h4>Eligibility for Returns</h4>
                <p>
                    Time Frame: You may return any item within 7 days of the delivery date.
                    Condition: Items must be unused, unworn, and in their original packaging with all tags attached. Items
                    that show signs of wear or are damaged cannot be accepted for return.
                    How to Initiate a Return
                    Contact Us: To initiate a return, please contact our customer service team at
                    msthetrendushaben@gmail.com or
                    +91 8866 232839. Include your order number and the reason for the return.
                    Return Authorization: Once your request is approved, we will provide you with a return authorization and
                    instructions for shipping the item back to us.
                </p>

                <h4>
                    Refund Process
                </h4>
                <p>
                    Processing Time: Once we receive the returned item and verify its condition, we will process your refund
                    within 7-10 business days.
                    Refund Method: Refunds will be issued to the original payment method used at the time of purchase.
                    Please note that it may take additional time for your bank to process the refund.
                </p>
                <h4>

                    Exceptions
                </h4>
                <p>
                    Final Sale Items: Certain items, such as clearance or sale items, may be marked as final sale and are
                    not eligible for return.
                    Exchanges: If you wish to exchange an item for a different size or color, please initiate a return for
                    the original item and place a new order for the desired product.
                    Shipping Costs
                    Return Shipping: Customers are responsible for return shipping costs unless the item is defective or
                    incorrect.
                    Original Shipping: Shipping fees for the original order are non-refundable.
                </p>

                <h4>

                    Contact Us
                </h4>
                <p>

                    If you have any questions or concerns regarding our refund policy, please don’t hesitate to reach out to
                    us at msthetrendushaben@gmail.com or +91 8866 232839. We’re here to help!
                    Thank you for shopping with MJ Dream!

                </p>
            </div>
        </div>

    </div>
@endsection