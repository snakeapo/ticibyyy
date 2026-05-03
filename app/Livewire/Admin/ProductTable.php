<?php

namespace App\Livewire\Admin;

use App\Models\Brands;
use App\Models\Categories;
use App\Models\Products;
use App\Models\Subcategories;
use Livewire\Component;
use Livewire\WithPagination;

class ProductTable extends Component
{
    use WithPagination;

    public string $search = '';
    public string $status = '';
    public string $category = '';
    public string $subCategory = '';
    public string $brand = '';
    public int $perPage = 15;

    protected $queryString = [
        'search' => ['except' => ''],
        'status' => ['except' => ''],
        'category' => ['except' => ''],
        'subCategory' => ['except' => ''],
        'brand' => ['except' => ''],
        'perPage' => ['except' => 15],
    ];

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function updatingStatus(): void
    {
        $this->resetPage();
    }

    public function updatingCategory(): void
    {
        $this->subCategory = '';
        $this->resetPage();
    }

    public function updatingSubCategory(): void
    {
        $this->resetPage();
    }

    public function updatingBrand(): void
    {
        $this->resetPage();
    }

    public function updatingPerPage(): void
    {
        $this->resetPage();
    }

    public function render()
    {
        $products = Products::query()
            ->with(['getCategory:id,category_title', 'getSubCategory:id,sub_title', 'getBrand:id,brand_title'])
            ->when($this->search !== '', function ($query) {
                $term = trim($this->search);
                $query->where(function ($subQuery) use ($term) {
                    $subQuery->where('title', 'like', "%{$term}%")
                        ->orWhere('product_token', 'like', "%{$term}%");
                });
            })
            ->when(strlen($this->status) > 0, function ($query) {
                $query->where('status', $this->status);
            })
            ->when($this->category !== '', fn ($query) => $query->where('category', (int) $this->category))
            ->when($this->subCategory !== '', fn ($query) => $query->where('sub_category', (int) $this->subCategory))
            ->when($this->brand !== '', fn ($query) => $query->where('brand', (int) $this->brand))
            ->latest('id')
            ->paginate($this->perPage);

        $categories = Categories::query()->orderBy('category_title')->get(['id', 'category_title']);
        $brands = Brands::query()->orderBy('brand_title')->get(['id', 'brand_title']);
        $subCategories = Subcategories::query()
            ->when($this->category !== '', fn ($query) => $query->where('top_category', (int) $this->category))
            ->orderBy('sub_title')
            ->get(['id', 'sub_title']);

        return view('livewire.admin.product-table', compact('products', 'categories', 'subCategories', 'brands'));
    }
}
