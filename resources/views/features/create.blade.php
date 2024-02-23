<x-app-layout>
    <x-slot name="header">
        {{ __('misc.user') }}
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <section>
                        <header>
                            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                                {{ __('misc.create_feature') }}
                            </h2>
                        </header>

                        <form method="post" action="{{ route('admin.features.store') }}" class="mt-6 space-y-6">
                            @csrf
                            @method('post')

                            <div>
                                <x-input-label for="name" :value="__('misc.name')"/>
                                <x-text-input id="name" name="featureName" type="text" class="mt-1 block w-full"
                                              :value="old('featureName')"  autofocus/>
                                <x-input-error class="mt-2" :messages="$errors->get('featureName')"/>
                            </div>

                            <div>
                                <fieldset>
                                    <legend class="text-base font-semibold leading-6 text-gray-900 dark:text-gray-200">Value</legend>
                                    <div class="mt-4 divide-y divide-gray-200 dark:divide-gray-600 ">
                                        <div class="min-w-0 flex-1 text-sm leading-6">
                                            <label for="feature-active"
                                                   class="select-none font-medium text-gray-900 dark:text-gray-300">Active</label>
                                            <input type="hidden" name="active" value="0">
                                            <input id="feature-active" name="active" type="checkbox" value="1"
                                                   class="rounded dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-orange-600 shadow-sm focus:ring-orange-500 dark:focus:ring-orange-600 dark:focus:ring-offset-gray-800">
                                        </div>
                                    </div>
                                </fieldset>
                            </div>

                            <div class="flex items-center gap-4">
                                <x-primary-button>{{ __('misc.save') }}</x-primary-button>
                            </div>
                        </form>
                    </section>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
