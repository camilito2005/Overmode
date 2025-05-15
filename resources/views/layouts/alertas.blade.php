@php

if (!isset($type)) {
    $type = 'Info';
}
    if ($type == "Info") {
        $class = 'text-blue-800 bg-blue-50 dark:bg-gray-800 dark:text-blue-400';
    }
    elseif ($type == "Danger") {
        $class = 'text-red-800 bg-red-50 dark:bg-gray-800 dark:text-red-400';
    }
    elseif ($type == "Success") {
        $class = 'text-green-800 bg-green-50 dark:bg-gray-800 dark:text-green-400';
    }
    elseif ($type == "Warning") {
        $class = 'text-yellow-800 bg-yellow-50 dark:bg-gray-800 dark:text-yellow-300';
    }
    elseif ($type == "Dark") {
        $class = 'text-gray-800 bg-gray-50 dark:bg-gray-800 dark:text-gray-300';
    }
    else {
        $class = '';
    }
@endphp
<div class="p-4 mb-4 text-sm rounded-lg {{$class ?? ''}}" role="alert">
    <span class="font-medium">{{ $title ?? 'Info alert!' }}</span> {{ $message ?? 'Por favor proporciona un mensaje' }}
</div>
