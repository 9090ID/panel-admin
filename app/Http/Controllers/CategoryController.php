<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

use Yajra\DataTables\Facades\DataTables; 
class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $categories = Category::query();
    
            return DataTables::of($categories)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    // $editUrl = route('categories.edit', $row->id);
                    $deleteUrl = route('categories.destroy', $row->id);

                    return '
                      <button type="button" class="btn btn-sm btn-info edit-category" data-id="' . $row->id . '" 
                        data-name="' . $row->name . '"><i class="fas fa-edit"></i> Edit </button>
                            <button type="button" class="btn btn-sm btn-danger delete-btn" data-id="' . $row->id . '"><i class="fas fa-trash"></i> Delete</button>';
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    
        return view('categories.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name',
        ]);
    
        Category::create($request->all());
    
        return redirect()->route('categories.index')->with('success', 'Category created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
    //    show
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $category = Category::findOrFail($id);
        return view('categories.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
{
    $request->validate([
        'name' => 'required|string|max:255',
    ]);

    $category = Category::findOrFail($id);
    $category->update([
        'name' => $request->name,
    ]);

    return response()->json(['success' => 'Kategori berhasil diperbarui.']);
}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();

        return response()->json(['success' => 'Category deleted successfully.']);
    }
}