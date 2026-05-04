<?php

namespace App\Livewire\Admin;

use App\Models\Products;
use App\Models\ProductRelatedProduct;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class ProductRelatedManager extends Component
{
    use WithPagination;

    public Products $product;
    public string $search = '';
    public string $selectedSearch = '';
    public int $perPage = 10;
    public int $selectedPerPage = 10;

    protected $queryString = [
        'search' => ['except' => ''],
        'selectedSearch' => ['except' => ''],
        'perPage' => ['except' => 10],
        'selectedPerPage' => ['except' => 10],
    ];

    public function mount(int $productId): void
    {
        $this->product = Products::query()
            ->with([
                'getCategory:id,category_title',
                'getSubCategory:id,sub_title,parent_id,top_category',
                'getSubCategory.parent:id,sub_title,parent_id,top_category',
                'getBrand:id,brand_title',
            ])
            ->findOrFail($productId);
    }

    public function updatingSearch(): void
    {
        $this->resetPage('availablePage');
    }

    public function updatingSelectedSearch(): void
    {
        $this->resetPage('selectedPage');
    }

    public function updatingPerPage(): void
    {
        $this->resetPage('availablePage');
    }

    public function updatingSelectedPerPage(): void
    {
        $this->resetPage('selectedPage');
    }

    public function addRelatedProduct(int $relatedProductId): void
    {
        if ($relatedProductId === (int) $this->product->id) {
            return;
        }

        $selectedIds = ProductRelatedProduct::query()
            ->where('product_id', $this->product->id)
            ->pluck('related_product_id');
        if ($selectedIds->count() >= 5) {
            session()->flash('error', 'Bir ürün için en fazla 5 önerilen ürün seçebilirsiniz.');
            return;
        }

        DB::transaction(function () use ($relatedProductId) {
            ProductRelatedProduct::query()->firstOrCreate([
                'product_id' => $this->product->id,
                'related_product_id' => $relatedProductId,
            ]);

            ProductRelatedProduct::query()->firstOrCreate([
                'product_id' => $relatedProductId,
                'related_product_id' => $this->product->id,
            ]);
        });

        session()->flash('success', 'Ürün bağlantısı eklendi.');
        $this->resetPage('availablePage');
    }

    public function removeRelatedProduct(int $relatedProductId): void
    {
        DB::transaction(function () use ($relatedProductId) {
            ProductRelatedProduct::query()
                ->where('product_id', $this->product->id)
                ->where('related_product_id', $relatedProductId)
                ->delete();

            ProductRelatedProduct::query()
                ->where('product_id', $relatedProductId)
                ->where('related_product_id', $this->product->id)
                ->delete();
        });

        session()->flash('success', 'Ürün bağlantısı kaldırıldı.');
        $this->resetPage('selectedPage');
    }

    public function render()
    {
        $relatedIds = ProductRelatedProduct::query()
            ->where('product_id', $this->product->id)
            ->pluck('related_product_id');

        $availableProducts = Products::query()
            ->where('id', '!=', $this->product->id)
            ->whereNotIn('id', $relatedIds)
            ->with([
                'getCategory:id,category_title',
                'getSubCategory:id,sub_title,parent_id,top_category',
                'getSubCategory.parent:id,sub_title,parent_id,top_category',
                'getBrand:id,brand_title',
            ])
            ->when($this->search !== '', function ($query) {
                $term = trim($this->search);
                $query->where(function ($subQuery) use ($term) {
                    $subQuery->where('title', 'like', "%{$term}%")
                        ->orWhere('product_token', 'like', "%{$term}%");
                });
            })
            ->latest('id')
            ->paginate($this->perPage, ['*'], 'availablePage');

        $selectedProducts = Products::query()
            ->whereIn('id', $relatedIds)
            ->with([
                'getCategory:id,category_title',
                'getSubCategory:id,sub_title,parent_id,top_category',
                'getSubCategory.parent:id,sub_title,parent_id,top_category',
                'getBrand:id,brand_title',
            ])
            ->when($this->selectedSearch !== '', function ($query) {
                $term = trim($this->selectedSearch);
                $query->where(function ($subQuery) use ($term) {
                    $subQuery->where('title', 'like', "%{$term}%")
                        ->orWhere('product_token', 'like', "%{$term}%");
                });
            })
            ->latest('id')
            ->paginate($this->selectedPerPage, ['*'], 'selectedPage');

        return view('livewire.admin.product-related-manager', compact('availableProducts', 'selectedProducts', 'relatedIds'));
    }
}
