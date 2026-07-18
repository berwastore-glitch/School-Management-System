@props(['status'])

@if ($status)
    <div {{ $attributes->merge(['class' => 'alert-success-custom']) }}>
        {{ $status }}
    </div>
@endif
