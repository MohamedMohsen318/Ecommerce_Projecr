@csrf

<label class="field">
    <span>Parent category</span>
    <select class="select" name="parent_id">
        <option value="">No parent</option>
        @include('admin.categories._category_options', [
            'categories' => $selectCategories,
            'ignoredCategoryId' => $category?->id,
            'selectedCategoryIds' => [(int) old('parent_id', $category->parent_id ?? 0)],
            'level' => 0,
        ])
    </select>
</label>

<label class="checkbox">
    <input type="checkbox" name="is_active" value="1" @checked(old('is_active', $category->is_active ?? true))>
    <span>Active</span>
</label>

<label class="field">
    <span>Name</span>
    <input class="input" type="text" name="translations[en][name]" value="{{ old('translations.en.name', $category?->translate('en')?->name ?? '') }}" required>
</label>

<label class="field">
    <span>Description</span>
    <textarea name="translations[en][description]" rows="3">{{ old('translations.en.description', $category?->translate('en')?->description ?? '') }}</textarea>
</label>

<input type="hidden" name="translations[ar][name]" value="">
<input type="hidden" name="translations[ar][description]" value="">

<label class="field">
    <span>Image</span>
    <input class="input" type="file" name="image" accept="image/*">
</label>

<button class="button" type="submit">{{ $buttonText }}</button>
