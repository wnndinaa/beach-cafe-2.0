<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Menu;


class MenuController extends Controller
{

    public function dashboardMenu() {
        $menuItems = Menu::all();

        return view('dashboard', [
            'menuItems' => $menuItems,
        ]);
    }

    public function index()
    {
        $menuItems = Menu::all();

        return view('manageMenu.menu', compact('menuItems'));
    }

    public function staffMenu()
    {
        $menuItems = Menu::all();

        return view('manageMenu.staffmenu', compact('menuItems'));
    }

    public function show(Menu $menu)
    {
        return view('manageMenu.viewmenu', compact('menu'));
    }

    public function update(Request $request, Menu $menu)
    {
        $request->validate([
            'name' => 'required',
            'price' => 'required|numeric',
            'status' => 'required|string',
            'category' => 'required',
        ]);

        $menu->update([
            'name' => $request->name,
            'price' => $request->price,
            'status' => $request->status,
            'category' => $request->category,
        ]);

        return redirect()->route('staff-menu')->with('success', 'Menu item updated successfully.');
    }

    public function addMenu()
    {
        return view('manageMenu.addmenu');
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'status' => 'required|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:10240',
            'category' => 'required|string|max:255',
        ]);

        $imageName = time() . '.' . $request->image->extension(); // You can customize this to include other parts of the name
        $request->image->move(public_path('asset/default-image'), $imageName); // Save the file in the "public/images" directory

        // Save the data to the database, including the image file name/path
        Menu::create([
            'name' => $request->name,
            'price' => $request->price,
            'status' => $request->status,
            'image_path' => $imageName, // Store file name in the database
            'category' => $request->category,
        ]);

        return redirect()->route('staff-menu')->with('success', 'Menu item added successfully.');
    }


    public function destroy(Menu $menu)
    {
        $menu->delete();

        return redirect()->route('staff-menu')->with('success', 'Menu item deleted successfully.');
    }
}