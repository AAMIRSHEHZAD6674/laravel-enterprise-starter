<div class="max-w-7xl mx-auto py-6">

    <div class="flex justify-between items-center mb-6">

        <h2 class="text-2xl font-bold">
            Activity Logs
        </h2>

        <a href="{{ route('users.index') }}"
           class="bg-gray-500 text-white px-4 py-2 rounded">
            Back to Users
        </a>

    </div>

    <div class="overflow-x-auto">

        <table class="min-w-full border">

            <thead>

                <tr class="bg-gray-100">

                    <th class="border p-3">Date</th>
                    <th class="border p-3">User</th>
                    <th class="border p-3">Action</th>
                    <th class="border p-3">Description</th>

                </tr>

            </thead>

            <tbody>

                @forelse($activities as $activity)

                    <tr>

                        <td class="border p-3">
                            {{ $activity->created_at->format('Y-m-d H:i:s') }}
                        </td>

                        <td class="border p-3">
                            {{ $activity->causer?->name ?? 'System' }}
                        </td>

                        <td class="border p-3">
                            {{ ucfirst($activity->event ?? 'Activity') }}
                        </td>

                        <td class="border p-3">
                            {{ $activity->description }}
                        </td>

                    </tr>

                @empty

                    <tr>
                        <td colspan="4"
                            class="border p-5 text-center">
                            No activity found.
                        </td>
                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

    <div class="mt-6">
        {{ $activities->links() }}
    </div>

</div>