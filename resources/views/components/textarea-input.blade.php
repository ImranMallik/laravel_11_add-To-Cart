<div>
    <!-- The biggest battle is the war against ignorance. - Mustafa Kemal Atatürk -->
    <textarea class="{{ $class ?? 'form-control' }}" name="{{ $name ?? '' }}" id="{{ $id ?? '' }}"
        rows="{{ $rows ?? 5 }}" {{ $attributes }}>{{ $slot }}</textarea>

</div>
