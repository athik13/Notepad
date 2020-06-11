<?php

use Illuminate\Http\Request;
use App\Products;
use App\ProductPhotos;
use App\Type;
use App\SubType;
use App\Order;
use App\OrderProduct;
use App\Mail\OrderConfirmed;
use Illuminate\Support\Facades\Mail;
use App\Settings;
use App\SmsGroup;
use App\SmsGroupNumbers;
use Mohamedathik\PhotoUpload\Upload;
use App\IndividualGroupMessage;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    $products = Products::take(6)->get();
    $types = Type::take(3)->get();

    $topPicks = Products::where('toppicks', '1')->get();
    $featuredProducts = Products::where('featured_product', '1')->get();

    $bannerURL = Settings::where('setting', 'bannerURL')->first();
    $bannerText1 = Settings::where('setting', 'bannerText1')->first();
    $bannerText2 = Settings::where('setting', 'bannerText2')->first();
    $bannerButtonText = Settings::where('setting', 'bannerButtonText')->first();
    $bannerButtonURL = Settings::where('setting', 'bannerButtonURL')->first();

    return view('welcome',compact('types', 'products', 'topPicks', 'featuredProducts', 'bannerURL', 'bannerText1', 'bannerText2', 'bannerButtonText', 'bannerButtonURL'));
});


Route::get('/contact-us', function () {
    $types = Type::all();
    return view('contact', compact('types'));
});

Route::post('/contact-us', 'ContactController@store');

