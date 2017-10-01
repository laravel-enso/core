@php
$polyfills = collect([
    'Promise',
    'Object.assign',
    'Object.values',
    'Array.prototype.find',
    'Array.prototype.findIndex',
    'Array.prototype.includes',
    'String.prototype.includes',
    'String.prototype.startsWith',
    'String.prototype.endsWith'
])->implode(',');
@endphp

<script src="https://cdn.polyfill.io/v2/polyfill.min.js?features={{ $polyfills }}"></script>