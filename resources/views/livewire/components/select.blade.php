<div x-data="{ hasValue: @entangle('hasValue').defer }" x-init="$nextTick(() => hasValue = @js($hasValue))" class="relative z-0 w-full mb-6 group">
    <select id="floating_select" aria-label="Floating label select" wire:model="selectedValue"
        @change="hasValue = $event.target.value !== ''" @focus="hasValue = true"
        @blur="hasValue = $event.target.value !== ''"
        class="block pb-0.5 pt-1.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
        style="border-radius: 0 !important;" required>
        <option value="" disabled hidden></option>
        @foreach ($options as $value => $label)
            <option value="{{ $value }}" {{ $selectedValue == $value ? 'selected' : '' }}>
                {{ $label }}
            </option>
        @endforeach
    </select>
    <label for="floating_select"
        :class="{
            'text-sm -translate-y-3 scale-110 top-1/2': !hasValue,
            'text-sm -translate-y-6 scale-75 top-3': hasValue
        }"
        class="absolute text-gray-500 dark:text-gray-400 duration-300 transform origin-[0] transition-all pointer-events-none">
        {{ $field }}
    </label>
</div>
