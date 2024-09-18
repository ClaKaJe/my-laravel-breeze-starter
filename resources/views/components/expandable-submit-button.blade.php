@props([
  'icon' => 's-arrow-left-end-on-rectangle',
])

<x-mary-button label="{{ $slot }}" icon="{{ $icon }}" type="submit" class="bg-blue-500 text-white w-full mt-6" />
