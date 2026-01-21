@if(Auth::user()->usertype === 'admin' || Auth::user()->usertype === 'manager')
<div class=" h-full w-20 dark:bg-gray-800 ">
    <div class=" p-4">
        <img src="{{ asset('images/utsg.png') }}" height="50" alt="Logo UTSG">
    </div>
    <x-side-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')">
        <img src="{{ asset('icons/home.svg') }}" height="50" alt="Icon home">
    </x-side-link>
    <x-side-link :href="route('admin.user')" :active="request()->routeIs('admin.user')">
        <img src="{{ asset('icons/admin-settings-male.svg') }}" height="50" alt="Icon male">
    </x-side-link>
    <x-side-link :href="route('admin.departemen')" :active="request()->routeIs('admin.departemen')">
        <img src="{{ asset('icons/building.svg') }}" height="50" alt="Icon building">
    </x-side-link>
    <x-side-link :href="route('admin.kategori')" :active="request()->routeIs('admin.kategori')">
        <img src="{{ asset('icons/categorize.svg') }}" height="50" alt="Icon categorize">
    </x-side-link>
    <x-side-link :href="route('admin.periode')" :active="request()->routeIs('admin.periode')">
        <img src="{{ asset('icons/timesheet.svg') }}" height="50" alt="Icon timesheet">
    </x-side-link>
    <x-side-link :href="route('risk.pilih-periode')" :active="request()->routeIs('risk.pilih-periode')">
        <img src="{{ asset('icons/checklist.svg') }}" height="50" alt="Icon checklist">
    </x-side-link>
</div>
@endif