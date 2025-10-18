<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'admin']);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (!Auth::user()->is_admin) {
            return redirect()->route('home')->with('error', 'Akses ditolak. Halaman ini hanya untuk admin.');
        }
        $products = Product::with(['category', 'photos'])->paginate(10);
        $totalProducts = Product::count();
        $totalCategories = Category::count();
        $categoriesAll = Category::all();
        $categories = Category::with('products')->get();
        return view('admin.admincategory', compact('products', 'categories', 'totalProducts', 'totalCategories', 'categoriesAll'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name'
        ], [
            'name.required' => 'Nama kategori harus diisi',
            'name.unique' => 'Nama kategori sudah digunakan',
            'name.max' => 'Nama kategori maksimal 255 karakter'
        ]);

        try {
            Category::create([
                'name' => $request->name
            ]);

            return redirect()->route('admin.managecategories.index')
                ->with('success', 'Kategori berhasil ditambahkan!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Gagal menambahkan kategori: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,' . $category->id
        ], [
            'name.required' => 'Nama kategori harus diisi',
            'name.unique' => 'Nama kategori sudah digunakan',
            'name.max' => 'Nama kategori maksimal 255 karakter'
        ]);

        try {
            $oldName = $category->name;
            $productCount = $category->products()->count();
            
            $category->update([
                'name' => $request->name
            ]);

            // Pesan sukses dengan informasi tambahan tentang produk yang terpengaruh
            $message = "Kategori berhasil diperbarui dari '{$oldName}' menjadi '{$request->name}'";
            if ($productCount > 0) {
                $message .= " dan {$productCount} produk ikut terupdate kategorinya.";
            } else {
                $message .= ".";
            }

            return redirect()->route('admin.managecategories.index')
                ->with('success', $message);
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Gagal memperbarui kategori: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        try {
            // Cek apakah kategori masih memiliki produk
            if ($category->products()->count() > 0) {
                return response()->json([
                    'success' => false,
                    'message' => 'Tidak dapat menghapus kategori yang masih memiliki produk. Pindahkan atau hapus produk terlebih dahulu.'
                ], 422);
            }

            $categoryName = $category->name;
            $category->delete();

            return response()->json([
                'success' => true,
                'message' => "Kategori '{$categoryName}' berhasil dihapus."
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus kategori: ' . $e->getMessage()
            ], 500);
        }
    }
}
