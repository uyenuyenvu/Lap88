<?php

namespace App\Http\Controllers\Backend;

use App\Exports\UsersExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Imports\UsersImport;
use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Models\Trademark;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $keyU = '';
        $this->authorize('viewAny', User::class);
        if ($request->has('q')) {
            $keyU = $request->get('q');
            $users = User::search($request);
        } else {
            $users = User::where('id', '>', 0);
        }

        if ($request->has('role')) {
            $users = $users->where('role', $request->get('role'));
        }
        $users = $users->orderBy('created_at', 'DESC')->paginate(20);
        return view('backend.users.index')->with([
            'users' => $users,
            'keyU'  => $keyU
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create', User::class);
        return view('backend.users.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUserRequest $request)
    {
        $this->authorize('create', User::class);
        $data = $request->except('_token');
        $data['password'] = bcrypt($request->get('password'));
        $user = User::create($data);

        if ($user) {
            return redirect()->route('backend.user.index')->with("success", 'Tạo mới thành công');
        }
        return redirect()->route('backend.user.index')->with("error", 'Tạo mới thất bại');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        $this->authorize('update', $user);
        $products   = Product::where('user_id', $user->id)->orderBy('created_at', 'DESC')->paginate(10);
        $trademarks = Trademark::where('user_id', $user->id)->orderBy('created_at', 'DESC')->get();
        $categories = Category::where('user_id', $user->id)->orderBy('created_at', 'DESC')->get();
        $parents    = Category::where('parent_id', 0)->get();
        $orders     = Order::where('user_id', $user->id)->orderBy('created_at', 'DESC')->get();

        return view('backend.users.show')->with([
            'user'          => $user,
            'products'      => $products,
            'trademarks'    => $trademarks,
            'categories'    => $categories,
            'parents'       => $parents,
            'orders'        => $orders
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        $this->authorize('update', $user);

        return view('backend.users.edit')->with([
            'user' => $user
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUserRequest $request, $id)
    {
        $data = $request->except('_token');
        $data['updated_at'] = Carbon::now();
        $user = User::find($id);
        $this->authorize('update', $user);

        if ($data['password'] == null) {
            $data['password'] = $user->password;
        } else {
            $data['password'] = bcrypt($request->get('password'));
        }
        $user->update($data);


        if ($user->id == Auth::user()->id && $data['password'] !== null && Auth::user()->role !== User::ROLE_MANAGE) {
            if (Auth::attempt(['email'=>$user->email,'password'=>$request->get('password')])) {
                $request->session()->regenerate();
                return redirect()->intended('/admin')->with("success", 'Thay đổi thành công');
            }
        } elseif ($user->id == Auth::user()->id && $data['password'] !== null && Auth::user()->role == User::ROLE_MANAGE){
            if (Auth::attempt(['email'=>$user->email,'password'=>$request->get('password')])) {
                $request->session()->regenerate();
                return redirect()->intended('/admin/user')->with("success", 'Thay đổi thành công');
            }
        }
        if ($user) {
            if (Auth::user()->role == User::ROLE_MANAGE) {
                return redirect()->route('backend.user.index')->with("success", 'Thay đổi thành công');
            }
            return back()->with("success", 'Thay đổi thành công');
        } else {
            if (Auth::user()->role == User::ROLE_MANAGE) {
                return redirect()->route('backend.user.index')->with("error", 'Thay đổi thất bại');
            }
            return back()->with("error", 'Thay đổi thất bại');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $this->authorize('delete', $user);
        $categories = Category::where('user_id', $user->id)->get();
        $user->updateAfterDelete($categories);
        $products = Product::where('user_id', $user->id)->get();
        $user->updateAfterDelete($products);
        $trademarks = Trademark::where('user_id', $user->id)->get();
        $user->updateAfterDelete($trademarks);

        $user->delete();

        if ($user) {
            return redirect()->route('backend.user.index')->with("success", 'Xóa thành công');
        }
        return redirect()->route('backend.user.index')->with("error", 'Xóa thất bại');
    }

    public function export()
    {
        return Excel::download(new UsersExport(), 'users.xlsx');
    }

    public function import(){
        Excel::import(new UsersImport,request()->file('file'));

        return back();
    }
    
}
