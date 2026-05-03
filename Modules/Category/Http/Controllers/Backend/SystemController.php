<?php

namespace Modules\Category\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Categories;
use App\Models\Subcategories;
use Modules\Category\Http\Requests\Backend\CategoryCreateRequest;
use Modules\Category\Http\Requests\Backend\CategoryUpdateRequest;
use Modules\Category\Http\Requests\Backend\SubcategoryCreateRequest;
use Modules\Category\Http\Requests\Backend\SubcategoryUpdateRequest;
use Illuminate\Support\Str;

class SystemController extends Controller
{
    // Product category
    public function category_list()
    {
        $data = Categories::paginate(10);
        return view('category::backend.items.top-category', compact('data'));
    }

    // Product category create
    public function category_create(CategoryCreateRequest $request)
    {
        $formData = $request->validated();

        if ($request->hasFile('category_image')) {
            $file = $request->file('category_image');
            $fileName = uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('/upload/category'), $fileName);
        } else {
            $fileName = 0;
        }

        $formData['category_slug'] = Str::slug($request->category_title);
        $formData['category_image'] = $fileName;

        Categories::create($formData);

        return back()->with('success', 'Kayıt İşlemi Başarılı');
    }
    public function category_edit($id)
    {
        $data = Categories::paginate(10);
        $find = Categories::findOrFail($id);


        return view('category::backend.items.top-edit', compact('find','data'));
    }
    // Product category update
    public function category_update(CategoryUpdateRequest $request, $id)
    {
        $formData = $request->validated();

        $category = Categories::findOrFail($id);

        if ($request->hasFile('category_image')) {
            $file = $request->file('category_image');
            $fileName = uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('/upload/category'), $fileName);

            $oldFilePath = public_path('/upload/category/' . $category->category_image);
            if (file_exists($oldFilePath)) {
                unlink($oldFilePath);
            }

            $formData['category_image'] = $fileName;
        }

        $formData['category_slug'] = Str::slug($request->category_title);

        $category->update($formData);

        return back()->with('success', 'Düzenleme İşlemi Başarılı!');
    }

    // Product category delete
    public function category_delete($id)
    {
        $find = Categories::findOrFail($id);

        $find->delete();

        return redirect()->route('category_list')->with('success','Kategori silindi');

    }

    // Product sub category
    public function subcategory_list()
    {
        $data = Subcategories::with(['getCategory', 'parent'])->paginate(10);
        $parentOptions = $this->buildParentOptions();

        return view('category::backend.items.sub-category', compact('data', 'parentOptions'));
    }

    // Product sub category create
    public function subcategory_create(SubcategoryCreateRequest $request)
    {
        $formData = $request->validated();
        [$topCategoryId, $parentId] = $this->resolveParentTarget($formData['parent_target']);

        $formData['sub_slug'] = Str::slug($request->sub_title);
        $formData['top_category'] = $topCategoryId;
        $formData['parent_id'] = $parentId;

        unset($formData['parent_target']);

        Subcategories::create($formData);

        return back()->with('success', 'Kayıt İşlemi Başarılı');
    }
    public function subcategory_edit($id)
    {
        $data = Subcategories::with(['getCategory', 'parent'])->paginate(10);
        $parentOptions = $this->buildParentOptions();
        $find = Subcategories::findOrFail($id);


        return view('category::backend.items.sub-edit', compact('find','data','parentOptions'));
    }
    // Product sub category update
    public function subcategory_update(SubcategoryUpdateRequest $request, $id)
    {
        $formData = $request->validated();
        $category = Subcategories::findOrFail($id);

        [$topCategoryId, $parentId] = $this->resolveParentTarget($formData['parent_target']);

        if ($parentId !== null && $parentId === $category->id) {
            return back()->withErrors(['parent_target' => 'Bir kategori kendi altına bağlanamaz.']);
        }

        if ($parentId !== null && $this->isDescendant($parentId, $category->id)) {
            return back()->withErrors(['parent_target' => 'Alt kategori kendi çocuklarının altına taşınamaz.']);
        }

        $formData['sub_slug'] = Str::slug($request->sub_title);
        $formData['top_category'] = $topCategoryId;
        $formData['parent_id'] = $parentId;

        unset($formData['parent_target']);

        $category->update($formData);

        return back()->with('success', 'Düzenleme İşlemi Başarılı!');
    }

    // Product sub category delete
    public function subcategory_delete($id)
    {
        $find = Subcategories::findOrFail($id);

        $find->delete();

        return redirect()->route('subcategory_list')->with('success','Kategori silindi');
    }

    private function resolveParentTarget(string $parentTarget): array
    {
        [$type, $id] = array_pad(explode(':', $parentTarget), 2, null);

        if ($type === 'category') {
            $category = Categories::findOrFail((int) $id);
            return [$category->id, null];
        }

        if ($type === 'subcategory') {
            $subCategory = Subcategories::findOrFail((int) $id);

            if ($this->getSubcategoryDepth($subCategory) >= 2) {
                abort(422, 'En fazla 3 seviye kategori oluşturabilirsiniz.');
            }

            return [$subCategory->top_category, $subCategory->id];
        }

        abort(422, 'Geçersiz üst kategori seçimi.');
    }

    private function buildParentOptions(): array
    {
        $categories = Categories::orderBy('category_title')->get();
        $subCategories = Subcategories::orderBy('sub_title')->get();

        $tree = [];
        foreach ($subCategories as $subCategory) {
            $tree[$subCategory->parent_id ?? 0][] = $subCategory;
        }

        $options = [];
        foreach ($categories as $category) {
            $options[] = [
                'value' => 'category:' . $category->id,
                'label' => $category->category_title,
            ];

            foreach ($this->flattenSubcategoryOptions($tree, null, $category->id, 1) as $option) {
                $options[] = $option;
            }
        }

        return $options;
    }

    private function flattenSubcategoryOptions(array $tree, ?int $parentId, int $topCategoryId, int $depth): array
    {
        $key = $parentId ?? 0;
        $options = [];

        foreach ($tree[$key] ?? [] as $subCategory) {
            if ((int) $subCategory->top_category !== $topCategoryId) {
                continue;
            }

            if ($depth < 2) {
                $options[] = [
                    'value' => 'subcategory:' . $subCategory->id,
                    'label' => str_repeat('— ', $depth) . $subCategory->sub_title,
                ];
            }

            $options = array_merge(
                $options,
                $this->flattenSubcategoryOptions($tree, $subCategory->id, $topCategoryId, $depth + 1)
            );
        }

        return $options;
    }


    private function getSubcategoryDepth(Subcategories $subcategory): int
    {
        $depth = 1;
        $cursor = $subcategory;

        while ($cursor->parent_id) {
            $depth++;
            $cursor = Subcategories::find($cursor->parent_id);

            if (! $cursor) {
                break;
            }
        }

        return $depth;
    }

    private function isDescendant(int $candidateChildId, int $currentId): bool
    {
        $cursor = Subcategories::find($candidateChildId);

        while ($cursor) {
            if ((int) $cursor->parent_id === $currentId) {
                return true;
            }

            $cursor = $cursor->parent_id ? Subcategories::find($cursor->parent_id) : null;
        }

        return false;
    }
}
