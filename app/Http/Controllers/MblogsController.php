<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;



use App\Models\Mblog;
use Illuminate\Support\Facades\Auth;



class MblogsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }


    //发表微博的功能
    public function store(Request $request)
    {
        $this->validate($request, [
            'content' => 'required|max:140'
        ]);

        Auth::user()->mblogs()->create([
            'content' => $request['content']
        ]);
        session()->flash('success', '发布成功！');
        return redirect()->back();
    }


    //删除微博的功能
    public function destroy(Mblog $mblog)
    {
        $this->authorize('destroy', $mblog);
        $mblog->delete();
        session()->flash('success', '微博已被成功删除！');
        return redirect()->back();
    }

}
