<?php

use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CategoryProduct;
use App\Http\Controllers\BrandProduct;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\CouponController;
use App\Http\Controllers\DeliveryController;
use App\Http\Controllers\PagesController;
use App\Http\Controllers\SliderController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;

//Frontend
Route::get('/trang-chu', [HomeController::class, 'showlayoutproduct']);
Route::get('/', [HomeController::class, 'showlayoutproduct']);
Route::post('/tim-kiem',[HomeController::class,'search']);
// tra ve tab san pham
Route::get('/san-pham', [HomeController::class, 'index']);
Route::post('/tim-kiem',[HomeController::class,'search']);

//Danh muc san pham index
Route::get('/danh-muc-san-pham/{category_id}',[CategoryProduct::class,'show_category_home']);
Route::get('/thuong-hieu-san-pham/{brand_id}',[BrandProduct::class,'show_brand_home']);
Route::get('/chi-tiet-san-pham/{product_id}',[ProductController::class,'details_product']);

//Backend
Route::get('/admin', [AdminController::class, 'index']);
Route::get('/dashboard', [AdminController::class, 'show_dashboard']);
Route::get('/logout', [AdminController::class, 'logout']);
Route::post('/admin-dashboard', [AdminController::class, 'dashboard']);

Route::get('/signup', [AdminController::class, 'signup'])->name('signup');
Route::post('/register', [AdminController::class, 'register'])->name('register');

//Category Product
Route::get('/add-category-product', [CategoryProduct::class, 'add_category_product']);
Route::get('/delete-category-product/{category_product_id}', [CategoryProduct::class, 'delete_category_product']);
Route::get('/edit-category-product/{category_product_id}', [CategoryProduct::class, 'edit_category_product']);
Route::get('/all-category-product', [CategoryProduct::class, 'all_category_product']);

Route::get('/unactive-category-product/{category_product_id}', [CategoryProduct::class, 'unactive_category_product']);
Route::get('/active-category-product/{category_product_id}', [CategoryProduct::class, 'active_category_product']);

Route::post('/save-category-product', [CategoryProduct::class, 'save_category_product']);
Route::post('/update-category-product/{category_product_id}', [CategoryProduct::class, 'update_category_product']);

//Brand Product
Route::get('/add-brand-product', [BrandProduct::class, 'add_brand_product']);
Route::get('/delete-brand-product/{brand_product_id}', [BrandProduct::class, 'delete_brand_product']);
Route::get('/edit-brand-product/{brand_product_id}', [BrandProduct::class, 'edit_brand_product']);
Route::get('/all-brand-product', [BrandProduct::class, 'all_brand_product']);

Route::get('/unactive-brand-product/{brand_product_id}', [BrandProduct::class, 'unactive_brand_product']);
Route::get('/active-brand-product/{brand_product_id}', [BrandProduct::class, 'active_brand_product']);

Route::post('/save-brand-product', [BrandProduct::class, 'save_brand_product']);
Route::post('/update-brand-product/{brand_product_id}', [BrandProduct::class, 'update_brand_product']);

//Product
Route::get('/add-product', [ProductController::class, 'add_product']);
Route::get('/delete-product/{product_id}', [ProductController::class, 'delete_product']);
Route::get('/edit-product/{product_id}', [ProductController::class, 'edit_product']);
Route::get('/all-product', [ProductController::class, 'all_product']);

Route::get('/unactive-product/{product_id}', [ProductController::class, 'unactive_product']);
Route::get('/active-product/{product_id}', [ProductController::class, 'active_product']);

Route::post('/save-product', [ProductController::class, 'save_product']);
Route::post('/update-product/{product_id}', [ProductController::class, 'update_product']);

//Cart
Route::post('/save-cart', [CartController::class, 'save_cart']);
Route::post('/update-cart-quantity', [CartController::class, 'update_cart_quantity']);
Route::post('/update-cart', [CartController::class, 'update_cart']);
Route::get('/show-cart', [CartController::class, 'show_cart']);
Route::get('/delete-to-cart/{rowID}', [CartController::class, 'delete_to_cart']);
Route::post('/add-cart-ajax',[CartController::class, 'add_cart_ajax']);
Route::get('/gio-hang',[CartController::class,'gio_hang']);
Route::get('/del-product/{session_id}', [CartController::class, 'del_product']);
Route::get('/del-all-product', [CartController::class, 'del_all_product']);

