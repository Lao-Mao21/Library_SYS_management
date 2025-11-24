<x-layouts.app :title="__('Categories')">
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">

        @if(session('success'))
            <div class="rounded-lg bg-green-100 p-4 text-green-700 dark:bg-green-900/30 dark:text-green-300">
                {{ session('success') }}
            </div>
        @endif

        <div class="relative h-full flex-1 overflow-hidden rounded-xl border border-neutral-200 bg-white dark:border-neutral-700 dark:bg-neutral-800">
            <div class="flex h-full flex-col p-6">

                <div class="mb-6 rounded-lg border border-neutral-200 bg-neutral-50 p-6 dark:border-neutral-700 dark:bg-neutral-900/50">
                    <h2 class="mb-4 text-lg font-semibold text-neutral-900 dark:text-neutral-100">Add New Category</h2>

                    <form action="{{ route('categories.store') }}" method="POST" class="space-y-4">
                        @csrf

                        <div class="grid gap-4 md:grid-cols-3">
                            <div>
                                <label class="mb-2 block text-sm font-medium text-neutral-700 dark:text-neutral-300">Category Name</label>
                                <input type="text" name="name" value="{{ old('name') }}"
                                       placeholder="Enter category name" required
                                       class="w-full rounded-lg border border-neutral-300 bg-white px-4 py-2 text-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/20 dark:border-neutral-600 dark:bg-neutral-800 dark:text-neutral-100">
                                @error('name')
                                    <p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                                <form method="POST" action="{{ route('categories.store') }}">
                            </div>

                            <div class="md:col-span-2">
                                <label class="mb-2 block text-sm font-medium text-neutral-700 dark:text-neutral-300">Description</label>
                                <textarea name="description" rows="1" placeholder="Enter category description"
                                          class="w-full rounded-lg border border-neutral-300 bg-white px-4 py-2 text-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/20 dark:border-neutral-600 dark:bg-neutral-800 dark:text-neutral-100">{{ old('description') }}</textarea>
                                @error('description')
                                    <p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="flex justify-end">
                            <button type="submit" class="rounded-lg bg-blue-600 px-6 py-2 text-sm font-medium text-white transition-colors hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500/20">
                                Add Category
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Category List Table -->
                <div class="flex-1 overflow-auto">
                    <h2 class="mb-4 text-lg font-semibold text-neutral-900 dark:text-neutral-100">Category List</h2>
                    <div class="overflow-x-auto">
                        <table class="w-full min-w-full">
                            <thead>
                                <tr class="border-b border-neutral-200 bg-neutral-50 dark:border-neutral-700 dark:bg-neutral-900/50">
                                    <th class="px-4 py-3 text-center text-sm font-semibold text-neutral-700 dark:text-neutral-300">#</th>
                                    <th class="px-4 py-3 text-center text-sm font-semibold text-neutral-700 dark:text-neutral-300">Category Name</th>
                                    <th class="px-4 py-3 text-center text-sm font-semibold text-neutral-700 dark:text-neutral-300">Description</th>
                                    <th class="px-4 py-3 text-center text-sm font-semibold text-neutral-700 dark:text-neutral-300">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-neutral-200 dark:divide-neutral-700 border-r border-l border-neutral-200 dark:border-neutral-700">
                                @forelse($categories as $category)
                                    <tr class="transition-colors hover:bg-neutral-50 dark:hover:bg-neutral-800/50" id="category-row-{{ $category->id }}">
                                        <td class="px-4 py-3 text-center text-sm text-neutral-600 dark:text-neutral-400">{{ $loop->iteration }}</td>
                                        <td class="px-4 py-3 text-center text-sm text-neutral-900 dark:text-neutral-100">
                                            <span class="category-name-display">{{ $category->name }}</span>
                                        </td>
                                        <td class="px-4 py-3 text-center text-sm text-neutral-600 dark:text-neutral-400">
                                            <span class="category-description-display">{{ Str::limit($category->description, 50) ?? 'N/A' }}</span>
                                        </td>
                                        <td>
                                            <button onclick="openEditCategoryModal({{ $category->id }})" 
                                                    class="text-blue-600 hover:text-blue-700">
                                                Edit
                                            </button>
                                            <span>|</span>
                                            <button onclick="openDeleteCategoryModal({{ $category->id }}, '{{ addslashes($category->name) }}')"
                                                    class="text-red-600 hover:text-red-700">
                                                Delete
                                            </button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-4 py-8 text-center text-sm text-neutral-500 dark:text-neutral-400">
                                            No categories found. Add your first category above!
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Edit Category Modal -->
                <div id="editCategoryModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50">
                    <div class="w-full max-w-2xl rounded-xl border border-neutral-200 bg-white p-6 dark:border-neutral-700 dark:bg-neutral-800">
                        <h2 class="mb-4 text-lg font-semibold text-neutral-900 dark:text-neutral-100">Edit Category</h2>

                        <form id="editCategoryForm" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="grid gap-4 md:grid-cols-2">
                                <div class="md:col-span-2">
                                    <label for="edit_category_name" class="mb-2 block text-sm font-medium text-neutral-700 dark:text-neutral-300">Category Name</label>
                                    <input type="text" id="edit_category_name" name="name" required
                                        class="w-full rounded-lg border border-neutral-300 bg-white px-4 py-2 text-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/20 dark:border-neutral-600 dark:bg-neutral-800 dark:text-neutral-100">
                                </div>

                                <div class="md:col-span-2">
                                    <label for="edit_description" class="mb-2 block text-sm font-medium text-neutral-700 dark:text-neutral-300">Description</label>
                                    <textarea id="edit_description" name="description" rows="3"
                                            class="w-full rounded-lg border border-neutral-300 bg-white px-4 py-2 text-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/20 dark:border-neutral-600 dark:bg-neutral-800 dark:text-neutral-100"></textarea>
                                </div>
                            </div>

                            <div class="mt-6 flex justify-end gap-3">
                                <button type="button" onclick="closeEditCategoryModal()"
                                        class="rounded-lg border border-neutral-300 px-4 py-2 text-sm font-medium text-neutral-700 transition-colors hover:bg-neutral-100 dark:border-neutral-600 dark:text-neutral-300 dark:hover:bg-neutral-700">
                                    Cancel
                                </button>
                                <button type="submit"
                                        class="rounded-lg bg-blue-600 px-4 py-2 text-sm font-medium text-white transition-colors hover:bg-blue-700">
                                    Update Category
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Delete Confirmation Modal -->
                <div id="deleteCategoryModal" class="fixed inset-0 bg-black/50 flex items-center justify-center z-50 hidden">
                    <div class="bg-white dark:bg-neutral-800 rounded-lg shadow-xl w-full max-w-md mx-4">
                        <div class="px-6 py-4 border-b border-neutral-200 dark:border-neutral-700">
                            <h3 class="text-lg font-semibold text-red-600 dark:text-red-400">Delete Category</h3>
                        </div>
                        <div class="p-6">
                            <p class="text-neutral-700 dark:text-neutral-300 mb-4">
                                Are you sure you want to move the category "<span id="deleteCategoryName" class="font-semibold"></span>" to trash?
                            </p>
                            <p class="text-sm text-neutral-500 dark:text-neutral-400 mb-4">
                                This category will be moved to trash and can be restored later.
                            </p>
                        </div>
                        <div class="px-6 py-4 border-t border-neutral-200 dark:border-neutral-700 flex justify-end space-x-3">
                            <button type="button" onclick="closeDeleteCategoryModal()"
                                class="px-4 py-2 text-sm font-medium text-neutral-700 bg-neutral-100 hover:bg-neutral-200 rounded-md transition-colors dark:bg-neutral-700 dark:text-neutral-300 dark:hover:bg-neutral-600">
                                Cancel
                            </button>
                            <form id="deleteCategoryForm" method="POST" class="inline">
                                @csrf
                                @method('POST')
                                <button type="submit"
                                    class="px-4 py-2 text-sm font-medium text-white bg-red-600 hover:bg-red-700 rounded-md transition-colors">
                                    Move to Trash
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <script>
                // Edit Category Functions
                async function openEditCategoryModal(categoryId) {
                    try {
                        console.log('Fetching category data for ID:', categoryId);
                        
                        // Fetch category data from the edit route
                        const response = await fetch(`/categories/${categoryId}/edit`);
                        
                        if (!response.ok) {
                            throw new Error('Failed to fetch category data');
                        }
                        
                        const category = await response.json();
                        console.log('Category data received:', category);
                        
                        // Populate form fields with fetched data
                        document.getElementById('edit_category_name').value = category.name || '';
                        document.getElementById('edit_description').value = category.description || '';
                        
                        // Set form action for UPDATE
                        document.getElementById('editCategoryForm').action = `/categories/${categoryId}`;
                        
                        // Show modal
                        document.getElementById('editCategoryModal').classList.remove('hidden');
                        document.getElementById('editCategoryModal').classList.add('flex');
                        
                    } catch (error) {
                        console.error('Error fetching category data:', error);
                        alert('Error loading category data: ' + error.message);
                    }
                }

                function closeEditCategoryModal() {
                    document.getElementById('editCategoryModal').classList.add('hidden');
                    document.getElementById('editCategoryModal').classList.remove('flex');
                }

                // Delete Category Functions
                function openDeleteCategoryModal(categoryId, categoryName) {
                    // Set category name in confirmation message
                    document.getElementById('deleteCategoryName').textContent = categoryName;
                    
                    // Set form action
                    document.getElementById('deleteCategoryForm').action = `/categories/${categoryId}/delete`;
                    
                    // Show modal
                    document.getElementById('deleteCategoryModal').classList.remove('hidden');
                }

                function closeDeleteCategoryModal() {
                    document.getElementById('deleteCategoryModal').classList.add('hidden');
                }

                // Close modals when clicking outside
                document.addEventListener('click', function(event) {
                    const editModal = document.getElementById('editCategoryModal');
                    const deleteModal = document.getElementById('deleteCategoryModal');
                    
                    if (event.target === editModal) {
                        closeEditCategoryModal();
                    }
                    if (event.target === deleteModal) {
                        closeDeleteCategoryModal();
                    }
                });

                // Close modals with Escape key
                document.addEventListener('keydown', function(event) {
                    if (event.key === 'Escape') {
                        closeEditCategoryModal();
                        closeDeleteCategoryModal();
                    }
                });
                </script>
            </div>
        </div>
    </div>    
</x-layouts.app>