@php $user = $user ?? null; @endphp
<div class="grid gap-5 sm:grid-cols-2">
    <x-field :label="__('admin.users.name')" for="name" error="name">
        <x-input name="name" :value="old('name', $user?->name)" required />
    </x-field>
    <x-field :label="__('admin.users.email')" for="email" error="email">
        <x-input name="email" type="email" :value="old('email', $user?->email)" required />
    </x-field>
    <x-field :label="__('admin.users.password')" for="password" error="password" :hint="$user ? __('admin.users.password_hint') : null">
        <x-input name="password" type="password" :required="! $user" />
    </x-field>
    <x-field :label="__('admin.users.role')" for="role" error="role">
        <x-select name="role">
            @foreach ($roles as $role)
                <option value="{{ $role->value }}" @selected(old('role', $user?->role?->value) === $role->value)>{{ $role->label() }}</option>
            @endforeach
        </x-select>
    </x-field>
</div>
@if ($user)
    <div class="mt-5">
        <x-toggle name="banned" :checked="(bool) $user->banned_at" :label="__('admin.users.banned')" />
    </div>
@endif
<div class="mt-6 flex gap-2">
    <x-button type="submit">{{ __('common.save') }}</x-button>
    <x-button :href="route('admin.users.index')" variant="ghost">{{ __('common.cancel') }}</x-button>
</div>
