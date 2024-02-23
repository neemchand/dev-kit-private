<x-app-layout>
    <x-slot name="header">
        {{ __('misc.features') }}
    </x-slot>

    @if($notification = session('notification'))
        <x-slot name="notification">
            <x-notification-simple :type="$notification->type" :title="$notification->title"
                                   :description="$notification->description"/>
        </x-slot>
    @endif

    <div class="py-4">
        <div class="px-4 sm:px-6 lg:px-8">
            <div class="sm:flex sm:items-center">
                <div class="sm:flex-auto">
                    <h1 class="text-base font-semibold leading-6 text-gray-900 dark:text-gray-100">List</h1>
                    <p class="mt-2 text-sm text-gray-700 dark:text-gray-300">A list of all the users.</p>
                </div>
                <div class="mt-4 sm:ml-16 sm:mt-0 sm:flex-none">
                    <a href="{{ route('admin.features.create') }}"
                       class="inline-flex items-center gap-x-1.5 block rounded-md bg-orange-600 px-3 py-2 text-center text-sm font-semibold text-white shadow-sm hover:bg-orange-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-orange-600">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
                            <path
                                    d="M11 5a3 3 0 11-6 0 3 3 0 016 0zM2.615 16.428a1.224 1.224 0 01-.569-1.175 6.002 6.002 0 0111.908 0c.058.467-.172.92-.57 1.174A9.953 9.953 0 018 18a9.953 9.953 0 01-5.385-1.572zM16.25 5.75a.75.75 0 00-1.5 0v2h-2a.75.75 0 000 1.5h2v2a.75.75 0 001.5 0v-2h2a.75.75 0 000-1.5h-2v-2z"/>
                        </svg>
                        Add feature
                    </a>
                </div>
            </div>
            <div class="mt-8 flow-root">
                <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                    <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                        <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 sm:rounded-lg">
                            <table class="min-w-full divide-y divide-gray-300 dark:divide-gray-700">
                                <thead class="bg-gray-50 dark:bg-gray-700">
                                <tr>
                                    <x-th-sortable title="Flag name" field="flag_name"></x-th-sortable>
                                    <x-th-sortable title="Active" field="active"></x-th-sortable>
                                    @can('edit features')
                                        <x-th-sortable title="" field="active"></x-th-sortable>
                                        <x-th-sortable title="" field="active"></x-th-sortable>
                                    @endcan
                                </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200 dark:divide-gray-700 bg-white dark:bg-gray-800">
                                @foreach ($features as $featureName => $featureValue)
                                    <tr class="even:bg-gray-50 dark:even:bg-gray-900">
                                        <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 dark:text-gray-200 sm:pl-6">
                                            {{ $featureName }}
                                        </td>
                                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500 dark:text-gray-200">
                                            <x-bullet-boolean :condition="$featureValue" success="Enabled"
                                                              fail="Disabled"></x-bullet-boolean>
                                        </td>
                                        @can('edit features')
                                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500 dark:text-gray-200">

                                                <a href="#" x-data=""
                                                   x-on:click.prevent="$dispatch('open-modal', 'confirm-feature-toggle-{{$featureName}}')"
                                                   class="text-gray-400 hover:text-red-600 px-2 inline-flex">
                                                    <span
                                                            class="inline-flex items-center rounded-md bg-gray-50 dark:bg-gray-700 px-2 py-1 text-xs font-medium text-gray-500 dark:text-gray-400 ring-1 ring-inset ring-gray-600/20">
                                                    {{ $featureValue ? 'Disable' : 'Enable' }}
                                                    </span>
                                                </a>
                                                <x-modal name="confirm-feature-toggle-{{$featureName}}"
                                                         focusable>
                                                    <form method="post"
                                                          action="{{ route('admin.features.toggle') }}"
                                                          class="p-6">
                                                        <input type="hidden" name="featureName"
                                                               value="{{ $featureName }}">
                                                        @csrf
                                                        @method('post')

                                                        <h2 class="text-lg font-medium text-center text-gray-900 dark:text-gray-100">
                                                            {{ __("messages.feature.toggle_confirmation") }}
                                                        </h2>
                                                        <p class="my-5 p-6 text-lg text-center text-gray-600 dark:text-gray-400">
                                                            {{$featureName}}
                                                        </p>

                                                        <div class="mt-6 flex justify-end">
                                                            <x-secondary-button x-on:click="$dispatch('close')">
                                                                {{ __('misc.cancel') }}
                                                            </x-secondary-button>

                                                            <x-danger-button class="ml-3">
                                                                {{ __('misc.confirm') }}
                                                            </x-danger-button>
                                                        </div>
                                                    </form>
                                                </x-modal>
                                            </td>
                                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500 dark:text-gray-200">
                                                <a href="#" x-data=""
                                                   x-on:click.prevent="$dispatch('open-modal', 'confirm-feature-deletion-{{$featureName}}')"
                                                   class="text-gray-400 hover:text-red-600 px-2 inline-flex">
                                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                                         fill="currentColor" class="w-5 h-5">
                                                        <path fill-rule="evenodd"
                                                              d="M8.75 1A2.75 2.75 0 006 3.75v.443c-.795.077-1.584.176-2.365.298a.75.75 0 10.23 1.482l.149-.022.841 10.518A2.75 2.75 0 007.596 19h4.807a2.75 2.75 0 002.742-2.53l.841-10.52.149.023a.75.75 0 00.23-1.482A41.03 41.03 0 0014 4.193V3.75A2.75 2.75 0 0011.25 1h-2.5zM10 4c.84 0 1.673.025 2.5.075V3.75c0-.69-.56-1.25-1.25-1.25h-2.5c-.69 0-1.25.56-1.25 1.25v.325C8.327 4.025 9.16 4 10 4zM8.58 7.72a.75.75 0 00-1.5.06l.3 7.5a.75.75 0 101.5-.06l-.3-7.5zm4.34.06a.75.75 0 10-1.5-.06l-.3 7.5a.75.75 0 101.5.06l.3-7.5z"
                                                              clip-rule="evenodd"/>
                                                    </svg>
                                                </a>
                                                <x-modal name="confirm-feature-deletion-{{$featureName}}" focusable>
                                                    <form method="post"
                                                          action="{{ route('admin.features.destroy') }}"
                                                          class="p-6">
                                                        <input type="hidden" name="featureName"
                                                               value="{{ $featureName }}">
                                                        @csrf
                                                        @method('delete')

                                                        <h2 class="text-lg font-medium text-center text-gray-900 dark:text-gray-100">
                                                            {{ __("messages.feature.remove_feature_confirmation") }}
                                                        </h2>
                                                        <p class="my-5 p-6 text-lg text-center text-gray-600 dark:text-gray-400">
                                                            {{$featureName}}
                                                        </p>

                                                        <div class="mt-6 flex justify-end">
                                                            <x-secondary-button x-on:click="$dispatch('close')">
                                                                {{ __('misc.cancel') }}
                                                            </x-secondary-button>

                                                            <x-danger-button class="ml-3">
                                                                {{ __('misc.delete_feature') }}
                                                            </x-danger-button>
                                                        </div>
                                                    </form>
                                                </x-modal>
                                            </td>
                                        @endcan
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>
