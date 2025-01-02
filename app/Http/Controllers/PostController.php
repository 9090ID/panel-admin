<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Category;
use Illuminate\Database\Capsule\Manager;
use Yajra\DataTables\Facades\DataTables; 
use Illuminate\Support\Str;
use Spatie\Image\Image;
use Spatie\Image\Enums\CropPosition;
use Spatie\Image\Image as SpatieImage;
use File;
class PostController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $posts = Post::with('categories')->get();
    
            return DataTables::of($posts)
                ->addIndexColumn()
                ->addColumn('categories', function ($post) {
                    // Gabungkan nama kategori dengan koma
                    return $post->categories->pluck('name')->join(', ');
                })
                ->addColumn('image', function ($post) {
            $imageUrl = $post->image 
            ? asset( $post->image) 
            : asset('images/default.jpg'); // Gambar default jika tidak ada
            return '<img src="' . $imageUrl . '" class="rounded" alt="Image" style="width: 50px; height: auto;">';
            })

                ->addColumn('action', function ($post) {
                    return '
                    <a href="'.route('posts.edit', $post->id).'" class="btn btn-sm btn-primary">Edit</a>
                    <button type="button" class="btn btn-sm btn-danger delete-post" data-id="' . $post->id . '">
                        <i class="fas fa-trash"></i> Delete
                    </button>';
                })
                ->rawColumns(['action','image'])
                ->make(true);
        }
    
        return view('posts.index');
    }
    public function create()
    {
        $categories = Category::all();
        return view('posts.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'categories' => 'required|array',
            'categories.*' => 'exists:categories,id',
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);
    
        $image = $request->file('image');
        // Generate nama file unik
        $imageName = Str::random(40) . '.webp';
        // Tentukan direktori penyimpanan
        $imageDirectory = public_path('fotoartikel');
        // Pastikan direktori ada
        if (!file_exists($imageDirectory)) {
            mkdir($imageDirectory, 0755, true);
        }

        // Path lengkap untuk penyimpanan file
        $fullPath = $imageDirectory . '/' . $imageName;
        // Manipulasi gambar dan simpan sebagai format WEBP
        SpatieImage::load($image->getPathname())
            ->format('webp') // Ubah format ke WEBP
            ->save($fullPath); // Simpan gambar

        // Simpan path relatif untuk digunakan di database
        $imagePath = 'fotoartikel/' . $imageName;
    
        // Simpan Berita
        $news = Post::create([
            'title' => $request->title,
            'content' => $request->content,
            'image' => $imagePath,
            'slug' => Str::slug($request->title),
            'author' => $request->author ?? 'Admin',
        ]);
    
        $news->categories()->attach($request->categories);
      
        return redirect()->route('posts.index')->with('success', 'Berita berhasil ditambahkan.');
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
        $categories = Category::all();
        $post = Post::findOrFail($id);
        return view('posts.edit', compact('post','categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Ambil data post berdasarkan ID
    $post = Post::findOrFail($id);

    // Validasi input
    $request->validate([
        'title' => 'required|string|max:255',
        'content' => 'required|string',
        'categories' => 'required|array',
        'categories.*' => 'exists:categories,id',
        'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048', // Gambar opsional
    ]);

    // Jika ada gambar baru yang diunggah
    if ($request->hasFile('image')) {
        $image = $request->file('image');
        // Generate nama file unik
        $imageName = Str::random(40) . '.webp';
        // Tentukan direktori penyimpanan
        $imageDirectory = public_path('fotoartikel');
        // Pastikan direktori ada
        if (!file_exists($imageDirectory)) {
            mkdir($imageDirectory, 0755, true);
        }

        // Path lengkap untuk penyimpanan file
        $fullPath = $imageDirectory . '/' . $imageName;

        // Manipulasi gambar dan simpan sebagai format WEBP
        SpatieImage::load($image->getPathname())
            ->format('webp') // Ubah format ke WEBP
            ->save($fullPath); // Simpan gambar

        // Hapus gambar lama jika ada
        if ($post->image && file_exists(public_path($post->image))) {
            unlink(public_path($post->image));
        }

        // Simpan path relatif untuk digunakan di database
        $imagePath = 'fotoartikel/' . $imageName;
    } else {
        // Jika tidak ada gambar baru, gunakan gambar lama
        $imagePath = $post->image;
    }

    // Perbarui data post
    $post->update([
        'title' => $request->title,
        'content' => $request->content,
        'image' => $imagePath,
        'slug' => Str::slug($request->title),
        'author' => $request->author ?? 'Admin',
    ]);

    // Perbarui relasi kategori
    $post->categories()->sync($request->categories);

    return response()->json([
        'message' => 'Data berhasil diperbarui!',
        'redirect_url' => route('posts.index') // Mengarahkan ke halaman index
    ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        try {
            // Hapus file gambar jika ada
            if ($post->image && File::exists(public_path($post->image))) {
                File::delete(public_path($post->image));
            }
    
            // Hapus data dari database
            $post->delete();
    
            return response()->json([
                'success' => true,
                'message' => 'Post berhasil dihapus!',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage(),
            ], 500);
        }
    }
}
