<?php

namespace App\Http\Controllers;
use App\Slide;
use App\Product;
use App\ProductType;
use App\Cart;
use Session;
use App\Customer;
use App\Bill;
use App\BillDetail;
use App\User;
use Hash;
use Auth;

use Illuminate\Http\Request;

class PageController extends Controller
{
    public function getIndex(){
        $slide = Slide::all();
        $new_product = Product::where('status', 1)->paginate(4);
        $sanpham_khuyenmai = Product::where('discount','<>',0)->paginate(4);

        $count_product_new = Product::where('status', 1)->count();
        $count_sanpham_khuyenmai = Product::where('discount','<>',0)->count();

        return view('page.trangchu',compact('slide','new_product','sanpham_khuyenmai', 
            'count_product_new', 'count_sanpham_khuyenmai'));
    }

    public function getLoaiSp($type){
        $sp_theoloai = Product::where('type_product_id',$type)->get();
        $sp_khac = Product::where('type_product_id','<>',$type)->paginate(3);
        $loai = ProductType::all();
        $loap_sp = ProductType::where('id',$type)->first();
    	return view('page.loai_sanpham',compact('sp_theoloai','sp_khac','loai','loap_sp'));
    }

    public function getChitiet(Request $req){
        $sanpham = Product::where('id',$req->id)->first();
        $sp_tuongtu = Product::where('type_product_id',$sanpham->type_product_id)->take(6)->get();
        $new_product = Product::where('status', 1)->get(); //dd($new_product);
    	return view('page.chitiet_sanpham',compact('sanpham','sp_tuongtu','new_product'));
    }

    public function getLienHe(){
    	return view('page.lienhe');
    }

    public function getGioiThieu(){
    	return view('page.gioithieu');
    }

    public function getAddtoCart(Request $req,$id){
        $product = Product::find($id);
        $oldCart = Session('cart')?Session::get('cart'):null;
        $cart = new Cart($oldCart);
        $cart->add($product, $id);
        $req->session()->put('cart',$cart);
        return redirect()->back();
    }

    public function getDelItemCart($id){
        $oldCart = Session::has('cart')?Session::get('cart'):null;
        $cart = new Cart($oldCart);
        $cart->removeItem($id);
        if(count($cart->items)>0){
            Session::put('cart',$cart);
        }
        else{
            Session::forget('cart');
        }
        return redirect()->back();
    }

    public function getCheckout(){
        return view('page.dat_hang');
    }

    public function postCheckout(Request $req){
        $cart = Session::get('cart');

        $customer = new Customer;
        $customer->name = $req->name;
        $customer->gender = $req->gender;
        $customer->email = $req->email;
        $customer->address = $req->address;
        $customer->phone_number = $req->phone;
        $customer->note = $req->notes;
        $customer->save();

        $bill = new Bill;
        $bill->id_customer = $customer->id;
        $bill->date_order = date('Y-m-d');
        $bill->total = $cart->totalPrice;
        $bill->payment = $req->payment_method;
        $bill->note = $req->notes;
        $bill->save();

        foreach ($cart->items as $key => $value) {
            $bill_detail = new BillDetail;
            $bill_detail->id_bill = $bill->id;
            $bill_detail->id_product = $key;
            $bill_detail->quantity = $value['qty'];
            $bill_detail->unit_price = ($value['price']/$value['qty']);
            $bill_detail->save();
        }
        Session::forget('cart');
        return redirect()->back()->with('thongbao','Đặt hàng thành công');

    }

    public function getLogin(){
        return view('page.dangnhap');
    }
    public function getSignin(){
        return view('page.dangki');
    }

    public function postSignin(Request $req){
        $this->validate($req,
            [
                'email'=>'required|email|unique:users,email',
                'password'=>'required|min:6|max:20',
                'fullname'=>'required',
                're_password'=>'required|same:password'
            ],
            [
                'email.required'=>'Vui lòng nhập email',
                'email.email'=>'Không đúng định dạng email',
                'email.unique'=>'Email đã có người sử dụng',
                'password.required'=>'Vui lòng nhập mật khẩu',
                're_password.same'=>'Mật khẩu không giống nhau',
                'password.min'=>'Mật khẩu ít nhất 6 kí tự'
            ]);
        $user = new User();
        $user->full_name = $req->fullname;
        $user->email = $req->email;
        $user->password = Hash::make($req->password);
        $user->phone = $req->phone;
        $user->address = $req->address;
        $user->save();
        return redirect()->back()->with('thanhcong','Tạo tài khoản thành công');
    }

    public function postLogin(Request $req){
        $this->validate($req,
            [
                'email'=>'required|email',
                'password'=>'required|min:6|max:20'
            ],
            [
                'email.required'=>'Vui lòng nhập email',
                'email.email'=>'Email không đúng định dạng',
                'password.required'=>'Vui lòng nhập mật khẩu',
                'password.min'=>'Mật khẩu ít nhất 6 kí tự',
                'password.max'=>'Mật khẩu không quá 20 kí tự'
            ]
        );
        $credentials = new User;
        $credentials->email = $req->email;
        //$em = $listStaff->email;
        $credentials->password = $req->password;
        /*$user = User::where([
                ['email','=',$req->email],
                ['status','=','1']
            ])->first();
*/
        
            if(!isset($_POST['btnAdminLogin'])){
                if ($credentials->email =='tairikkei2018@gmail.com' && $credentials->password == 'toilatoi123') {
                        return redirect()->back()->with(['flag'=>'success','message'=>'Đăng nhập thành công']);
                }
                else{
                     return redirect()->back()->with(['flag'=>'danger','message'=>'Đăng nhập không thành công']);
                }
            }
            else{
                return redirect()->back()->with(['flag'=>'danger','message'=>'Đăng nhập không thành công']);
            }
        
        
    }
    public function postLogout(){
        Auth::logout();
        return redirect()->route('trang-chu');
    }

    public function getSearch(Request $req){
        $product = Product::where('name','like','%'.$req->key.'%')->orWhere('unit_price',$req->key)->get();
        return view('page.search',compact('product')); // truyen du lieu ve co ten la product
    }

    
}
