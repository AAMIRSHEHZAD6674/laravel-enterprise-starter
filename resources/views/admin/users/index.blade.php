<x-app-layout>

    <div class="max-w-7xl mx-auto py-6">

        <div class="flex justify-between items-center mb-6">

            <h2 class="text-2xl font-bold">
                User Management
            </h2>

            <a href="{{ route('users.create') }}"
               class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">

                Add User

            </a>

        </div>
        <form method="GET" class="mb-5 flex gap-3">

        <input
            type="text"
            name="search"
            value="{{ request('search') }}"
            placeholder="Search users..."
            class="border rounded px-3 py-2">

        <button
            class="bg-blue-600 text-white px-4 rounded">

            Search

        </button>

    </form>
        <table class="min-w-full border">

            <thead>

                <tr class="bg-gray-100">

                    <th class="border p-3">ID</th>

                    <th class="border p-3">Name</th>

                    <th class="border p-3">Email</th>

                    <th class="border p-3">Role</th>

                    <th class="border p-3">Actions</th>

                </tr>

            </thead>

            <tbody>

                @forelse($users as $user)

                    <tr>

                        <td class="border p-3">{{ $user->id }}</td>

                        <td class="border p-3">{{ $user->name }}</td>

                        <td class="border p-3">{{ $user->email }}</td>

                        <td class="border p-3">
                            {{ $user->getRoleNames()->implode(', ') }}
                        </td>

                        <td class="border p-3">
                            Edit | Delete
                        </td>

                    </tr>

                @empty

                    <tr>

                        <td colspan="5" class="text-center p-5">

                            No users found.

                        </td>

                    </tr>

                @endforelse

            </tbody>

        </table>

        <div class="mt-6">

            {{ $users->links() }}

        </div>

    </div>

</x-app-layout>