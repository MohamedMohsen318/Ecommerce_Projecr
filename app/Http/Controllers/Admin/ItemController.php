<?php

namespace App\Http\Controllers\Admin;

use App\Enums\ItemStatus;
use App\Http\Controllers\Controller;
use App\Models\Item;
use App\Services\Admin\ItemService;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    public function __construct(
        protected ItemService $itemService
    ) {}

    public function index()
    {
        $items = $this->itemService->getAll();

        return view('admin.items.index', compact('items'));
    }

    public function create()
    {
        $statuses = ItemStatus::cases();

        return view('admin.items.create', compact('statuses'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'price' => ['required', 'numeric', 'min:0'],
            'stock' => ['required', 'integer', 'min:0'],
            'status' => ['required', 'in:' . implode(',', ItemStatus::values())],
        ]);

        $this->itemService->create($data);

        return redirect()
            ->route('admins.items.index')
            ->with('success', 'Product created successfully.');
    }

    public function edit(Item $item)
    {
        $statuses = ItemStatus::cases();

        return view('admin.items.edit', compact('item', 'statuses'));
    }

    public function update(Request $request, Item $item)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'price' => ['required', 'numeric', 'min:0'],
            'stock' => ['required', 'integer', 'min:0'],
            'status' => ['required', 'in:' . implode(',', ItemStatus::values())],
        ]);

        $this->itemService->update($item, $data);

        return redirect()
            ->route('admins.items.index')
            ->with('success', 'Product updated successfully.');
    }

    public function destroy(Item $item)
    {
        $this->itemService->delete($item);

        return back()->with('success', 'Product deleted successfully.');
    }
}
