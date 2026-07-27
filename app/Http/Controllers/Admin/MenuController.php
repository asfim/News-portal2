<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\MenuRequest;
use App\Models\Menu;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    /**
     * Display a listing of the menu links.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        $query = Menu::with('parent')->orderBy('sort_order', 'asc');

        if ($search) {
            $query->where('label', 'like', "%{$search}%");
        }

        $menus = $query->paginate(15)->withQueryString();

        return view('admin.menus.index', compact('menus'));
    }

    /**
     * Show the form for creating a new menu link.
     */
    public function create()
    {
        $parentMenus = Menu::whereNull('parent_id')
            ->orderBy('label', 'asc')
            ->get();

        return view('admin.menus.create', compact('parentMenus'));
    }

    /**
     * Store a newly created menu link in storage.
     */
    public function store(MenuRequest $request)
    {
        $data = $request->validated();
        $data['status'] = $request->has('status');

        Menu::create($data);

        return redirect()->route('admin.menus.index')
            ->with('success', 'Menu link node created successfully.');
    }

    /**
     * Show the form for editing the specified menu link.
     */
    public function edit(Menu $menu)
    {
        $parentMenus = Menu::whereNull('parent_id')
            ->where('id', '!=', $menu->id)
            ->orderBy('label', 'asc')
            ->get();

        return view('admin.menus.edit', compact('menu', 'parentMenus'));
    }

    /**
     * Update the specified menu link in storage.
     */
    public function update(MenuRequest $request, Menu $menu)
    {
        $data = $request->validated();
        $data['status'] = $request->has('status');

        $menu->update($data);

        return redirect()->route('admin.menus.index')
            ->with('success', 'Menu link node updated successfully.');
    }

    /**
     * Remove the specified menu link from storage.
     */
    public function destroy(Menu $menu)
    {
        Menu::where('parent_id', $menu->id)->update(['parent_id' => null]);
        $menu->delete();

        return redirect()->route('admin.menus.index')
            ->with('success', 'Menu link node deleted successfully.');
    }

    /**
     * Toggle status inline.
     */
    public function toggleStatus(Menu $menu)
    {
        $menu->status = !$menu->status;
        $menu->save();

        return response()->json([
            'success' => true,
            'status' => $menu->status,
            'message' => 'Menu link status updated.'
        ]);
    }
}
