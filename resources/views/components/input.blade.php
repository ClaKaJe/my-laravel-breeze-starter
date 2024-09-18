@props([
  'label' => '',
  'type' => 'text',
  'name' => '',
  'icon' => '',
  'model' => '',
  'required' => false,
  'autofocus' => false,
  'class' => ''
])

<x-mary-input label="{{ $label }}" type="{{ $type }}" id="{{ $name }}" class="block mt-1 w-full {{ $class }}" name="{{ $name }}" wire:model="{{ $model }}" placeholder="{{ $label }}" icon="{{ $icon }}" required autofocus autocomplete="{{ $name }}" />