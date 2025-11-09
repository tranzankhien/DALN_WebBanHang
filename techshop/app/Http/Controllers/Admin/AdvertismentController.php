<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Advertisment;

class AdvertismentController extends Controller
{
    public function index()
    {
        $adverts = Advertisment::orderBy('id_advert', 'desc')->get();
        return view('admin.advertisments.index', compact('adverts'));
    }

    public function create()
    {
        return view('admin.advertisments.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'link_url' => 'required|url',
        ]);

        Advertisment::create($data);
        return redirect()->route('admin.advertisments.index')->with('success', 'Quảng cáo đã được thêm.');
    }

    public function edit(Advertisment $advertisment)
    {
        return view('admin.advertisments.edit', compact('advertisment'));
    }

    public function update(Request $request, Advertisment $advertisment)
    {
        $data = $request->validate([
            'link_url' => 'required|url',
        ]);

        $advertisment->update($data);
        return redirect()->route('admin.advertisments.index')->with('success', 'Quảng cáo đã được cập nhật.');
    }

    public function destroy(Advertisment $advertisment)
    {
        $advertisment->delete();
        return redirect()->route('admin.advertisments.index')->with('success', 'Quảng cáo đã được xóa.');
    }

    public function show() // Hiển thị quảng cáo trên trang chủ
    {
        $ads = Advertisment::all();
        return view('home',compact('ads'));
    }
}
