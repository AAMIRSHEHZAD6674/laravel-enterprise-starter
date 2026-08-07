<x-app-layout>

    <div class="max-w-7xl mx-auto py-6">

        <div class="flex justify-between items-center mb-6">

            <h2 class="text-2xl font-bold">
                User Management
            </h2>

            <div class="flex gap-2">

                @can('create', App\Models\User::class)
                    <a href="{{ route('users.create') }}"
                    class="bg-blue-600 text-white px-4 py-2 rounded">
                        Create User
                    </a>
                @endcan
                @can('activity_logs.view')
                    <a href="{{ route('activity-logs.index') }}"
                    class="bg-gray-700 text-black px-4 py-2 rounded">
                    Activity Logs
                    </a>
                @endcan
                <a href="{{ route('users.trash') }}"
                class="bg-red-600 text-white px-4 py-2 rounded">
                    Trash
                </a>

            </div>

        </div>
<form method="GET" class="mb-5 flex gap-3">

    <input
        type="text"
        name="search"
        value="{{ request('search') }}"
        placeholder="Search users..."
        class="border rounded px-3 py-2"
    >

    <select name="role" class="border rounded px-3 py-2">
        <option value="">All Roles</option>

        @foreach($roles as $role)
            <option
                value="{{ $role->name }}"
                @selected(request('role') === $role->name)
            >
                {{ $role->name }}
            </option>
        @endforeach
    </select>

    <select name="status" class="border rounded px-3 py-2">
        <option value="">All Status</option>

        <option value="1" @selected(request('status') === '1')>
            Active
        </option>

        <option value="0" @selected(request('status') === '0')>
            Inactive
        </option>
    </select>

    <button
        type="submit"
        class="bg-blue-600 text-white px-4 py-2 rounded">
        Search
    </button>

    <a
        href="{{ route('users.index') }}"
        class="bg-gray-500 text-white px-4 py-2 rounded">
        Reset
    </a>

    </form>
        <table class="min-w-full border">

            <thead>

                <tr class="bg-gray-100">

                    <th class="border p-3">ID</th>

                    <th class="border p-3">Name</th>

                    <th class="border p-3">Email</th>

                    <th class="border p-3">Role</th>

                    <th class="border p-3">Status</th>

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

                        @if($user->status)
                                <span class="text-green-600 font-semibold">Active</span>
                            @else
                                <span class="text-red-600 font-semibold">Inactive</span>
                            @endif
                        </td>

                        <td class="border p-3">
                           @can('update', $user)
                                <a href="{{ route('users.edit', $user) }}"
                                class="text-blue-600 hover:underline">
                                    Edit
                                </a>
                            @endcan
                            @can('delete', $user)

                                <form action="{{ route('users.destroy', $user) }}"
                                    method="POST"
                                    class="inline">

                                    @csrf
                                    @method('DELETE')

                                    <button
                                        onclick="return confirm('Delete this user?')"
                                        class="text-red-600 hover:underline">

                                        Delete

                                    </button>

                                </form>

                                @endcan
                                
                                @can('update', $user)

                                <form
                                    action="{{ route('users.toggleStatus', $user) }}"
                                    method="POST"
                                    class="inline"
                                >

                                    @csrf
                                    @method('PATCH')

                                    @if($user->status)

                                        <button
                                            type="submit"
                                            onclick="return confirm('Deactivate this user?')"
                                            class="text-orange-600 hover:underline"
                                        >
                                            Deactivate
                                        </button>

                                    @else

                                        <button
                                            type="submit"
                                            class="text-green-600 hover:underline"
                                        >
                                            Activate
                                        </button>

                                    @endif

                                </form>

                            @endcan
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