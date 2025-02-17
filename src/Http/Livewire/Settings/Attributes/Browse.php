<?php

namespace Shopper\Framework\Http\Livewire\Settings\Attributes;

use Livewire\Component;
use Livewire\WithPagination;
use Shopper\Framework\Models\Shop\Product\Attribute;
use Shopper\Framework\Traits\WithSorting;

class Browse extends Component
{
    use WithPagination, WithSorting;

    /**
     * Search input.
     *
     * @var string
     */
    public $search;

    /**
     * Custom Livewire pagination view.
     *
     * @return string
     */
    public function paginationView()
    {
        return 'shopper::livewire.wire-pagination-links';
    }

    /**
     * Remove a record to the database.
     *
     * @param  int  $id
     *
     * @throws \Exception
     */
    public function remove(int $id)
    {
        Attribute::query()->find($id)->delete();

        $this->dispatchBrowserEvent('item-removed');

        $this->notify([
            'title' => __('Deleted'),
            'message' => __('The :item has successfully removed!', ['item' => 'attribute']),
        ]);
    }

    public function render()
    {
        return view('shopper::livewire.settings.attributes.browse', [
            'total' => Attribute::query()->count(),
            'attributes' => Attribute::query()
                ->where('name', 'like', '%'. $this->search .'%')
                ->orderBy($this->sortBy ?? 'name', $this->sortDirection)
                ->paginate(8),
        ]);
    }
}
