<form method="POST" action="{{ $action }}" {{ $attributes->merge(['class' => 'm-form']) }}>
    @csrf

    @if(in_array($method, ['PUT', 'PATCH', 'DELETE']))
        @method($method)
    @endif

    <div class="m-portlet__body">
        {{ $slot }}
    </div>
    <div class="m-portlet__foot m-portlet__foot--fit">
        <div class="m-form__actions m-form__actions">
            <button type="submit" class="btn btn-primary">{{ $submitLabel ?? 'Submit' }}</button>
            <button type="button" class="btn btn-secondary" onclick="window.location.href='{{ $cancelUrl ?? url()->previous() }}'">{{ $cancelLabel ?? 'Cancel' }}</button>
        </div>
    </div>
</form>
