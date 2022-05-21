<x-admin-layout>
    <div class="max-w-xl mx-auto">
        <div class="card bg-white">
            <div class="card-body">
                <h2 class="card-title font-semibold text-2xl mb-6">Create Account</h2>
                <form method="post" enctype="multipart/form-data" action="{{route('admin.users.store')}}">
                    @csrf
                    <div class="form-control mb-3">
                        <x-label value="Last Name" class="mb-2" />
                        <x-input type="text" placeholder="Last Name" name="last_name" required autofocus />
                    </div>
                    <div class="form-control mb-3">
                        <x-label value="First Name" class="mb-2" />
                        <x-input type="text" placeholder="First Name" name="first_name" required />
                    </div>
                    <div class="form-control mb-3">
                        <x-label value="Email" class="mb-2" />
                        <x-input type="email" placeholder="Email Address" name="email" required />
                    </div>
                    <div class="form-control mb-3">
                        <x-label value="Phone" class="mb-2" />
                        <x-input type="tel" placeholder="Phone" name="phone" autofocus />
                    </div>
                    <div class="form-control mb-3">
                        <x-label value="Password" class="mb-2" />
                        <x-input type="password" placeholder="Password" name="password" required />
                    </div>
                    <div class="form-control mb-3">
                        <x-label value="User Role" class="mb-2" />
                        <x-select class="w-full mb-2" name="role">
                            <option disabled="disabled" selected="selected">Choose Role</option>
                            @foreach($roles as $role)
                                <option value="{{ $role->name }}">{{ $role->name }}</option>
                            @endforeach
                        </x-select>
                    </div>

                    <div class="bg-gray-50 py-3 flex justify-center space-x-3">
                        <x-button type="submit" class="btn-primary btn-block">Add User</x-button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</x-admin-layout>
