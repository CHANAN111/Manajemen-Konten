@props([
    'valid' => true,
])

<input
    type="radio"
    {{
        $attributes
            ->class([
                'fi-radio-input border-none bg-white shadow-sm ring-1 transition duration-75 checked:ring-0 focus:ring-2 focus:ring-offset-0 disabled:bg-gray-50 disabled:text-gray-50 disabled:checked:bg-gray-400 disabled:checked:text-gray-400',
                'text-primary-600 ring-gray-950/10 focus:ring-primary-600 checked:focus:ring-primary-500/50' => $valid,
                'fi-invalid text-danger-600 ring-danger-600 focus:ring-danger-600 checked:focus:ring-danger-500/50' => ! $valid,
            ])
    }}
/>
