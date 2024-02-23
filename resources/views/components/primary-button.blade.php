<button {{ $attributes->merge(['type' => 'submit', 'class' => "inline-flex items-center gap-x-1.5 rounded-md bg-orange-500 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-orange-400 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-orange-600"]) }}>
    {{ $slot }}
</button>