//Checkout
Route::get('/login-checkout', [CheckoutController::class, 'login_checkout']);
Route::get('/logout-checkout', [CheckoutController::class, 'logout_checkout']);
Route::post('login-customer',[CheckoutController::class,'login_customer']);
Route::post('/add-customer', [CheckoutController::class, 'add_customer']);
Route::post('/order-place', [CheckoutController::class, 'order_place']);
Route::get('/checkout', [CheckoutController::class, 'checkout']);
Route::get('/payment', [CheckoutController::class, 'payment']);

Route::post('/save-checkout-customer',[CheckoutController::class,'save_checkout_customer']); 
Route::post('/select-delivery-home', [CheckoutController::class, 'select_delivery_home']);
Route::post('/calculate-fee', [CheckoutController::class, 'calculate_fee']);
Route::get('/del-fee', [CheckoutController::class, 'del_fee']);
Route::post('/confirm-order', [CheckoutController::class, 'confirm_order']);

//Order
Route::get('/manage-order', [OrderController::class, 'manage_order']);
// Route::get('/manage-order', [CheckoutController::class, 'manage_order']);
Route::get('/view-order/{order_code}', [OrderController::class, 'view_order']);
Route::post('/update-order', [OrderController::class, 'update_order']);

//Send email
Route::get('send-mail', [OrderController::class,'send_mail']);

//Coupon
Route::post('/check-coupon', [CartController::class, 'check_coupon']);
Route::get('/insert-coupon', [CouponController::class, 'insert_coupon']);
Route::get('/list-coupon', [CouponController::class, 'list_coupon']);
Route::get('/delete-coupon/{coupon_id}', [CouponController::class, 'delete_coupon']);
Route::get('/unset-coupon', [CouponController::class, 'unset_coupon']);
Route::post('/insert-coupon-code', [CouponController::class, 'insert_coupon_code']);

//Delivery
Route::get('/delivery', [DeliveryController::class, 'delivery']);
Route::post('/select-delivery', [DeliveryController::class, 'select_delivery']);
Route::post('/insert-delivery', [DeliveryController::class, 'insert_delivery']);
Route::post('/select-feeship', [DeliveryController::class, 'select_feeship']);
Route::get('/update-delivery', [DeliveryController::class, 'update_delivery']);

//page
Route::get('/contact', [PagesController::class, 'show_contact']);
Route::get('/about', [PagesController::class, 'show_about']);
Route::get('/edit-aboutpage', [PagesController::class, 'edit_about']);
Route::post('/update-aboutpage', [PagesController::class, 'update_about']);
Route::get('/edit-contactpage', [PagesController::class, 'edit_contact']);
Route::post('/update-contactpage', [PagesController::class, 'update_contact']);

//userlayout
Route::get('/edit-user-info', [UserController::class, 'edit_user_info']);
Route::get('/edit-user-password', [UserController::class, 'edit_user_password']);
Route::post('/update-user-info', [UserController::class, 'update_user_info']);
Route::get('/load-user-info', [UserController::class, 'load_user_info']);
Route::post('/update-user-password', [UserController::class, 'update_user_password']);

Route::get('/users', [UserController::class, 'index']);
Route::get('/add-users', [UserController::class, 'add_users']);
Route::post('/store-users', [UserController::class, 'store_users']);
Route::post('/assign-roles', [UserController::class, 'assign_roles']);

//Slide banner
Route::get('/manage-banner',[SliderController::class,'manage_banner']);
Route::get('/add-slider',[SliderController::class,'add_slider']);
Route::post('/insert-slider',[SliderController::class,'insert_slider']);
Route::get('/unactive-slider/{slider_id}', [SliderController::class, 'unactive_slider']);
Route::get('/active-slider/{slider_id}', [SliderController::class, 'active_slider']);
Route::get('/delete-slider/{slider_id}', [SliderController::class, 'delete_slider']);

//Authentication roles
Route::post('/auth-register',[AuthController::class,'auth_register']);
Route::post('/login',[AuthController::class,'login']);
Route::get('/login-auth', [AuthController::class, 'login_auth']);
Route::get('/register-auth', [AuthController::class, 'register_auth']);
Route::get('/logout-auth', [AuthController::class, 'logout_auth']);