Route::middleware(['auth'])->group(function () {
    Route::get('/admin', function () {
        if (auth()->user()->email == 'marketing@newedition.mv') {
            return redirect('admin/sms');
        }

        $bannerURL = Settings::where('setting', 'bannerURL')->first();
        if ($bannerURL == null) {
            $bannerURL = new Settings;
            $bannerURL->setting = 'bannerURL';
            $bannerURL->value = '/images/yaniu.png';
            $bannerURL->save();
        }

        $bannerText1 = Settings::where('setting', 'bannerText1')->first();
        if ($bannerText1 == null) {
            $bannerText1 = new Settings;
            $bannerText1->setting = 'bannerText1';
            $bannerText1->value = 'MATTEVER LIPINK - 13 DATING RED';
            $bannerText1->save();
        }

        $bannerText2 = Settings::where('setting', 'bannerText2')->first();
        if ($bannerText2 == null) {
            $bannerText2 = new Settings;
            $bannerText2->setting = 'bannerText2';
            $bannerText2->value = 'Eat, drink and even 😙, without refreshing your lipstick for 8 hours 💄';
            $bannerText2->save();
        }

        $bannerButtonText = Settings::where('setting', 'bannerButtonText')->first();
        if ($bannerButtonText == null) {
            $bannerButtonText = new Settings;
            $bannerButtonText->setting = 'bannerButtonText';
            $bannerButtonText->value = 'View More';
            $bannerButtonText->save();
        }

        $bannerButtonURL = Settings::where('setting', 'bannerButtonURL')->first();
        if ($bannerButtonURL == null) {
            $bannerButtonURL = new Settings;
            $bannerButtonURL->setting = 'bannerButtonURL';
            $bannerButtonURL->value = '#';
            $bannerButtonURL->save();
        }

        return view('admin.admin.home', compact('bannerURL', 'bannerText1', 'bannerText2', 'bannerButtonText', 'bannerButtonURL'));
    });

    Route::post('/admin/home-banner', function (Request $request) {
        $bannerURL = Settings::where('setting', 'bannerURL')->first();

        $file = $request->image;
        $file_name = $file->getClientOriginalName();
        $location = "/images";
        $url_original = Upload::upload_original($file, $file_name, $location);

        $bannerURL->value = '/storage'.$url_original;
        $bannerURL->save();

        return redirect()->back()->with('alert-success', 'Successfully uploaded Images');
    });

    Route::post('/admin/banner-text-update', function (Request $request) {
        $bannerText1 = Settings::where('setting', 'bannerText1')->first();
        $bannerText1->value = $request->bannerText1;
        $bannerText1->save();

        $bannerText2 = Settings::where('setting', 'bannerText2')->first();
        $bannerText2->value = $request->bannerText2;
        $bannerText2->save();

        $bannerButtonText = Settings::where('setting', 'bannerButtonText')->first();
        $bannerButtonText->value = $request->bannerButtonText;
        $bannerButtonText->save();

        $bannerButtonURL = Settings::where('setting', 'bannerButtonURL')->first();
        $bannerButtonURL->value = $request->bannerButtonURL;
        $bannerButtonURL->save();

        return redirect()->back()->with('alert-success', 'Successfully updated text');
    });

    Route::get('/admin/type', 'TypeController@index');
    Route::post('/admin/type', 'TypeController@store');
    Route::get('/admin/type/edit/{type}', 'TypeController@edit');
    Route::post('/admin/type/edit/{type}', 'TypeController@update');

    Route::get('/admin/sub-type', 'SubTypeController@index');
    Route::post('/admin/sub-type', 'SubTypeController@store');

    Route::get('/admin/product', 'ProductsController@index');
    Route::post('/admin/product', 'ProductsController@store');

    Route::get('/admin/product/{product}/images', 'ProductsController@showImages');
    Route::post('/admin/product/{product}/images/upload-images', 'ProductsController@storeImages');
    Route::post('/admin/product/{product}/images/update-color', 'ProductsController@updateImageColor');

    Route::prefix('admin')->group(function () {
        Route::prefix('sms')->group(function () {
            Route::get('/', 'SmsController@index');
            Route::post('/', 'SmsController@send');

            Route::get('/group', 'SmsController@group');
            Route::post('/group', 'SmsController@groupSend');

            Route::get('/sent', 'SmsController@sent');
            Route::get('/sent/group/{id}', function ($id) {
                if (request()->has('filter')) {
                    if (request('filter') == 'error') {
                        $individual_messages = IndividualGroupMessage::where('group_message_id', $id)->where('error', '1')->paginate(20);
                        return view('sms.sent-detail', compact('individual_messages'));
                    }
                }

                $individual_messages = IndividualGroupMessage::where('group_message_id', $id)->paginate(20);
                return view('admin.sms.sent-detail', compact('individual_messages'));
            });

            Route::get('/sent/unsent-messages/{id}', 'SmsController@sendUnsendMessages');

            Route::get('/group/manage', function () {
                $smsGroups = SmsGroup::all();
                return view('admin.sms.manage.index', compact('smsGroups'));
            });

            Route::post('/group/manage', function (Request $request) {
                $smsGroup = new SmsGroup;
                $smsGroup->group_name = $request->groupName;
                $smsGroup->save();

                return redirect()->back()->with('alert-success', 'Successfully added a new SMS Group');
            });

            Route::get('/group/manage/{smsGroup}', function (SmsGroup $smsGroup) {
                $numbers = SmsGroupNumbers::where('sms_group_id', $smsGroup->id)->get();
                return view('admin.sms.manage.numbers', compact('smsGroup', 'numbers'));
            });

            Route::post('/group/manage/{smsGroup}', function (SmsGroup $smsGroup, Request $request) {
                $number = new SmsGroupNumbers;
                $number->sms_group_id = $smsGroup->id;
                $number->name = $request->name;
                $number->phone_number = $request->phoneNumber;
                $number->save();

                return redirect()->back()->with('alert-success', 'Successfully added new Number');
            });

        });
    });

    Route::prefix('admin')->group(function () {
        Route::prefix('orders')->group(function () {
            Route::get('/', function () {
                $orders = Order::all();
                return view('admin.admin.orders', compact('orders'));
            });
        });
    });
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('collections/{type}', function (Type $type, Request $request) {
    $types = Type::all();
    $subTypes = SubType::where('type_id', $type->id)->pluck('id')->toArray();

    if (\Request::has('sort')) {
        if ($request->sort == 'a-to-z') {
            $products = Products::whereIn('sub_type_id', $subTypes)->orderBy('name')->get();
        }

        if ($request->sort == 'z-to-a') {
            $products = Products::whereIn('sub_type_id', $subTypes)->orderByDesc('name')->get();
        }

        if ($request->sort == 'p-l-to-h') {
            $products = Products::whereIn('sub_type_id', $subTypes)->orderBy('retail_price')->get();
        }

        if ($request->sort == 'p-h-to-l') {
            $products = Products::whereIn('sub_type_id', $subTypes)->orderByDesc('retail_price')->get();
        }
    } else {
        $products = Products::whereIn('sub_type_id', $subTypes)->get();
    }

    return view('product.all', compact('types', 'products'));
});
Route::get('collections/{type}/{subType}', function (Type $type, SubType $subType, Request $request) {
    $types = Type::all();

    if (\Request::has('sort')) {
        if ($request->sort == 'a-to-z') {
            $products = Products::where('sub_type_id', $subType->id)->orderBy('name')->get();
        }

        if ($request->sort == 'z-to-a') {
            $products = Products::where('sub_type_id', $subType->id)->orderByDesc('name')->get();
        }

        if ($request->sort == 'p-l-to-h') {
            $products = Products::where('sub_type_id', $subType->id)->orderBy('retail_price')->get();
        }

        if ($request->sort == 'p-h-to-l') {
            $products = Products::where('sub_type_id', $subType->id)->orderByDesc('retail_price')->get();
        }
    } else {
        $products = Products::where('sub_type_id', $subType->id)->get();
    }

    // return $products;

    return view('product.all', compact('types', 'products'));
});



Route::get('collections/{type}/{subType}/{product}', function (Type $type, SubType $subType, Products $product) {
    $types = Type::all();
    return view('product.single', compact('types', 'product'));
});

Route::post('/add-to-cart', function(Request $request) {
    $product = Products::where('id', $request->product_id)->with(['images'])->first();
    // return $product;

    if ($request->has('color')) {
        $photo = ProductPhotos::where('product_id', $request->product_id)->where('color', $request->color)->first();

        \Cart::session(session()->getId())->add(array(
            'id' => $product->id . $photo->id . '0001',
            'name' => $product->name,
            'price' => $product->retail_price,
            'quantity' => $request->qty,
            'attributes' => array(
                'color' => $request->color,
                'colorName' => $request->colorName
            ),
            'associatedModel' => $product,
            'associatedModelWith' => ['images']
        ));
    } else {
        \Cart::session(session()->getId())->add(array(
            'id' => $product->id . '0001',
            'name' => $product->name,
            'price' => $product->retail_price,
            'quantity' => $request->qty,
            'attributes' => array(),
            'associatedModel' => $product,
            'associatedModelWith' => ['images']
        ));
    }

    return response()->json([
        'message' => 'Item added to cart successfully'
    ]);;
});

Route::get('cart', function() {
    $condition = new \Darryldecode\Cart\CartCondition(array(
        'name' => 'GST 6%',
        'type' => 'tax',
        'target' => 'total', // this condition will be applied to cart's subtotal when getSubTotal() is called.
        'value' => '6%',
        'attributes' => array( // attributes field is optional
            'description' => 'Goods and Services Tax'
        )
    ));

    \Cart::session(session()->getId())->condition($condition);

    $types = Type::all();
    $items = \Cart::session(session()->getId())->getContent();

    $sub_total = \Cart::session(session()->getId())->getSubTotal();
    $total = \Cart::session(session()->getId())->getTotal();

    $cartConditions = \Cart::getConditions();

    return view('cart', compact('types', 'items', 'sub_total', 'total', 'cartConditions'));
});

Route::get('remove-cart-item/{id}', function($id) {
    \Cart::session(session()->getId())->remove($id);
    return redirect()->back();
});

Route::get('cart-items', function() {
    $items = \Cart::session(session()->getId())->getContent();
    return $items;
});

Route::get('checkout', function() {
    $types = Type::all();
    $items = \Cart::session(session()->getId())->getContent();

    $sub_total = \Cart::session(session()->getId())->getSubTotal();
    $total = \Cart::session(session()->getId())->getTotal();

    $cartConditions = \Cart::getConditions();

    return view('checkout', compact('types', 'items', 'sub_total', 'total', 'cartConditions'));
});

Route::post('checkout', function(Request $request) {
    $types = Type::all();
    $items = \Cart::session(session()->getId())->getContent();

    $sub_total = \Cart::session(session()->getId())->getSubTotal();
    $total = \Cart::session(session()->getId())->getTotal();

    $order = new Order;
    $order->user_id = (auth()->user() !== null ? auth()->user()->id : '0');
    $order->first_name = $request->first_name;
    $order->last_name = $request->last_name;
    $order->company_name = $request->company_name;
    $order->address1 = $request->address1;
    $order->address2 = $request->address2;
    $order->island = $request->island;
    $order->zip = $request->zip;
    $order->email = $request->email;
    $order->phone = $request->phone;
    $order->ordernotes = $request->ordernotes;

    $order->payment_status = '1';
    $order->payment_method = 'BML';

    $order->tax = '0';
    $order->discount = '0';
    $order->subtotal = $sub_total;
    $order->total = $total;

    $order->save();

    foreach ($items as $item) {
        $orderProduct = new OrderProduct;
        $orderProduct->order_id = $order->id;
        $orderProduct->product_id = $item->associatedModel->id;
        $orderProduct->price = $item->price;
        $orderProduct->qty = $item->quantity;
        $orderProduct->total = $item->price * $item->quantity;
        $orderProduct->save();
    }

    Mail::to($request->email)->send(new OrderConfirmed($order));

    return view('thankYou', compact('types'));
});
