<x-app-layout>

<div class="max-w-4xl mx-auto py-6">

<h2 class="text-2xl font-bold mb-6">
Create User
</h2>

<form action="{{ route('users.store') }}" method="POST">

@csrf

<div class="mb-4">
<label>Name</label>
<input
type="text"
name="name"
class="border rounded w-full p-2"
required>
</div>

<div class="mb-4">
<label>Email</label>
<input
type="email"
name="email"
class="border rounded w-full p-2"
required>
</div>

<div class="mb-4">
<label>Password</label>
<input
type="password"
name="password"
class="border rounded w-full p-2"
required>
</div>

<div class="mb-4">
<label>Confirm Password</label>
<input
type="password"
name="password_confirmation"
class="border rounded w-full p-2"
required>
</div>

<div class="mb-4">
<label>Role</label>

<select
name="role"
class="border rounded w-full p-2">

@foreach($roles as $role)

<option value="{{ $role }}">
{{ $role }}
</option>

@endforeach

</select>

</div>

<button
class="bg-blue-600 text-white px-5 py-2 rounded">

Save User

</button>

</form>

</div>

</x-app-layout>