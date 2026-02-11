@props([
    'headers' => [],
    'striped' => false,
    'hoverable' => true
])

<div class="table-container">
    <table {{ $attributes->merge(['class' => 'table' . ($striped ? ' table-striped' : '')]) }}>
        @if(count($headers) > 0)
            <thead>
                <tr>
                    @foreach($headers as $header)
                        <th>{{ $header }}</th>
                    @endforeach
                </tr>
            </thead>
        @elseif(isset($head))
            <thead>
                {{ $head }}
            </thead>
        @endif

        <tbody>
            {{ $slot }}
        </tbody>

        @if(isset($foot))
            <tfoot>
                {{ $foot }}
            </tfoot>
        @endif
    </table>
</div>
