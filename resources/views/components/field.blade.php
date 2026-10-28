@props(['name', 'label', 'type'=> 'text', 'value' => '', 'autocomplete' => null])

<div>
    <label for="{{ $name }}" class="block text-xs font-semibold uppercase tracking-wider text-white/80">{{ $label}}</label>
    <input id="{{ $name }}" name="{{ $name }}" type="{{ $type }}" value="{{ $value }}" {{ $autocomplete ? "autocomplete={$autocomplete}" : "" }}
        value="{{ $type === 'password' ? '' : old($name, $value) }}"
        @if ($autocomplete) autocomplete="{{ $autocomplete }}" @endif
        class="mt-2 block w-full rounded-md border bg-navy-800/60 px-4 py-3 text-white placeholder-white/40 focus:border-brand-400 focus:outline-non focus:ring-brand-400/40 @error($name) border-red-400 @else border-white/15 @enderror">
        @error($name)
         <p class="mt-1 text-sm text-red-300">{{ $message }}</p>
         @enderror
</div>