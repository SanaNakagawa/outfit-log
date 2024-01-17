<button {{ $attributes->merge(['class' => 'bg-gray-600 text-white p-2 hover:bg-gray-800 rounded']) }}>
    {{ $slot }}
</button>
