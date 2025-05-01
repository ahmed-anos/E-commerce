<?php

return [

    'users' => [
        'label' => 'Users',
        'name'  =>'name',
        'email' =>'email',
        'created_at'=>'created_at',
        'password'=>' password',
        'email_verified'=>'email_verified_at',
        'user'=>'user'
    ],
'brand'=>[
        'label'=>'Brands',
        'title' =>'brands',
        'single_title'=>'brand',
        'name' =>'name',
        'slug' =>' slug',
        'image' =>'image' ,
        'active' =>'active  '
],
'category'=>[
        'label'=>'Categories',
        'title' =>'categories',
        'single_title'=>'category',
        'name' =>'name',
        'slug' =>' slug',
        'image' =>'image' ,
        'active' =>'active  '
],
'product'=>[
    'label'=>'products',
    'title' =>'products',
    'single_title'=>'product',
    'name' =>'name',
    'slug' =>' slug',
    'price' =>'price',
    'category'=>'category',
    'brand' =>'brand',
    'quantity' =>'quantity',
    'on_sale'=>'on_sale',
    'is_new'=>'new',
    'on_stock'=>'on_stock',
    'is_featured'=>'is_featured',
    'images' =>'images' ,
    'active' =>'active  ',
    'product_info'=>' product information ',
    'description'=>'description',
    'association'=>'association',
    'status'=>'status'

],
'order'=>[
    'label'=>'orders',
    'title'=>'orders',
    'single_title'=>'order',
    'customer'=>'customer',
    'payment_method'=>'payment method',
    'payment_status'=>' payment status',
    'status' =>'status ',
    'currency'=>'currency',
    'notes'=>'notes',
    'order_items'=>' order items',
    'order_info'=>' order information ',
    'product'=>'product',
    'quantity'=>'quantity',
    'unit_amount'=>'unit_amount ',
    'total_amount'=>'total_amount',
    'items'=>'items',
    'grand_total'=>'grand_total  ',
    'pending'=>'Pending Orders ',
    'processing'=>'Processing Orders  ',
    'shipped'=>' Shipped Orders ',
    'average'=>'Average Price ',
    'order_num'=>' Order number',
    'order_date'=>'Order Date',
    'view' =>'view order',
    'latest'=>'Latest Orders',

    'all'=>'All',
    'pending' =>'pending',
    'processing'=>'processing ',
    'shipped'=>'shipped  ',
    'delivered' =>'delivered ',
    'canceled'=>'canceled'
],
'address'=>[
    'title'=>'Address',
    'label'=>'Address',
    'f_name'=>'first name ',
    'l_name'=>' last name',
    'name'=>'full name ',
    'phone'=>'phone ',
    'city'=>'city',
    'state'=>'state',
    'zip_code'=>'zip code ',
    'street'=>'street'
],
'offer'=>[
    'label'=>'offers',
    'title'=>'offers',
    'single_title'=>'offer',
    'offer_name'=>'offer name ',
    'type'=>' offer type',
    'fixed'=>' fixed value  ',
    'percentage'=>'percentage value ',
    'applies_to'=>' categories ',
    'products'=>'products',
    'start_date'=>'start date',
    'end_date'=>'end date ',
    'appearance'=>'appearance in homepage  ',
    'offer_description'=>' offer description',
    'offer_discount'=>'discount value',
    'currency'=>'EGP'
]


];
