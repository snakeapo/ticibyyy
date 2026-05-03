<?php

namespace App\Livewire\Admin;

use App\Models\Collections;
use App\Models\Products;
use Livewire\Component;
use Livewire\WithPagination;

class CollectionManager extends Component
{
    use WithPagination;

    public ?int $selectedCollectionId = null;

    public string $title = '';
    public string $description = '';
    public bool $status = true;

    public string $collectionSearch = '';
    public string $productSearch = '';
    public string $selectedProductSearch = '';
    public string $categoryFilter = '';

    public int $collectionPerPage = 10;
    public int $productPerPage = 10;
    public int $selectedProductPerPage = 10;

    protected $queryString = [
        'collectionSearch' => ['except' => ''],
        'productSearch' => ['except' => ''],
        'selectedProductSearch' => ['except' => ''],
        'categoryFilter' => ['except' => ''],
    ];

    protected function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'status' => ['boolean'],
        ];
    }

    public function updatingCollectionSearch(): void
    {
        $this->resetPage('collectionsPage');
    }

    public function updatingProductSearch(): void
    {
        $this->resetPage('productsPage');
    }

    public function updatingSelectedProductSearch(): void
    {
        $this->resetPage('selectedProductsPage');
    }

    public function updatingCategoryFilter(): void
    {
        $this->resetPage('productsPage');
    }

    public function createCollection(): void
    {
        $data = $this->validate();
        $collection = Collections::query()->create($data);

        $this->selectCollection($collection->id);
        session()->flash('success', 'Koleksiyon oluşturuldu.');
    }

    public function selectCollection(int $collectionId): void
    {
        $collection = Collections::query()->findOrFail($collectionId);

        $this->selectedCollectionId = $collection->id;
        $this->title = $collection->title;
        $this->description = (string) $collection->description;
        $this->status = (bool) $collection->status;

        $this->resetPage('productsPage');
        $this->resetPage('selectedProductsPage');
    }

    public function updateCollection(): void
    {
        if (!$this->selectedCollectionId) {
            return;
        }

        $data = $this->validate();

        Collections::query()->findOrFail($this->selectedCollectionId)->update($data);
        session()->flash('success', 'Koleksiyon güncellendi.');
    }

    public function deleteCollection(int $collectionId): void
    {
        Collections::query()->findOrFail($collectionId)->delete();

        if ($this->selectedCollectionId === $collectionId) {
            $this->resetForm();
        }

        session()->flash('success', 'Koleksiyon silindi.');
    }

    public function addProductToCollection(int $productId): void
    {
        if (!$this->selectedCollectionId) {
            return;
        }

        Collections::query()->findOrFail($this->selectedCollectionId)
            ->products()
            ->syncWithoutDetaching([$productId]);

        session()->flash('success', 'Ürün koleksiyona eklendi.');
    }

    public function removeProductFromCollection(int $productId): void
    {
        if (!$this->selectedCollectionId) {
            return;
        }

        Collections::query()->findOrFail($this->selectedCollectionId)
            ->products()
            ->detach($productId);

        session()->flash('success', 'Ürün koleksiyondan çıkarıldı.');
    }

    public function resetForm(): void
    {
        $this->selectedCollectionId = null;
        $this->title = '';
        $this->description = '';
        $this->status = true;
    }

    public function render()
    {
        $collections = Collections::query()
            ->when($this->collectionSearch !== '', function ($query) {
                $term = trim($this->collectionSearch);
                $query->where('title', 'like', "%{$term}%");
            })
            ->latest('id')
            ->paginate($this->collectionPerPage, ['*'], 'collectionsPage');

        $selectedCollection = null;
        $selectedProductIds = collect();

        if ($this->selectedCollectionId) {
            $selectedCollection = Collections::query()->find($this->selectedCollectionId);
            if ($selectedCollection) {
                $selectedProductIds = $selectedCollection->products()->pluck('products.id');
            }
        }

        $availableProducts = Products::query()
            ->when($selectedProductIds->isNotEmpty(), fn ($query) => $query->whereNotIn('id', $selectedProductIds))
            ->when($this->categoryFilter !== '', fn ($query) => $query->where('category', (int) $this->categoryFilter))
            ->when($this->productSearch !== '', function ($query) {
                $term = trim($this->productSearch);
                $query->where(function ($subQuery) use ($term) {
                    $subQuery->where('title', 'like', "%{$term}%")
                        ->orWhere('product_token', 'like', "%{$term}%");
                });
            })
            ->latest('id')
            ->paginate($this->productPerPage, ['*'], 'productsPage');

        $selectedProducts = Products::query()
            ->whereIn('id', $selectedProductIds)
            ->when($this->selectedProductSearch !== '', function ($query) {
                $term = trim($this->selectedProductSearch);
                $query->where(function ($subQuery) use ($term) {
                    $subQuery->where('title', 'like', "%{$term}%")
                        ->orWhere('product_token', 'like', "%{$term}%");
                });
            })
            ->latest('id')
            ->paginate($this->selectedProductPerPage, ['*'], 'selectedProductsPage');

        $categories = \App\Models\Categories::query()->orderBy('category_title')->get(['id', 'category_title']);

        return view('livewire.admin.collection-manager', compact(
            'collections',
            'selectedCollection',
            'availableProducts',
            'selectedProducts',
            'categories'
        ));
    }
}
