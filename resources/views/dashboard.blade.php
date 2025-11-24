<x-layouts.app :title="__('Dashboard')">
    <script src="https://kit.fontawesome.com/9d6a4b8185.js" crossorigin="anonymous"></script>
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">

        {{-- Success Message --}}
        @if (session('success'))
            <div class="rounded-lg bg-green-300/60 p-4 text-sm text-black dark:text-white">
                {{ session('success') }}    
            </div>
        @endif
        
        <!-- Stats Cards -->
        <div class="grid auto-rows-min gap-4 md:grid-cols-3">
            <div class="relative overflow-hidden rounded-xl border border-neutral-200 bg-linear-to-r from-neutral-100 via-blue-400 to-blue-700 p-6 dark:border-neutral-700 dark:bg-linear-to-r dark:from-gray-800 dark:via-blue-700 dark:to-blue-400">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-black dark:text-white">Total Books</p>
                        <h3 class="mt-2 text-3xl font-bold text-neutral-900 dark:text-neutral-100">{{ $books->count() }}</h3>
                    </div>
                    <div class="rounded-full bg-indigo-100 p-3 dark:border-neutral-700 dark:bg-blue-800/80">
                        <i class="fa-solid fa-book p-2 h-8 w-8 text-center text-blue-600 dark:text-white"></i>
                    </div>
                </div>
            </div>

            <div class="relative overflow-hidden rounded-xl border border-neutral-200 p-6 dark:border-neutral-700 bg-linear-to-r from-emerald-500 via-teal-500 to-green-500">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-black dark:text-white">Total Categories</p>
                        <h3 class="mt-2 text-3xl font-bold text-neutral-900 dark:text-neutral-100">{{ $categories->count() }}</h3>
                    </div>
                    <div class="rounded-full bg-green-100 p-3 dark:bg-green-800/80">
                        <i class="fa-solid fa-list text-center p-2 h-8 w-8 text-green-600 dark:text-white"></i>
                    </div>
                </div>
            </div>

            <div class="relative overflow-hidden rounded-xl border border-neutral-200 p-6 dark:border-neutral-700 bg-linear-to-r from-pink-500 via-red-500 to-orange-700">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-black dark:text-white">Best Category</p>
                        <h3 class="mt-2 text-3xl font-bold text-neutral-900 dark:text-neutral-100">Fiction</h3>
                    </div>
                    <div class="rounded-full bg-purple-100 p-3 dark:bg-orange-800/80">
                         <i class="fa-solid fa-fire text-center p-2 h-8 w-8 text-orange-600 dark:text-orange-300"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Book Management Section -->
        <div class="relative h-full flex-1 overflow-hidden rounded-xl border border-neutral-200 bg-white dark:border-neutral-700 dark:bg-neutral-800">
            <div class="flex h-full flex-col p-6">
                <!-- Add New Book Form -->
                <div class="mb-6 rounded-lg border border-neutral-200 bg-neutral-50 p-6 dark:border-neutral-700 dark:bg-neutral-900/50">
                    <h2 class="mb-4 text-lg font-semibold text-neutral-900 dark:text-neutral-100">Add New Book</h2>
                    <form action="{{ route('books.store') }}" method="POST" class="grid gap-4 md:grid-cols-2">
                        @csrf
                        <div>
                            <label class="mb-2 block text-sm font-medium text-neutral-700 dark:text-neutral-300">Title</label>
                            <input type="text" name="title" value="{{ old('title') }}" placeholder="Enter book title" required class="w-full rounded-lg border border-neutral-300 bg-white px-4 py-2 text-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/20 dark:border-neutral-600 dark:bg-neutral-800 dark:text-neutral-100">
                            @error('title')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="mb-2 block text-sm font-medium text-neutral-700 dark:text-neutral-300">Author</label>
                            <input type="text" name="author" value="{{ old('author') }}" placeholder="Enter author" required class="w-full rounded-lg border border-neutral-300 bg-white px-4 py-2 text-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/20 dark:border-neutral-600 dark:bg-neutral-800 dark:text-neutral-100">
                            @error('author')
                                <p class="mt-1 text-xs text-red-600"> {{ $message }} </p>
                            @enderror
                        </div>
                        <div>
                            <label class="mb-2 block text-sm font-medium text-neutral-700 dark:text-neutral-300">ISBN</label>
                            <input type="text" name="isbn" value="{{ old('isbn') }}" placeholder="Enter ISBN (10-13 digits)" class="w-full rounded-lg border border-neutral-300 bg-white px-4 py-2 text-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/20 dark:border-neutral-600 dark:bg-neutral-800 dark:text-neutral-100">
                            @error('isbn')
                                <p class="mt-1 text-xs text-red-600"> {{ $message }} </p>
                            @enderror
                        </div>
                        <div>
                            <label class="mb-2 block text-sm font-medium text-neutral-700 dark:text-neutral-300">Publication Year</label>
                            <input type="publication_year" name="publication_year" value="{{ old('category_id') }}" placeholder="Enter Publication Year" class="w-full rounded-lg border border-neutral-300 bg-white px-4 py-2 text-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/20 dark:border-neutral-600 dark:bg-neutral-800 dark:text-neutral-100">
                            @error('publication_year')
                                <p class="mt-1 text-xs text-red-600"> {{ $message }} </p>
                            @enderror
                        </div>
                        <div>
                            <label class="mb-2 block text-sm font-medium text-neutral-700 dark:text-neutral-300">Publisher</label>
                            <input type="text" name="publisher" value="{{ old('publisher') }}" placeholder="Enter Publisher" class="w-full rounded-lg border border-neutral-300 bg-white px-4 py-2 text-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/20 dark:border-neutral-600 dark:bg-neutral-800 dark:text-neutral-100">
                            @error('publisher')
                                <p class="mt-1 text-xs text-red-600"> {{ $message }} </p>
                            @enderror
                        </div>
                        <div>
                            <label class="mb-2 block text-sm font-medium text-neutral-700 dark:text-neutral-300">Page Count</label>
                            <input type="text" name="page_count" value="{{ old('page_count') }}" placeholder="Enter Page Count" class="w-full rounded-lg border border-neutral-300 bg-white px-4 py-2 text-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/20 dark:border-neutral-600 dark:bg-neutral-800 dark:text-neutral-100">
                            @error('page_count')
                                <p class="mt-1 text-xs text-red-600"> {{ $message }} </p>
                            @enderror
                        </div>
                        <div>
                            <label class="mb-2 block text-sm font-medium text-neutral-700 dark:text-neutral-300">Language</label>
                            <input type="text" name="language" value="{{ old('language') }}" placeholder="Enter Language" class="w-full rounded-lg border border-neutral-300 bg-white px-4 py-2 text-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/20 dark:border-neutral-600 dark:bg-neutral-800 dark:text-neutral-100">
                            @error('language')
                                <p class="mt-1 text-xs text-red-600"> {{ $message }} </p>
                            @enderror
                        </div>
                        
                        <div class="md:col-span-1">
                            <label class="mb-2 block text-sm font-medium text-neutral-700 dark:text-neutral-300">Category</label>
                            <select name="category_id" class="w-full rounded-lg border border-neutral-300 bg-white px-4 py-2 text-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/20 dark:border-neutral-600 dark:bg-neutral-800 dark:text-neutral-100">
                                <option value="">Select a Category</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="md:col-span-2">
                            <button type="submit" class="rounded-lg bg-blue-700 px-6 py-2 text-sm font-medium text-white transition-colors hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500/20">
                                Add Book
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Book List Table -->
                <div class="flex-1 overflow-auto">
                    <h2 class="mb-4 text-lg font-semibold text-neutral-900 dark:text-neutral-100">Book List</h2>
                    <div class="overflow-x-auto">
                        <table class="w-full min-w-full">
                            <thead>
                                <tr class="border-b border-neutral-200 bg-neutral-50 dark:border-neutral-700 dark:bg-neutral-900/50">
                                    <th class="px-4 py-3 text-left text-sm font-semibold text-neutral-700 dark:text-neutral-300">#</th>
                                    <th class="px-4 py-3 text-left text-sm font-semibold text-neutral-700 dark:text-neutral-300">Title</th>
                                    <th class="px-4 py-3 text-left text-sm font-semibold text-neutral-700 dark:text-neutral-300">Author</th>
                                    <th class="px-4 py-3 text-left text-sm font-semibold text-neutral-700 dark:text-neutral-300">ISBN</th>
                                    <th class="px-4 py-3 text-left text-sm font-semibold text-neutral-700 dark:text-neutral-300">Publication Year</th>
                                    <th class="px-4 py-3 text-left text-sm font-semibold text-neutral-700 dark:text-neutral-300">Category</th>
                                    <th class="px-4 py-3 text-left text-sm font-semibold text-neutral-700 dark:text-neutral-300">Publisher</th>
                                    <th class="px-4 py-3 text-left text-sm font-semibold text-neutral-700 dark:text-neutral-300">Page Count</th>
                                    <th class="px-4 py-3 text-left text-sm font-semibold text-neutral-700 dark:text-neutral-300">Language</th>
                                    <th class="px-4 py-3 text-left text-sm font-semibold text-neutral-700 dark:text-neutral-300">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-neutral-200 border-neutral-200 border dark:border-neutral-700 dark:divide-neutral-700">
                                @forelse($books as $book)
                                    <tr>
                                        <td class="px-4 py-3 text-sm text-neutral-700 dark:text-neutral-300">{{ $book->id }}</td>
                                        <td class="px-4 py-3 text-sm text-neutral-700 dark:text-neutral-300">{{ $book->title }}</td>
                                        <td class="px-4 py-3 text-sm text-neutral-700 dark:text-neutral-300">{{ $book->author }}</td>
                                        <td class="px-4 py-3 text-sm text-neutral-700 dark:text-neutral-300">{{ $book->isbn }}</td>
                                        <td class="px-4 py-3 text-sm text-neutral-700 dark:text-neutral-300">{{ $book->publication_year }}</td>
                                        <td class="px-4 py-3 text-sm text-center">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-sm font-medium bg-green-100 text-black dark:bg-green-700 dark:text-white">
                                                {{ $book->category->name ?? 'N/A' }}
                                            </span>
                                        </td>
                                        <td class="px-4 py-3 text-sm text-neutral-700 dark:text-neutral-300">{{ $book->publisher }}</td>
                                        <td class="px-4 py-3 text-sm text-neutral-700 dark:text-neutral-300">{{ $book->page_count }}</td>
                                        <td class="px-4 py-3 text-sm text-neutral-700 dark:text-neutral-300">{{ $book->language }}</td>
                                        <td class="px-4 py-3 text-sm text-center border border-neutral-300 dark:border-neutral-700 text-neutral-700 dark:text-neutral-300">
                                            <button onclick="openEditModal({{ $book->id }})" class="text-blue-600 hover:underline transition-colors hover:text-blue-700 dark:text-blue-500 dark:hover:text-blue-400">Edit</button>
                                            {{-- <span class="mx-1 text-neutral-400">|</span> --}}
                                            <button 
                                                onclick="openDeleteModal({{ $book->id }}, '{{ addslashes($book->title) }}')" 
                                                class="text-red-600 transition-colors hover:text-red-700 dark:text-red-400 dark:hover:text-red-300">
                                                Delete
                                            </button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td class="px-4 py-8 text-center text-sm text-neutral-500 dark:text-neutral-400" colspan="6">
                                            No books found. Add your first books above!
                                        </td>
                                    </tr>                                       
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                
                <!-- Edit Book Modal -->
                <div id="editBookModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
                    <div class="bg-white dark:bg-neutral-800 rounded-lg shadow-xl w-full max-w-2xl mx-4">
                        <div class="px-6 py-4 border-b border-neutral-200 dark:border-neutral-700">
                            <h3 class="text-lg font-semibold text-neutral-900 dark:text-neutral-100">Edit Book</h3>
                        </div>
                        <form id="editBookForm" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="p-6 space-y-4 max-h-96 overflow-y-auto">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label for="edit_title" class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1">Title *</label>
                                        <input type="text" id="edit_title" name="title" required
                                            class="w-full px-3 py-2 border border-neutral-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-neutral-700 dark:border-neutral-600 dark:text-white">
                                    </div>
                                    <div>
                                        <label for="edit_author" class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1">Author *</label>
                                        <input type="text" id="edit_author" name="author" required
                                            class="w-full px-3 py-2 border border-neutral-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-neutral-700 dark:border-neutral-600 dark:text-white">
                                    </div>
                                    <div>
                                        <label for="edit_isbn" class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1">ISBN</label>
                                        <input type="text" id="edit_isbn" name="isbn"
                                            class="w-full px-3 py-2 border border-neutral-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-neutral-700 dark:border-neutral-600 dark:text-white">
                                    </div>
                                    <div>
                                        <label for="edit_publication_year" class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1">Publication Year</label>
                                        <input type="number" id="edit_publication_year" name="publication_year" min="1000" max="{{ date('Y') }}"
                                            class="w-full px-3 py-2 border border-neutral-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-neutral-700 dark:border-neutral-600 dark:text-white">
                                    </div>
                                    <div>
                                        <label for="edit_category_id" class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1">Category</label>
                                        <select id="edit_category_id" name="category_id"
                                            class="w-full px-3 py-2 border border-neutral-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-neutral-700 dark:border-neutral-600 dark:text-white">
                                            <option value="">Select Category</option>
                                            @foreach($categories as $category)
                                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div>
                                        <label for="edit_publisher" class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1">Publisher</label>
                                        <input type="text" id="edit_publisher" name="publisher"
                                            class="w-full px-3 py-2 border border-neutral-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-neutral-700 dark:border-neutral-600 dark:text-white">
                                    </div>
                                    <div>
                                        <label for="edit_page_count" class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1">Page Count</label>
                                        <input type="number" id="edit_page_count" name="page_count" min="1"
                                            class="w-full px-3 py-2 border border-neutral-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-neutral-700 dark:border-neutral-600 dark:text-white">
                                    </div>
                                    <div>
                                        <label for="edit_language" class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1">Language</label>
                                        <input type="text" id="edit_language" name="language"
                                            class="w-full px-3 py-2 border border-neutral-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-neutral-700 dark:border-neutral-600 dark:text-white">
                                    </div>
                                </div>
                            </div>
                            <div class="px-6 py-4 border-t border-neutral-200 dark:border-neutral-700 flex justify-end space-x-3">
                                <button type="button" onclick="closeEditModal()"
                                    class="px-4 py-2 text-sm font-medium text-neutral-700 bg-neutral-100 hover:bg-neutral-200 rounded-md transition-colors dark:bg-neutral-700 dark:text-neutral-300 dark:hover:bg-neutral-600">
                                    Cancel
                                </button>
                                <button type="submit"
                                    class="px-4 py-2 text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 rounded-md transition-colors">
                                    Update Book
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Delete Confirmation Modal -->
                <div id="deleteBookModal" class="fixed inset-0 bg-black/50 bg-opacity-50 flex items-center justify-center z-50 hidden">
                    <div class="bg-white dark:bg-neutral-800 rounded-lg shadow-xl w-full max-w-md mx-4">
                        <div class="px-6 py-4 border-b border-neutral-200 dark:border-neutral-700">
                            <h3 class="text-lg font-semibold text-red-600 dark:text-red-400">Delete Book</h3>
                        </div>
                        <div class="p-6">
                            <p class="text-neutral-700 dark:text-neutral-300 mb-4">
                                Are you sure you want to move the book "<span id="deleteBookTitle" class="font-semibold"></span>" to trash?
                            </p>
                            <p class="text-sm text-neutral-500 dark:text-neutral-400 mb-4">
                                This book will be moved to trash and can be restored later.
                            </p>
                        </div>
                        <div class="px-6 py-4 border-t border-neutral-200 dark:border-neutral-700 flex justify-end space-x-3">
                            <button type="button" onclick="closeDeleteModal()"
                                class="px-4 py-2 text-sm font-medium text-neutral-700 bg-neutral-100 hover:bg-neutral-200 rounded-md transition-colors dark:bg-neutral-700 dark:text-neutral-300 dark:hover:bg-neutral-600">
                                Cancel
                            </button>
                            <form id="deleteBookForm" method="POST" class="inline">
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
                // Edit Modal Functions
                function openEditModal(bookId) {
                    // Fetch book data and populate form
                    fetchBookData(bookId);
                    
                    // Set form action
                    document.getElementById('editBookForm').action = `/books/${bookId}`;
                    
                    // Show modal
                    document.getElementById('editBookModal').classList.remove('hidden');
                }

                function closeEditModal() {
                    document.getElementById('editBookModal').classList.add('hidden');
                }

                // Delete Modal Functions
                function openDeleteModal(bookId, bookTitle) {
                    // Set book title in confirmation message
                    document.getElementById('deleteBookTitle').textContent = bookTitle;
                    
                    // Set form action - use the new route
                    document.getElementById('deleteBookForm').action = `/books/${bookId}/delete`;
                    
                    // Show modal
                    document.getElementById('deleteBookModal').classList.remove('hidden');
                }

                function closeDeleteModal() {
                    document.getElementById('deleteBookModal').classList.add('hidden'); 
                }

                // Fetch book data for editing
                async function fetchBookData(bookId) {
                    try {
                        const response = await fetch(`/books/${bookId}/edit`);
                        const book = await response.json();
                        
                        // Populate form fields
                        document.getElementById('edit_title').value = book.title || '';
                        document.getElementById('edit_author').value = book.author || '';
                        document.getElementById('edit_isbn').value = book.isbn || '';
                        document.getElementById('edit_publication_year').value = book.publication_year || '';
                        document.getElementById('edit_category_id').value = book.category_id || '';
                        document.getElementById('edit_publisher').value = book.publisher || '';
                        document.getElementById('edit_page_count').value = book.page_count || '';
                        document.getElementById('edit_language').value = book.language || '';
                        
                    } catch (error) {
                        console.error('Error fetching book data:', error);
                        alert('Error loading book data');
                    }
                }

                // Close modals when clicking outside
                document.addEventListener('click', function(event) {
                    const editModal = document.getElementById('editBookModal');
                    const deleteModal = document.getElementById('deleteBookModal');
                    
                    if (event.target === editModal) {
                        closeEditModal();
                    }
                    if (event.target === deleteModal) {
                        closeDeleteModal();
                    }
                });

                // Close modals with Escape key
                document.addEventListener('keydown', function(event) {
                    if (event.key === 'Escape') {
                        closeEditModal();
                        closeDeleteModal();
                    }
                });
                </script>
            </div>
        </div>
    </div>
</x-layouts.app>
