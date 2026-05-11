<?php

namespace Modules\Product\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Images;
use App\Models\Products;
use App\Models\Productvars;
use App\Models\Categories;
use App\Models\Brands;
use App\Models\Subcategories;
use App\Models\ProductRelatedProduct;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Modules\Product\Http\Requests\Backend\ProductCreateRequest;
use Modules\Product\Http\Requests\Backend\ProductUpdateRequest;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\Favories;
use App\Models\Pasts;
use App\Services\NotificationPreferenceMailer;

class SystemController extends Controller
{
    public function __construct(private NotificationPreferenceMailer $notificationPreferenceMailer)
    {
    }

    // Product List
    public function product_list()
    {
        return view('product::backend.items.product.list');
    }

    // Product insert
    public function product_insert()
    {
        return view('product::backend.items.product.insert');
    }

    // Product edit
    public function product_edit($id)
    {
        $data = Products::findOrFail($id);
        $variant = Productvars::where('product_id', $data->id)->get();
        $selectedSubcategoryPath = $this->getSelectedSubcategoryPath((int) $data->sub_category);

        return view('product::backend.items.product.edit', compact('data', 'variant', 'selectedSubcategoryPath'));
    }



    public function product_related($id)
    {
        $product = Products::query()
            ->with(['getCategory:id,category_title'])
            ->findOrFail($id);

        $search = request('search', '');
        $selectedSearch = request('selected_search', '');
        $relatedIds = ProductRelatedProduct::query()
            ->where('product_id', $product->id)
            ->pluck('related_product_id');

        $availableProducts = Products::query()
            ->where('id', '!=', $product->id)
            ->whereNotIn('id', $relatedIds)
            ->with(['getCategory:id,category_title', 'getSubCategory:id,sub_title,parent_id', 'getSubCategory.parent:id,sub_title', 'getBrand:id,brand_title'])
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($subQuery) use ($search) {
                    $subQuery->where('title', 'like', '%' . trim($search) . '%')
                        ->orWhere('product_token', 'like', '%' . trim($search) . '%');
                });
            })
            ->latest('id')
            ->paginate(15, ['*'], 'available_page')
            ->withQueryString();

        $selectedProducts = Products::query()
            ->whereIn('id', $relatedIds)
            ->with(['getCategory:id,category_title', 'getSubCategory:id,sub_title,parent_id', 'getSubCategory.parent:id,sub_title', 'getBrand:id,brand_title'])
            ->when($selectedSearch !== '', function ($query) use ($selectedSearch) {
                $query->where(function ($subQuery) use ($selectedSearch) {
                    $subQuery->where('title', 'like', '%' . trim($selectedSearch) . '%')
                        ->orWhere('product_token', 'like', '%' . trim($selectedSearch) . '%');
                });
            })
            ->latest('id')
            ->paginate(15, ['*'], 'selected_page')
            ->withQueryString();

        return view('product::backend.items.product.related-products', [
            'product' => $product,
            'availableProducts' => $availableProducts,
            'selectedProducts' => $selectedProducts,
            'relatedCount' => $relatedIds->count(),
        ]);
    }

    public function product_related_add(Request $request, $id)
    {
        $product = Products::query()->findOrFail($id);
        $relatedProductId = (int) $request->input('related_product_id');
        abort_if($relatedProductId === (int) $product->id, 422);

        $count = ProductRelatedProduct::query()->where('product_id', $product->id)->count();
        if ($count >= 5) {
            return back()->with('error', 'Bir ürün için en fazla 5 bağlı ürün seçebilirsiniz.');
        }

        ProductRelatedProduct::query()->firstOrCreate([
            'product_id' => $product->id,
            'related_product_id' => $relatedProductId,
        ]);
        ProductRelatedProduct::query()->firstOrCreate([
            'product_id' => $relatedProductId,
            'related_product_id' => $product->id,
        ]);

        return back()->with('success', 'Bağlı ürün eklendi.');
    }

    public function product_related_remove($id, $relatedId)
    {
        ProductRelatedProduct::query()->where('product_id', (int) $id)->where('related_product_id', (int) $relatedId)->delete();
        ProductRelatedProduct::query()->where('product_id', (int) $relatedId)->where('related_product_id', (int) $id)->delete();

        return back()->with('success', 'Bağlı ürün kaldırıldı.');
    }

    public function collections()
    {
        return view('product::backend.items.product.collections');
    }

    // Product create
    public function product_create(ProductCreateRequest $request)
    {
        $formData = $request->validated();
        $formData['status'] = $request->input('status');
        $token = date('His') * rand(99, 99999);
        $slug = Str::slug($request->title);

        File::ensureDirectoryExists(public_path('/upload/product'));

        $file = $request->file('image');
        $fileName = uniqid() . '.' . $file->getClientOriginalExtension();
        $file->move(public_path('/upload/product'), $fileName);

        if (!empty($request->sale_price) && (float) $request->price > 0) {
            $anaFiyat = (float) $request->price;
            $indirimliFiyat = (float) $request->sale_price;
            $sonucHesap = (($anaFiyat - $indirimliFiyat) / $anaFiyat) * 100;
            $farkBul = number_format($sonucHesap, 2, ',', '.');
        } else {
            $farkBul = '0';
        }

        DB::transaction(function () use ($request, $formData, $token, $slug, $fileName, $farkBul) {
            $formData['image'] = $fileName;
            $formData['difference'] = $farkBul;
            $formData['product_token'] = $token;
            $formData['slug'] = $slug;
            $product = Products::create($formData);

            if ($request->hasFile('images')) {
                $files = $request->file('images');
                foreach ($files as $file) {
                    $allowedMimeTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
                    if ($file->isValid() && in_array($file->getMimeType(), $allowedMimeTypes, true)) {
                        $imageName = time() . '_' . $file->getClientOriginalName();
                        $file->move(public_path('/upload/product'), $imageName);
                        Images::create([
                            'product_id' => $product->id,
                            'product_token' => $token,
                            'image' => $imageName,
                        ]);
                    } else {
                        throw ValidationException::withMessages([
                            'images' => 'Lütfen resim dosyası seçiniz.!',
                        ]);
                    }
                }
            }

            $variantNames = $request->input('variant_name', []);
            $variantTypes = $request->input('variant_type', []);
            $parentVariantTypes = $request->input('parent_variant_type', []);
            $parentVariantNames = $request->input('parent_variant_name', []);
            $variantPrices = $request->input('variant_price', []);
            $variantStocks = $request->input('variant_stock', []);
            $variantImages = $request->file('variant_image', []);
            $isColors = $request->input('is_color', []);

            foreach ($variantNames as $key => $variantName) {

                if (isset($variantPrices[$key]) && isset($variantStocks[$key])) {

                    $normalizedParentVariantName = collect(explode(',', (string) ($parentVariantNames[$key] ?? '')))
                        ->map(fn ($name) => trim($name))
                        ->filter()
                        ->implode(', ');

                    $variant = new Productvars();
                    $variant->product_id = $product->id;
                    $variant->product_token = $token;
                    $variant->variant_name = $variantName;
                    $variant->variant_type = $variantTypes[$key] ?? 'Genel';
                    $variant->parent_variant_type = $parentVariantTypes[$key] ?? null;
                    $variant->parent_variant_name = $normalizedParentVariantName ?: null;
                    $variant->variant_price = $variantPrices[$key];
                    $variant->variant_stock = $variantStocks[$key];

                    // checkbox
                    $variant->is_color = $isColors[$key] ?? null;

                    if (array_key_exists($key, $variantImages) && $variantImages[$key]) {
                        $imageName = time() . '_' . $variantImages[$key]->getClientOriginalName();
                        $variantImages[$key]->move(public_path('upload/product'), $imageName);
                        $variant->variant_image = $imageName;
                    }

                    $variant->save();
                }
            }
        });

        $product = Products::where('product_token', $token)->first();
        $this->notificationPreferenceMailer->sendToUsers(User::where('notify_new_products', true)->get(), 'Yeni ürün eklendi', $product?->title . ' ürünü eklendi.', $product ? route('product_detail', $product->slug) : null);

        return back()->with('success', 'Kayıt İşlemi Başarılı!');
    }

    public function product_quick_create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => ['required', 'string', 'max:255'],
            'price' => ['required', 'numeric', 'min:0'],
            'stock' => ['required', 'integer', 'min:0'],
            'category' => ['required', 'exists:categories,id'],
            'sub_category' => ['required', 'exists:subcategories,id'],
            'brand' => ['required', 'exists:brands,id'],
            'image' => ['required', 'image', 'mimes:jpg,jpeg,png,webp,svg', 'max:4096'],
            'has_return' => ['required', 'boolean'],
            'has_exchange' => ['required', 'boolean'],
            'whatsapp_order_enabled' => ['required', 'boolean'],
        ], [], [
            'title' => 'ürün adı',
            'price' => 'fiyat',
            'stock' => 'stok',
            'category' => 'kategori',
            'sub_category' => 'alt kategori',
            'brand' => 'marka',
            'image' => 'ürün resmi',
            'has_return' => 'iade durumu',
            'has_exchange' => 'değişim durumu',
            'whatsapp_order_enabled' => 'WhatsApp sipariş durumu',
        ]);
        $validated = $validator->validate();

        File::ensureDirectoryExists(public_path('/upload/product'));
        $file = $request->file('image');
        $fileName = uniqid() . '.' . $file->getClientOriginalExtension();
        $file->move(public_path('/upload/product'), $fileName);

        Products::create([
            'title' => $validated['title'],
            'slug' => Str::slug($validated['title']) . '-' . Str::lower(Str::random(5)),
            'description' => '',
            'category' => (int) $validated['category'],
            'sub_category' => (int) $validated['sub_category'],
            'brand' => (int) $validated['brand'],
            'price' => $validated['price'],
            'stock' => $validated['stock'],
            'image' => $fileName,
            'difference' => '0',
            'has_return' => (bool) $validated['has_return'],
            'has_exchange' => (bool) $validated['has_exchange'],
            'whatsapp_order_enabled' => (bool) $validated['whatsapp_order_enabled'],
            'product_token' => date('His') * rand(99, 99999),
            'status' => 1,
        ]);

        return back()->with('success', 'Hızlı ürün ekleme başarılı.');
    }

    public function product_bulk_import(Request $request)
    {
        $request->validate([
            'import_file' => ['required', 'file', 'max:10240'],
        ]);
        $extension = strtolower($request->file('import_file')->getClientOriginalExtension());
        $rows = [];
        if (in_array($extension, ['csv', 'xlsx', 'xls'], true)) {
            $content = file_get_contents($request->file('import_file')->getRealPath());
            $lines = preg_split('/\\r\\n|\\r|\\n/', (string) $content);
            $rows = array_map(fn ($line) => str_getcsv($line), array_filter($lines, fn ($line) => trim((string) $line) !== ''));
        } elseif ($extension === 'xml') {
            $xml = simplexml_load_file($request->file('import_file')->getRealPath(), 'SimpleXMLElement', LIBXML_NOCDATA);
            $rows = json_decode(json_encode($xml), true);
            $rows = isset($rows['product'][0]) ? $rows['product'] : [$rows['product'] ?? []];
        } else {
            throw ValidationException::withMessages(['import_file' => 'Desteklenen formatlar: csv/xls/xlsx/xml']);
        }

        if (count($rows) < 2 && $extension !== 'xml') {
            throw ValidationException::withMessages(['import_file' => 'Dosyada en az başlık ve 1 satır olmalı.']);
        }

        [$created, $skipped] = $this->importRows($rows, $extension === 'xml');
        return back()->with('success', "Toplu yükleme tamamlandı. Eklenen: {$created}, Atlanan: {$skipped}");
    }

    public function product_import_template(string $type)
    {
        if ($type === 'xml') {
            $xml = <<<XML
<?xml version="1.0" encoding="UTF-8"?>
<products>
  <product><urun_adi></urun_adi><stok></stok><fiyat></fiyat><kategori></kategori><ust_kategori></ust_kategori><alt_kategori></alt_kategori><en_alt_kategori></en_alt_kategori><resim></resim><marka></marka></product>
</products>
XML;
            return response($xml, 200, ['Content-Type' => 'application/xml', 'Content-Disposition' => 'attachment; filename="urun-import-ornek.xml"']);
        }
        $csv = "urun_adi,stok,fiyat,kategori,ust_kategori,alt_kategori,en_alt_kategori,resim,marka\n";
        if ($type === 'excel-dolu') {
            $csv .= "Örnek Ürün,10,199.90,Elektronik,Elektronik,Telefon,Aksesuar,https://site.com/urun.jpg,Örnek Marka\n";
        }
        return response($csv, 200, ['Content-Type' => 'text/csv', 'Content-Disposition' => "attachment; filename=\"urun-import-{$type}.csv\""]);
    }

    private function importRows(array $rows, bool $xml): array
    {
        $created = 0; $skipped = 0;
        $header = [];
        if (!$xml) {
            $header = array_map(fn ($h) => Str::lower(trim((string) $h)), $rows[0]);
            $rows = array_slice($rows, 1);
        }
        foreach ($rows as $row) {
            $data = $xml ? $row : array_combine($header, $row);
            $title = $this->pick($data, ['urun_adi', 'title', 'product_name', 'name']);
            $stock = (int) $this->pick($data, ['stok', 'stock', 'quantity'], 0);
            $price = (float) $this->pick($data, ['fiyat', 'price'], 0);
            $catName = $this->pick($data, ['kategori', 'category', 'ust_kategori']);
            $subName = $this->pick($data, ['en_alt_kategori', 'alt_kategori', 'sub_category']);
            $brandName = $this->pick($data, ['marka', 'brand']);
            if (!$title || $price < 0) { $skipped++; continue; }
            $category = Categories::firstOrCreate(['category_title' => (string) ($catName ?: 'Genel')], ['category_slug' => Str::slug((string) ($catName ?: 'Genel'))]);
            $sub = Subcategories::firstOrCreate(['sub_title' => (string) ($subName ?: 'Genel Alt'), 'top_category' => $category->id], ['sub_slug' => Str::slug((string) ($subName ?: 'Genel Alt')), 'parent_id' => null]);
            $brand = Brands::firstOrCreate(['brand_title' => (string) ($brandName ?: 'Genel')], ['brand_slug' => Str::slug((string) ($brandName ?: 'Genel'))]);
            Products::create([
                'title' => $title, 'slug' => Str::slug($title) . '-' . Str::lower(Str::random(5)), 'description' => '', 'category' => $category->id,
                'sub_category' => $sub->id, 'brand' => $brand->id, 'price' => $price, 'stock' => max($stock, 0), 'image' => 'default-product.webp', 'difference' => '0', 'product_token' => date('His') * rand(99, 99999), 'status' => 1,
            ]);
            $created++;
        }
        return [$created, $skipped];
    }

    private function pick(array $data, array $keys, mixed $default = null): mixed
    {
        foreach ($keys as $key) {
            if (isset($data[$key]) && trim((string) $data[$key]) !== '') {
                return $data[$key];
            }
        }
        return $default;
    }

    // Product update
    public function product_update(ProductUpdateRequest $request, $id)
    {
        $formData = $request->validated();
        $formData['status'] = $request->input('status');
        $product = Products::findOrFail($id);

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $fileName = uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('/upload/product'), $fileName);

            $oldFilePath = public_path('/upload/product/' . $product->image);
            if (file_exists($oldFilePath)) {
                unlink($oldFilePath);
            }

            $formData['image'] = $fileName;
        }

        if ($request->sale_price != null) {
            $anaFiyat = $request->price;
            $indirimliFiyat = $request->sale_price;
            $cikar = $anaFiyat - $indirimliFiyat;
            $bol = $cikar / $anaFiyat;
            $sonucHesap = $bol * 100;
            $farkBul = number_format($sonucHesap, 2, ',', '.');
        } else {
            $farkBul = '0';
        }

        $slug = Str::slug($request->title);
        $formData['difference'] = $farkBul;
        $formData['slug'] = $slug;

        $oldStock = (int) $product->stock;
        $oldSale = (float) ($product->sale_price ?? 0);
        $product->update($formData);

        $watcherIds = Favories::where('product_id', $product->id)->pluck('user_id')->merge(Pasts::where('product_id', $product->id)->pluck('user_id'))->unique();
        $watchers = User::whereIn('id', $watcherIds)->get();
        if ((int) $product->stock !== $oldStock) {
            $this->notificationPreferenceMailer->sendToUsers($watchers->where('notify_stock_updates', true), 'Stok güncellendi', $product->title . ' stok bilgisi güncellendi.', route('product_detail', $product->slug));
        }
        if (!empty($product->sale_price) && ((float) $product->sale_price < $oldSale || $oldSale === 0.0)) {
            $this->notificationPreferenceMailer->sendToUsers($watchers->where('notify_price_drops', true), 'İndirim var', $product->title . ' ürününde indirim var.', route('product_detail', $product->slug));
        }
        return back()->with('success', 'Düzenleme İşlemi Başarılı!');
    }

    // Category Select
    public function getSubCategories(Request $request)
    {

        $categoryId = (int) $request->input('category_id');
        $parentSubcategoryId = $request->filled('parent_subcategory_id')
            ? (int) $request->input('parent_subcategory_id')
            : null;

        $subCategoriesQuery = Subcategories::where('top_category', $categoryId);

        if ($parentSubcategoryId === null) {
            $subCategoriesQuery->where(function ($query) {
                $query->whereNull('parent_id')
                    ->orWhere('parent_id', 0);
            });
        } else {
            $subCategoriesQuery->where('parent_id', $parentSubcategoryId);
        }

        $subCategories = $subCategoriesQuery
            ->orderBy('sub_title')
            ->get(['id', 'sub_title']);

        return response()->json([
            'subCategories' => $subCategories,
        ]);
    }

    private function getSelectedSubcategoryPath(int $subcategoryId): array
    {
        if ($subcategoryId <= 0) {
            return [];
        }

        $path = [];
        $cursor = Subcategories::find($subcategoryId);

        while ($cursor) {
            $path[] = $cursor->id;
            $cursor = $cursor->parent_id ? Subcategories::find($cursor->parent_id) : null;
        }

        return array_reverse($path);
    }

    // Product delete
    public function product_delete($id)
    {
        $find = Products::findOrFail($id);

        DB::transaction(function () use ($find) {
            $variantImages = Productvars::where('product_id', $find->id)
                ->whereNotNull('variant_image')
                ->pluck('variant_image');
            foreach ($variantImages as $variantImage) {
                $variantImagePath = public_path('/upload/product/' . $variantImage);
                if (file_exists($variantImagePath)) {
                    unlink($variantImagePath);
                }
            }
            $imageFind = Images::where('product_id', $find->id)->get();
            foreach ($imageFind as $key) {
                $oldFilePath = public_path('/upload/product/' . $key->image);
                if (file_exists($oldFilePath)) {
                    unlink($oldFilePath);
                }
            }
            $oldFilePathProduct = public_path('/upload/product/' . $find->image);
            if (file_exists($oldFilePathProduct)) {
                unlink($oldFilePathProduct);
            }

            $find->delete();
        });

        return back()->with('success', 'Silme İşlemi Başarılı!');
    }
}
